<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;

class CategoryController extends BaseController
{

    public function datatableColumns()
    {
        return [
            [
                'data' => '#',
                'name' => '#',
                'orderable' => true,
            ],
            [
                'data' => 'image',
                'name' => 'image',
            ],
            [
                'data' => 'name',
                'name' => 'name',
            ],
            [
                'data' => 'description',
                'name' => 'description',
                'defaultContent' => 'defaultContent when = null',
            ],
            [
                'data' => 'is_active',
                'name' => 'is_active',
            ],
            [
                'data' => 'actions',
                'name' => 'actions',
            ],
        ];
    }

    // custom columns in datatable
    public function addColumns($dataTable)
    {
        return $dataTable->addColumn('image', function ($row) {
            $data['image'] = $row['image'];
            return view('components.BaseComponents.layout.crud.parts.image', $data)->render();
        })->addColumn('is_active', function ($row) {
            $data['id'] = $row['id'];
            $data['is_active'] = $row['is_active'];
            return view('components.BaseComponents.layout.crud.parts.switcher', $data)->render();
        });
    }
    public $rawColumns = ['image', 'is_active'];




    public function tableOptions()
    {
        return [
            'actions' => [
                'route_show' => 'dashboard.category.show',
                'route_create' => 'dashboard.category.create',
                'route_edit' => 'dashboard.category.edit',
                'route_destroy' => 'dashboard.category.destroy',
                'route_force_delete' => 'dashboard.category.force-delete',
                'route_restore' => 'dashboard.category.restore',
                'configs' => [
                    'with_soft_delete' => true,
                    'with_multi_delete' => true,
                    'with_exports' => true,
                    'with_trans_switcher' => true,
                ]
            ],
            ///////////////////////////////
            'filters' => [
                'text_filters' => [
                    ['name' => 'name', 'label' => 'filter by name', 'cols' => '3'],
                    ['name' => 'description', 'label' => 'filter by description', 'cols' => '3'],
                ],
                'select_filters' => [
                    [
                        'name' => 'is_active', 'label' => 'is_active', 'cols' => '3', 'default_option' => 'filter by is_active', 'options' => [
                            [
                                'option_value' => '1',
                                'option_label' => 'active',
                            ],
                            [
                                'option_value' => '0',
                                'option_label' => 'not active',
                            ],
                        ]
                    ],
                ],
            ],
        ];
    }


    //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////


    // used when collect data from form to axios (useForm)
    public function formData()
    {
        return [
            'name', 'description', ['is_active', 'switch'],
            ['image', 'image'],
            // ['tags', 'array']
        ];
    }



    public function setCreateResource($request)
    {
        return [
            'slug' => slug($request->name),
        ];
    }
    public function setUpdateResource($request, $old_image)
    {
        return [
            'slug' => slug($request->name),
        ];
    }
}
