<?php

namespace App\Http\Controllers;

use App\Clients;
use App\Tasks;
use App\Types;
use App\Statuses;

use Illuminate\Http\Request;

class TasksController extends Controller
{
    const BACK_ADDRESS = '/tasks/';

    protected $arTasks;

    public function __construct()
    {
        $this->arTasks = $this->prepareTasks();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $arFilter = $request->toArray();

        $arTasks = $this->prepareTasks($arFilter);

        return view('tasks')
            ->with('tasks', $arTasks)
            ->with('filters', [
                'types' => Types::all()->toArray(),
                'statuses' => Statuses::all()->toArray(),
            ]);
    }

    public function show(int $id)
    {
        $task = $this->getTask($id);

        $source = (!empty($task) ? $task->toArray() : '');

        return view('task')->with('task', $source);
    }

    public function delete(int $id)
    {
        $task = Tasks::find($id);
        if ($task) {
            $task->delete($id);
        }

        return redirect(self::BACK_ADDRESS);
    }

    private function prepareTasks(array $arFilter = []): array
    {
        $arTasks = [];

        $obTasks = new Tasks();
        if (empty($arFilter)
            || (!empty($arFilter['type']) && ($arFilter['type'] == 'all'))
            || (!empty($arFilter['status']) && ($arFilter['status'] == 'all'))) {
                $taskList = $obTasks->all()->toArray();
        } else {
            if (!empty($arFilter['type'])) {
                $tasks = $obTasks->where('types_id', '=', $arFilter['type']);
            }

            if (!empty($arFilter['status'])) {
                $tasks = $obTasks->where('statuses_id', '=', $arFilter['status']);
            }
            $taskList = $tasks->get()->toArray();
        }

        foreach ($taskList as $t => $task) {
            $arTasks[$t] = $task;

            $obTask = Tasks::find($task['id']);

            $arTasks[$t]['client'] = $obTask->clients()->first()->toArray();
            $arTasks[$t]['status'] = $obTask->statuses()->first()->toArray();
        }

        return $arTasks;
    }

    /**
     * Возвращает объект task
     *
     * @param int $id
     * @return array
     */
    public function getTask(int $id)
    {
        return Tasks::find($id);
    }

    public function getTaskByClientId(int $id)
    {
        $arTask = null;

        $obTask = Tasks::where('clients_id', '=', $id)->first();
        if ($obTask !== null) {
            $arTask = $obTask;
        }

        return $arTask;
    }

}
