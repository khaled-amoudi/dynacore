<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class SettingController extends Controller
{
    public function index(){
        // $socials = Setting::where('group' , '=' , 'SOCIAL_MEDIA')->get();
        // $modes = Setting::where('group' , '=' , 'MODE')->get();
        // $faqs_array = Setting::where('group', '=', 'FAQ')->first();
        // $faqs = isset($faqs_array) ? json_decode($faqs_array->data) : null;

        $this->authorize('settings');

        return view('settings');
    }


    public function update(Request $request) {
        // validation
        $this->authorize('settings');
        // update cookies

        $dashboard_language = $request->dashboard_language;
        if($dashboard_language != App::currentLocale()) {
            Cookie::queue('dynacore_locale', $dashboard_language, 15768000); // 6 monthes
            App::setLocale($dashboard_language);
        }

        $accordion_status = $request->accordion_status;
        if(Cookie::get('dynacore_accordion_status') != $accordion_status || (!Cookie::get('dynacore_accordion_status'))) {
            Cookie::queue('dynacore_accordion_status', $accordion_status, 15768000); // 6 monthes
        }


        // update database settings table

        // return response
        return response()->json(['type' => 'success', 'message' => __('common.updated_successfully', ['model' => __('settings')])], 200);
    }

    // public function store(Request $request)
    // {
    //     $facebook = $request->facebook ?? null;
    //     $instagram = $request->instagram ?? null;
    //     $twitter = $request->twitter ?? null;

    //     $data = [];
    //     if(isset($facebook)) {
    //         $data['facebook'] = $facebook;
    //     }
    //     if(isset($instagram)) {
    //         $data['instagram'] = $instagram;
    //     }
    //     if(isset($twitter)) {
    //         $data['twitter'] = $twitter;
    //     }

    //     foreach($data as $key => $value) {
    //         Setting::where('key', $key)->first()->update([
    //             'value' => $value
    //         ]);
    //     }

    //     //////////////////////////////////////
    //     $data = [
    //         'questions' => $request->input('questions'),
    //         'answers' => $request->input('answers')
    //     ];
    //     $jsonData = json_encode($data);

    //     if(isset($data['questions'], $data['answers'])) {
    //         Setting::updateOrCreate(['group' => 'FAQ'], [
    //             'data' => $jsonData,
    //         ]);
    //     } else {
    //         Setting::where('group', '=', 'FAQ')->first()->update([
    //             'data' => NULL,
    //         ]);
    //     }
    //     return redirect()->route('dashboard.setting.index')->with('success', 'Settings Updated Successfully');
    // }
}
