<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Types;

class TypesController extends Controller
{
    const BACK_ADDRESS = '/types/';

    public function index()
    {
        return view('types')->with('types', Types::all());
    }

    public function new()
    {
        return view('type_create');
    }

    public function show(int $id)
    {
        $type = Types::find($id)->toArray();

        return view('type')->with('type', $type);
    }

    public function create(Request $request)
    {
        $arRequest = $request->toArray();

        $obTypes = new Types();
        $obTypes->fill(
            $arRequest
        );
        $obTypes->save();

        return redirect(self::BACK_ADDRESS);
    }

    public function update(Request $request)
    {
        $arRequest = $request->toArray();

        $arRequest['id'] = intval($arRequest);

        $obType = Types::find($request['id']);
        $obType->fill(
            $arRequest
        );
        $obType->update();

        return redirect(self::BACK_ADDRESS);
    }

    public function delete(int $id)
    {
        $type = Types::find($id);
        if ($type) {
            $type->delete($id);
        }

        return redirect(self::BACK_ADDRESS);
    }
}
