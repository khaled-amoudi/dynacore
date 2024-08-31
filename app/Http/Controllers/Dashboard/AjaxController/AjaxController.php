<?php

namespace App\Http\Controllers\Dashboard\AjaxController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AjaxController extends Controller
{
    public function verifyRules(Request $request)
    {
        $validator = Validator::make($request->rowData, $request->rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }
    public function getOptions(Request $request)
    {
        // $value = $request->input('value');

        // Perform your logic here to get the data based on $value
        // $data = [
        //     1 => 'New Option 1',
        //     2 => 'New Option 2',
        //     3 => 'New Option 3',
        // ];
        $data = Category::pluck('name', 'id')->toArray();

        return response()->json($data);
    }

    public function get_category_select(Request $request)
    {
        $data = Category::pluck('name', 'id')->toArray();

        return response()->json($data);
    }
}
