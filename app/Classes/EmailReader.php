<?php
namespace App\Classes;

use App\Http\Controllers\TasksController;
use App\Tasks;
use App\Settings;
use App\Clients;
use App\Statuses;
use App\Types;
use Illuminate\Database\Eloquent\RelationNotFoundException;

/**
 * Класс получает письма из почтового ящика и парсит данные
 *
 * Class EmailReader
 * @package App\Classes
 */
class EmailReader
{
    /**
     * Хранит настройки системы
     * @var
     */
    private $arSettings = [];

    /**
     * Хранит объяект подключения к почте, результат работы функции imap_open
     *
     * @var resource
     */
    private $imapObject;

    /**
     * Хранит ошибки
     *
     * @var array|null
     */
    private $errors = [];

    private $clients;

    private $statuses;

    private $types;

    public function __construct()
    {
        $arSettings = Settings::all()->toArray();
        if (!empty($arSettings)) {
            foreach ($arSettings as $setting) {
                $this->arSettings[$setting['name']] = $setting;
            }
        }

        $error = null;

        try {
            $queryLine = $this->buildQuery();

            $this->imapObject = imap_open($queryLine, $this->arSettings['login']['value'], $this->arSettings['password']['value'], 1,0, [OP_READONLY => true]);
        } catch (\Throwable $t) {
            $this->errors[] = $t->getMessage();
        }

        $this->clients = Clients::all()->toArray();

        $this->statuses = Statuses::all()->toArray();

        $this->types = Types::all()->toArray();
    }

    /**
     * Формирует запрос в почту для поиска писем
     *
     * @return string
     */
    private function buildQuery()
    {
        $strResult = '';

        try {
            $strResult = '';
            if (!empty($this->arSettings)
                && isset($this->arSettings['server']['value'])
                && isset($this->arSettings['port']['value'])
                && isset($this->arSettings['folder']['value'])) {
                    $strResult = '{imap.' . $this->arSettings['server']['value'] . ':' .
                                            $this->arSettings['port']['value'] . '/imap/ssl}' .
                                            $this->arSettings['folder']['value'];
            } else {
                throw new \Exception;
            }
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }

        return $strResult;
    }

    /**
     * Обрабатывает строку темы письма, выбирает имя клиента из строки.
     * Наименование клиента является разделителем.
     * Возвращает наименование клиента
     *
     * @param string $subject
     * @param Clients|null $client
     * @param array $arrParams
     * @return array
     */
    private function parseSubjectData(string $string)
    {
        $arData = [];

        foreach ($this->clients as $client) {
            if (preg_match('/' . $client['name'] . '/', $string)) {
                $arData['client'] = $client;
                break;
            }
        }

        if (!empty($arData)) {
            foreach ($this->statuses as $status) {
                if (preg_match('/' . $status['name'] . '/', $string)) {
                    $arData['status'] = $status;
                }
            }

            foreach ($this->types as $type) {
                if (preg_match('/' . $type['name'] . '/', $string)) {
                    $arData['type'] = $type;
                }
            }
        }

        return $arData;
    }

    /**
     * Читает данные из почты
     *
     * @return array
     */
    private function readMail(): array
    {
        $arrResult = [];
        $messageNums = imap_num_msg($this->imapObject);

        if ($messageNums !== false) {
            for ($mailItem = 1; $mailItem <= $messageNums; ++$mailItem) {
                try {
                    $mailHead = (array) current(imap_fetch_overview($this->imapObject, $mailItem));

                    $subjectString = '';
                    $subject = imap_mime_header_decode($mailHead['subject']);
                    foreach ($subject as $s => $sub) {
                        $subjectString .= $sub->text;
                    }

                    if ($subjectString) {
                        $arParse = $this->parseSubjectData($subjectString);

                        if ($arParse['client'] && $arParse['status'] && $arParse['type']) {
                            //$arrResult['subject'] = $subjectString;
                            $arrResult[$mailItem]['head'] = imap_fetchheader($this->imapObject, $mailItem, FT_INTERNAL);
                            $arrResult[$mailItem]['body'] = imap_fetchbody($this->imapObject, $mailItem, 1);
                            $arrResult[$mailItem]['prev'] = preg_replace('/\r\n/', '', imap_fetchbody($this->imapObject, $mailItem, 1));
                            $arrResult[$mailItem]['attach'] = $this->fetchAttachment($mailItem);
                            //$arrResult[$mailItem]['source'] = preg_replace('/\r\n/', '', $this->fetchAttachment($mailItem))[0];
                            $arrResult[$mailItem]['data'] = $mailHead;
                            $arrResult[$mailItem]['client'] = $arParse['client'];
                            $arrResult[$mailItem]['status'] = $arParse['status'];
                            $arrResult[$mailItem]['type'] = $arParse['type'];
                            //$arrResult['data'] = $arParse;
                        }
                    }
                } catch (\Exception $e) {
                    $this->errors[] = $e->getMessage();
                }
            }
        }

        $this->close();

        return $arrResult;
    }

    /**
     * Парсит вложения
     *
     * @param int $mailItem
     * @return array
     */
    private function fetchAttachment(int $mailItem): string
    {
        $result = '';

        $dir = $_SERVER['DOCUMENT_ROOT'] . '/attachments/' . date('Y-m-d');
        if (!file_exists($dir)) {
            mkdir($dir, 0700);
        }

        $filetypes = [0];
        $structure = imap_fetchstructure($this->imapObject, $mailItem);
        if (isset($structure->parts)) {
            for ($j = 1, $f = 2; $j < count($structure->parts); $j++, $f++) {
                if (in_array($structure->parts[$j]->subtype, $filetypes)) {
                    $mailData = [];
                    $mailData[$mailItem]["attachs"][$j]["name"] = $structure->parts[$j]->parameters[0]->value;

                    if (preg_match('/' . $this->arSettings['attach_name']['value'] . '/', $mailData[$mailItem]["attachs"][$j]["name"])) {
                        $mailData[$mailItem]["attachs"][$j]["file"] = $this->structureEncoding(
                            $structure->parts[$j]->encoding,
                            imap_fetchbody($this->imapObject, $mailItem, $f)
                        );

                        if (!file_exists($dir . '/' . $mailData[$mailItem]["attachs"][$j]["name"])) {
                            file_put_contents($dir . '/' . $mailData[$mailItem]["attachs"][$j]["name"], $mailData[$mailItem]["attachs"][$j]["file"]);
                        }

                        if (file_exists($dir . '/' . $mailData[$mailItem]["attachs"][$j]["name"])) {
                            $zip = new \ZipArchive;
                            $file = $dir . '/' . $mailData[$mailItem]["attachs"][$j]["name"];
                            $res = $zip->open($file);
                            if ($res === true) {
                                $zip->extractTo($dir);
                                $zip->close();

                                $exclude = ['.', '..'];
                                $extensions = ['html', 'htm'];
                                $dh = opendir($dir);
                                while (($fileName = readdir($dh)) !== false) {
                                    if (!in_array($fileName, $exclude)) {
                                        $ext = preg_replace('/.+[.]/', '', $fileName);
                                        if (in_array($ext, $extensions)) {
                                            $result = file_get_contents($dir . '/' . $fileName);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Преобразует данные в зависимости от кодировки
     *
     * @param $encoding
     * @param $body
     * @return string
     */
    function structureEncoding($encoding, $body) {
        switch ((int) $encoding) {
            case 4:
                $body = imap_qprint($body);

                break;
            case 3:
                $body = imap_base64($body);

                break;
            case 2:
                $body = imap_binary($body);

                break;
            case 1:
                $body = imap_8bit($body);

                break;
            case 0:
                $body = $body;

                break;
            default:
                $body = "";

                break;
        }

        return $body;
    }

    /**
     * Закрывает подключение к почтовому серверу
     */
    private function close()
    {
        imap_close($this->imapObject);
    }

    /**
     * Метод выполняет загрузка данных в базу данных
     *
     * @param $arData
     */
    private function fillIssues(array $arData)
    {
        $arTasks = Tasks::all()->toArray();
        $arClients = Clients::all()->toArray();

        $obStatus = new Statuses();
        $missedStatus = $obStatus
            ->where('identity', '=', 'bg-info')
            ->first()
            ->toArray();

        foreach ($arClients as $client) {
            foreach ($arTasks as $task) {
                if ($task['clients_id'] == $client['id']) {
                    switch ($task['types_id']) {
                        case $client['period_update_type']:
                            if ((time() - strtotime($task['updated_at'])) >= $client['period_update']) {
                                $obTask = Tasks::find($task['id']);
                                $obTask->fill([
                                    'statuses_id' => $missedStatus['id'],
                                ]);

                                $obTask->update();
                            }

                            break;
                        case $client['period_execute_type']:
                            if ((time() - strtotime($task['updated_at'])) >= $client['period_execute']) {
                                $obTask = Tasks::find($task['id']);
                                $obTask->fill([
                                    'statuses_id' => $missedStatus['id'],
                                ]);

                                $obTask->update();
                            }

                            break;
                        case $client['period_copy_type']:
                            if ((time() - strtotime($task['updated_at'])) >= $client['period_copy']) {
                                $obTask = Tasks::find($task['id']);
                                $obTask->fill([
                                    'statuses_id' => $missedStatus['id'],
                                ]);

                                $obTask->update();
                            }

                            break;
                    }
                }
            }
        }

        if (false) {
            foreach ($arData as $d => $dataItem) {
                try {
                    if (($dataItem['client']['active'])) {
                        foreach ($this->types as $type) {
                            if ($dataItem['type']['name'] == $type['name']) {
                                $explode = null;
                                foreach ($dataItem['client'] as $f => $field) {
                                    if ($field == $type['id']) {
                                        $explode = explode('_', $f);
                                        break;
                                    }
                                }

                                if ($explode) {
                                    if ((time() - $dataItem['data']['udate']) >= $dataItem['client'][$explode[0] . '_' . $explode[1]]) {
                                        $obTask = new Tasks();
                                        $tasks = $obTask
                                            ->where('clients_id', '=', $dataItem['client']['id'])
                                            //->where('statuses_id', '=', $dataItem['status']['id'])
                                            ->where('types_id', '=', $type['id'])
                                            ->get()->toArray();

                                        if (empty($tasks)) {
                                            $obTask->fill([
                                                'prev' => $dataItem['prev'],
                                                'source' => $dataItem['attach'],
                                                'types_id' => $dataItem['type']['id'],
                                                'statuses_id' => $dataItem['status']['id'],
                                                'clients_id' => $dataItem['client']['id'],
                                            ]);

                                            $obTask->save();
                                        } else {
                                            foreach ($tasks as $task) {
                                                $obTask = Tasks::find($task['id']);
                                                $obTask->fill([
                                                    //'id' => $task['id'],
                                                    'prev' => $dataItem['prev'],
                                                    'source' => $dataItem['attach'],
                                                    'types_id' => $dataItem['type']['id'],
                                                    'statuses_id' => $dataItem['status']['id'],
                                                    'clients_id' => $dataItem['client']['id'],
                                                    'updated_at' => time(),
                                                ]);

                                                $obTask->save();
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if (false) {
                            $obTask = new TasksController();
                            $task = $obTask->getTaskByClientId($dataItem['client']['id']);
                            if (empty($task)) {
                                $ob = new Tasks();

                                $ob->fill([
                                    'prev' => $dataItem['prev'],
                                    'source' => $dataItem['source'],
                                    'statuses_id' => $dataItem['status']['id'],
                                    'clients_id' => $dataItem['client']['id'],
                                ]);

                                $ob->save();
                            } else {
                                $obTask = $task->first();
                                $obTask->source = $dataItem['source'];
                                $obTask->prev = $dataItem['prev'];
                                $obTask->statuses_id = $dataItem['status']['id'];
                                $obTask->clients_id = $dataItem['client']['id'];
                                $obTask->updated_at = time();

                                $obTask->update();
                            }
                        }
                    }
                } catch (RelationNotFoundException $r) {
                    $this->errors[] = $r;
                }
            }
        }
    }

    /**
     * Метод запускает процесс получения данных и их загрузки в базу данных
     */
    public function Execute()
    {
        if (empty($this->errors)) {
            $arData = $this->readMail();
            if ($arData) {
                $this->fillIssues($arData);
            }
        }
    }
}
