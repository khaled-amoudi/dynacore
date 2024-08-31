<?php

namespace App\Core\CoreStubs;

use App\Http\Controllers\BaseController;

class CoreController extends BaseController
{

    public function createFormBuilder($model)
    {
        return [
            // [
            //     'formtype' => 'input',
            //     'name' => 'title_en',
            //     'id' => 'title_en',
            //     'label' => 'title_en',
            //     'placeholder' => 'enter title_en',
            //     'type' => 'text',
            //     'value' => $model['title_en'],
            //     'required' => true,
            //     'condition' => null,
            //     'cols' => '6',
            // ],
            // [
            //     'formtype' => 'input',
            //     'name' => 'title_ar',
            //     'id' => 'title_ar',
            //     'label' => 'title_ar',
            //     'placeholder' => 'enter title_ar',
            //     'type' => 'text',
            //     'value' => $model['title_ar'],
            //     'required' => true,
            //     'condition' => null,
            //     'cols' => '6',
            // ],
            // [
            //     'formtype' => 'textarea',
            //     'name' => 'description_en',
            //     'id' => 'description_en',
            //     'label' => 'description_en',
            //     'placeholder' => 'enter description_en',
            //     'value' => $model['description_en'],
            //     'required' => 'required',
            //     'condition' => null,
            //     'rows' => '3',
            //     'cols' => '12'
            // ],
            // [
            //     'formtype' => 'textarea',
            //     'name' => 'description_ar',
            //     'id' => 'description_ar',
            //     'label' => 'description_ar',
            //     'placeholder' => 'enter description_ar',
            //     'value' => $model['description_ar'],
            //     'required' => 'required',
            //     'condition' => null,
            //     'rows' => '3',
            //     'cols' => '12'
            // ],
            // [
            //     'formtype' => 'select',
            //     'name' => 'first_select',
            //     'id' => 'first_select',
            //     'label' => 'first_select',
            //     'value' => '',
            //     'options' => [
            //         1 => 'option 1',
            //         2 => 'option 2',
            //         3 => 'option 3',
            //     ],
            //     'get' => [
            //         'ajax' => route('dashboard.ajax.getOptions'),
            //         'select' => [
            //             'status',
            //         ],
            //     ],
            //     'searchable' => true,
            //     'allow_clear' => true,
            //     'cols' => '6',
            //     'condition' => null
            // ],
            // [
            //     'formtype' => 'select',
            //     'name' => 'status',
            //     'id' => 'status',
            //     'label' => 'status',
            //     'value' => $model['status'],
            //     'options' => [
            //         '0' => 'pinned',
            //         '1' => 'published',
            //         '2' => 'blocked',
            //     ],
            //     'searchable' => true,
            //     'allow_clear' => true,
            //     'cols' => '6',
            //     'condition' => null
            // ],
            // [
            //     'formtype' => 'switch',
            //     'name' => 'is_active',
            //     'id' => 'is_active',
            //     'label' => 'is_active',
            //     'placeholder' => 'is_active',
            //     'value' => $model['is_active'],
            //     'required' => 'required',
            //     'condition' => null,
            //     'cols' => '6'
            // ],
            // [
            //     'formtype' => 'image',
            //     'name' => 'image',
            //     'path' => 'storage/',
            //     'label' => 'image upload',
            //     'value' => $model['image'],
            //     'required' => 'required',
            //     'condition' => ['id' => 'is_active', 'value' => 'true'],
            //     'cols' => '6',
            // ],
        ];
    }

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
