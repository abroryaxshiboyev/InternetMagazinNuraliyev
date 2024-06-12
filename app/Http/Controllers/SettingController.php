<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Http\Resources\SettingResource;

class SettingController extends Controller
{
    public function index()
    {
        return $this->response(SettingResource::collection(Setting::all()));
    }

    public function store(StoreSettingRequest $request)
    {
        //
    }

    public function show(Setting $setting)
    {
        //
    }

    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        //
    }

    public function destroy(Setting $setting)
    {
        //
    }
}
