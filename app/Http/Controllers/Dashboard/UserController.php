<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{

    public function datatableColumns()
    {
        return  [
            [
                'data' => '#',
                'name' => '#',
                'orderable' => true,
            ],
            // [
            //     'data' => 'profile_photo_path',
            //     'name' => 'profile_photo_path',
            // ],
            [
                'data' => 'name',
                'name' => 'name',
            ],
            [
                'data' => 'email',
                'name' => 'email',
            ],
            [
                'data' => 'actions',
                'name' => 'actions',
            ],
        ];
    }

    public function addColumns($dataTable)
    {
        // return $dataTable
        //     ->addColumn('profile_photo_path', function ($row) {
        //         $data['image'] = $row['profile_photo_path'];
        //         return view('components.BaseComponents.layout.crud.parts.image', $data)->render();
        //     });
    }
    public $rawColumns = [
        'profile_photo_path'
    ];


    //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////


    // public function tableOptions_actions()
    // public function tableOptions_filters()
    public function tableOptions()
    {
        return [
            'actions' => [
                'route_show' => 'dashboard.user.show',
                'route_create' => 'dashboard.user.create',
                'route_edit' => 'dashboard.user.edit',
                'route_destroy' => 'dashboard.user.destroy',
                'route_force_delete' => 'dashboard.user.force-delete',
                'route_restore' => 'dashboard.user.restore',
                'configs' => [
                    'with_soft_delete' => true,
                    'with_multi_delete' => false,
                    'with_exports' => true,
                    'show_modal' => false,
                    'edit_modal' => false,
                ]
            ],
            ///////////////////////////////
            'filters' => [
                'text_filters' => [
                    ['name' => 'name', 'label' => 'filter by name', 'cols' => '3'],
                    ['name' => 'email', 'label' => 'filter by email', 'cols' => '3'],
                ],
                'select_filters' => [
                    // [
                    //     'name' => 'is_active', 'cols' => '3', 'default_option' => 'Filter By Activation', 'options' => [
                    //         [
                    //             'option_value' => '1',
                    //             'option_label' => 'Active',
                    //         ],
                    //         [
                    //             'option_value' => '0',
                    //             'option_label' => 'Not Active',
                    //         ],
                    //     ]
                    // ],
                ],
                'select_relation_filters' => [
                    // [
                    //     'name' => 'user_id', 'cols' => '3', 'default_option' => 'Filter By User', 'options' => [
                    //         'value_attr' => 'id',
                    //         'label_attr' => 'name',
                    //     ],
                    //     'query' => User::get(['id', 'name']),
                    // ],
                ]
            ],
        ];
    }

    //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////


    public function formData()
    {
        return [
            'name', 'email', 'password',
            // ['profile_photo_path', 'image']
        ];
    }


    public function store(Request $request)
    {
        $request->validate($this->getRequest()->rules(), $this->getRequest()->messages());
        $model = $this->getModel()::create($this->setCreateAttributes($request));


        $model->assignRole('user'); // Assign the default role to the user


        if (!$model) {
            return response()->json(['type' => 'error', 'message' => __('common.somthing_went_wrong')], 400);
        }
        return response()->json(['type' => 'success', 'message' => __('common.created_successfully', ['model' => __($this->resourceName())])], 200);
    }


    public function setCreateResource($request)
    {
        return [
            'password' => Hash::make($request->password),
        ];
    }
    public function setUpdateResource($request, $old_image)
    {
        return [
            // 'slug' => slug($request->name),
        ];
    }
}
