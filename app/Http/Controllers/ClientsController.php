<?php

namespace App\Http\Controllers;

use App\Clients;
use App\Settings;
use App\Types;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class ClientsController extends Controller
{
    const BACK_ADDRESS = '/clients/';

    /**
     * Соответствие полей и описаний
     *
     * @var array
     */
    private $arFields = [
        'id' => "id",
        'name' => "Наименование",
        'period_update' => 'Частота обновления',
        'period_execute' => 'Частота выполнения',
        'period_copy' => 'Частота копирования',
        'period_update_measure' => 'Единица обновления',
        'period_execute_measure' => 'Единица выполнения',
        'period_copy_measure' => 'Единица копирования',
        'period_update_type' => 'Единица обновления тип',
        'period_execute_type' => 'Единица выполнения тип',
        'period_copy_type' => 'Единица копирования тип',
        'active' => 'Активность',
        'select' => [
            'y' => 'год',
            'm' => 'месяц',
            'd' => 'день',
            'h' => 'час',
            'i' => 'минута',
            's' => 'секунда',
        ]
    ];

    public function index()
    {
        $arClients['clients'] = Clients::all()->toArray();
        foreach ($this->arFields['select'] as $s => $field) {
            $arClients['fields'][$s] = substr($field, 0, 6);
        }

        return view('clients')->with('clients', $arClients);
    }

    public function show(int $id)
    {
        $client = $this->getClient($id);
        $types = Types::all()->toArray();

        return view('client')
            ->with('client', $client)
            ->with('types', $types);
    }

    public function new()
    {
        $arTypes = Types::all()->toArray();

        return view('client_create')->with('types', $arTypes);
    }

    public function create(Request $request)
    {
        try {
            $arFill = [];

            $arBoolFields = [
                'active',
            ];

            $validate = $this->validate($request, [
                '_token' => 'required',
                'name' => 'required',
                'period_update' => 'required',
                'period_copy' => 'required',
                'period_execute' => 'required',
                'period_update_measure' => 'required',
                'period_copy_measure' => 'required',
                'period_execute_measure' => 'required',
                'period_update_type' => 'required',
                'period_copy_type' => 'required',
                'period_execute_type' => 'required',
            ]);

            $request = $request->toArray();
            $valide = [];
            foreach ($request as $v => $val) {
                if (!in_array($v, $arBoolFields)) {
                    $valide[$v] = $val;
                }
            }

            if ($validate != $valide) {
                throw new Exception();
            }

            $arIntFields = [
                'period_update_type',
                'period_copy_type',
                'period_execute_type',
            ];

            foreach ($request as $f => $fill) {
                if (in_array($f, $arIntFields)) {
                    $fill = intval($fill);
                }

                if (in_array($f, $arBoolFields)) {
                    $fill = (int) (bool) $fill;
                }

                $arFill[$f] = $fill;
            }

            $obClients = new Clients();
            $newClient = $obClients->fill($arFill);

            if ($newClient->save()) {
                return redirect(self::BACK_ADDRESS);
            } else {
                return view('clients_error');
            }
        } catch (\Exception $e) {
            return view('clients_error')->with('message', $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $request = $request->toArray();
            if (!isset($request['active'])) {
                $request = array_merge($request, ['active' => 0]);
            } else {
                $request = array_merge($request, ['active' => 1]);
            }

            $request['period_update_type'] = intval($request['period_update_type']);
            $request['period_execute_type'] = intval($request['period_execute_type']);
            $request['period_copy_type'] = intval($request['period_copy_type']);

            $client = Clients::find($request['id']);
            if ($client) {
                $client->fill($request);
                $client->update();
            }

            $error = null;
        } catch (\Throwable $t) {
            $error = $t;
        } finally {
            if (!$error) {
                return redirect(self::BACK_ADDRESS);
            } else {
                return view('clients_error');
            }
        }
    }

    public function delete(int $id)
    {
        try {
            $client = Clients::find($id);
            $client->delete();
        } catch (\Exception $e) {
            return view('clients_error');
        } finally {
            return redirect(self::BACK_ADDRESS);
        }
    }

    private function getClient(int $id)
    {
        $arClient = [];

        $obClient = new Clients();
        $client = $obClient->where('id', '=', $id)->first()->toArray();
        foreach ($client as $r => $item) {
            if (!empty($this->arFields[$r])) {
                $arClient[$r] = [
                    'name' => $r,
                    'text' => $this->arFields[$r],
                    'value' => $item,
                ];
            }
        }

        $arClient['select'] = $this->arFields['select'];

        return $arClient;
    }
}
