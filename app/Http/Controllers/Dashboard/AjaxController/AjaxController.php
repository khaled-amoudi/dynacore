<?php

namespace App\Http\Controllers\Dashboard\AjaxController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getOptions(Request $request)
    {
        // $value = $request->input('value');

        // Perform your logic here to get the data based on $value
        $data = [
            ['value' => '1', 'label' => 'Option 1'],
            ['value' => '2', 'label' => 'Option 2'],
            ['value' => '3', 'label' => 'Option 3'],
        ];

        return response()->json($data);
    }
}
