<?php

namespace App\Core\CoreStubs;

use App\Http\Controllers\BaseController;

class CoreController extends BaseController
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
            //     'data' => 'title',
            //     'name' => 'title',
            // ],
            [
                'data' => 'actions',
                'name' => 'actions',
            ],
        ];
    }

    public function addColumns($dataTable)
    {
        // return $dataTable
        //     ->addColumn('image', function ($row) {
        //         $data['image'] = $row['image'];
        //         return view('components.BaseComponents.layout.crud.parts.image', $data)->render();
        //     })

        //     ->addColumn('is_active', function ($row) {
        //         $data['id'] = $row['id'];
        //         $data['is_active'] = $row['is_active'];
        //         return view('components.BaseComponents.layout.crud.parts.switcher', $data)->render();
        //     });
    }
    public $rawColumns = [
        // 'image', 'is_active', 'status'
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
                'route_show' => 'dashboard.core.show',
                'route_create' => 'dashboard.core.create',
                'route_edit' => 'dashboard.core.edit',
                'route_destroy' => 'dashboard.core.destroy',
                'route_force_delete' => 'dashboard.core.force-delete',
                'route_restore' => 'dashboard.core.restore',
                'configs' => [
                    'with_soft_delete' => true,
                    'with_multi_delete' => true,
                    'with_exports' => true,
                    'with_trans_switcher' => !empty(app($this->getModel())->getTranslatableOptions()),
                    'show_modal' => false,
                    'edit_modal' => false,
                ]
            ],
            ///////////////////////////////
            'filters' => [
                'text_filters' => [
                    // ['name' => 'title', 'label' => 'filter by title', 'cols' => '3'],
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
            // 'title_en', 'title_ar', ['is_active', 'switch'], ['image', 'image']
        ];
    }


    public function setCreateResource($request)
    {
        return [
            // 'slug' => slug($request->name),
        ];
    }
    public function setUpdateResource($request, $old_image)
    {
        return [
            // 'slug' => slug($request->name),
        ];
    }
}
