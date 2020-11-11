<?php

namespace App\Http\Controllers;

use App\Http\Middleware\VerifyCsrfToken;
use App\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected $settings;

    public function __construct()
    {
        $this->settings = new Settings();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings')->with('settings', Settings::all());
    }

    public function update(Request $request)
    {
        try {
            $arRequest = $request->toArray();

            if (!isset($arRequest['debug_mode'])) {
                $arRequest['debug_mode'] = '0';
            }

            foreach ($arRequest as $s => $setting) {
                if ($s !== '_token') {
                    $obSetting = new Settings();
                    $element = $obSetting->where('name', '=', $s)->first()->toArray();
                    $id = Settings::find($element['id']);
                    if ($id) {
                        $id->fill(['value' => $setting]);
                        $id->save();
                    }
                }
            }

            $error = null;
        } catch (\Throwable $t) {
            $error = $t->getMessage();
        } finally {
            return redirect('/settings/');
        }

        return redirect('/settings/');
    }
}
