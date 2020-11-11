<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statuses;

class StatusesController extends Controller
{
    const BACK_ADDRESS = '/statuses/';

    public function index()
    {
        return view('statuses')->with('statuses', Statuses::all());
    }

    public function show(int $id)
    {
        $status = Statuses::find($id)->toArray();

        return view('status')->with('status', $status);
    }

    public function update(Request $request)
    {
        $arRequest = $request->toArray();
        $arUpdate = [
            'id' => $arRequest['id'],
            'name' => $arRequest['name'],
            'identity' => $arRequest['identity'],
        ];

        $obStatus = Statuses::find($arRequest['id']);
        $obStatus->fill($arUpdate);
        $obStatus->update();

        return redirect(self::BACK_ADDRESS);
    }

    public function new()
    {
        return view('status_create');
    }

    public function create(Request $request)
    {
        $arRequest = $request->toArray();

        $obStatus = new Statuses();
        $obStatus->fill(
            $arRequest
        );
        $obStatus->save();

        return redirect(self::BACK_ADDRESS);

    }

    public function delete(int $id)
    {
        $status = Statuses::find($id);
        if ($status) {
            $status->delete($id);
        }

        return redirect(self::BACK_ADDRESS);
    }
}
