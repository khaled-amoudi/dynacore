<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use App\Models\Item;

class ItemController extends BaseController
{

    public function createFormBuilder($model)
    {
        return [
            [
                'formtype' => 'select',
                'name' => 'category_id',
                'id' => 'category_id',
                'label' => 'category_id',
                'value' => $model['category_id'],
                'options' => Category::pluck('name', 'id')->toArray(),
                'searchable' => true,
                'allow_clear' => true,
                'cols' => '12',
                'condition' => null,
                'get' => [
                    'ajax' => route('dashboard.ajax.getOptions'),
                    'target' => 'target id'
                ],
                'add' => [
                    'action' => route('dashboard.category.store'),
                    'resource' => 'category',
                    'ajax_for_new_options' => route('dashboard.ajax.get_category_select'),
                    'formInputs' => app(CategoryController::class)->createFormBuilder(new Category()),
                    'formData' => app(CategoryController::class)->formData(new Category()),
                ]
            ],
            // [
            //     'formtype' => 'modal',
            //     'name' => 'category_modal',
            //     'action' => 'dashboard.category.store',
            //     'resource' => 'category',
            //     'formInputs' => app(CategoryController::class)->createFormBuilder(new Category()),
            //     'formData' => app(CategoryController::class)->formData(new Category()),
            // ],
            [
                'formtype' => 'input',
                'name' => 'name_en',
                'id' => 'name_en',
                'label' => 'name_en',
                'placeholder' => 'enter name_en',
                'type' => 'text',
                'value' => $model['name_en'],
                'required' => true,
                'condition' => null,
                'cols' => '6',
            ],
            [
                'formtype' => 'input',
                'name' => 'name_ar',
                'id' => 'name_ar',
                'label' => 'name_ar',
                'placeholder' => 'enter name_ar',
                'type' => 'text',
                'value' => $model['name_ar'],
                'required' => 'required',
                'condition' => null,
                'cols' => '6',
            ],
            [
                'formtype' => 'textarea',
                'name' => 'description_en',
                'id' => 'description_en',
                'label' => 'description_en',
                'placeholder' => 'enter description_en',
                'value' => $model['description_en'],
                'required' => 'required',
                'condition' => null,
                'rows' => '3',
                'cols' => '12'
            ],
            [
                'formtype' => 'textarea',
                'name' => 'description_ar',
                'id' => 'description_ar',
                'label' => 'description_ar',
                'placeholder' => 'enter description_ar',
                'value' => $model['description_ar'],
                'required' => 'required',
                'condition' => null,
                'rows' => '3',
                'cols' => '12'
            ],
            [
                'formtype' => 'select',
                'name' => 'status',
                'id' => 'status',
                'label' => 'status',
                'value' => $model['status'],
                'options' => [
                    '0' => 'pinned',
                    '1' => 'published',
                    '2' => 'blocked',
                ],
                'searchable' => true,
                'allow_clear' => true,
                'cols' => '6',
                'condition' => null
            ],
            [
                'formtype' => 'switch',
                'name' => 'is_active',
                'id' => 'is_active',
                'label' => 'is_active',
                'placeholder' => 'is_active',
                'value' => $model['is_active'],
                'required' => 'required',
                'condition' => null,
                'cols' => '6'
            ],
            [
                'formtype' => 'image',
                'name' => 'image',
                'path' => 'storage/',
                'label' => 'image upload',
                'value' => $model['image'],
                'required' => 'required',
                'condition' => ['id' => 'is_active', 'value' => 'true'],
                'cols' => '6',
            ],
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
            [
                'data' => 'image',
                'name' => 'image',
            ],
            [
                'data' => 'category_id_name',
                'name' => 'category_id_name',
            ],
            [
                'data' => 'name',
                'name' => 'name',
            ],
            [
                'data' => 'description',
                'name' => 'description',
            ],
            [
                'data' => 'is_active',
                'name' => 'is_active',
            ],
            [
                'data' => 'status',
                'name' => 'status',
            ],
            [
                'data' => 'actions',
                'name' => 'actions',
            ],
        ];
    }

    public function addColumns($dataTable)
    {
        return $dataTable
            ->addColumn('image', function ($row) {
                $data['image'] = $row['image'];
                return view('components.BaseComponents.layout.crud.parts.image', $data)->render();
            })

            ->addColumn('is_active', function ($row) {
                $data['id'] = $row['id'];
                $data['is_active'] = $row['is_active'];
                return view('components.BaseComponents.layout.crud.parts.switcher', $data)->render();
            })

            ->addColumn('status', function ($row) {
                $data['status'] = $row['status'];
                return view('components.BaseComponents.layout.crud.parts.badges', $data)->render();
            });
    }
    public $rawColumns = [
        'image',
        'is_active',
        'status'
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
                'route_show' => 'dashboard.item.show',
                'route_create' => 'dashboard.item.create',
                'route_edit' => 'dashboard.item.edit',
                'route_destroy' => 'dashboard.item.destroy',
                'route_force_delete' => 'dashboard.item.force-delete',
                'route_restore' => 'dashboard.item.restore',
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
                    ['name' => 'name', 'label' => 'filter by name', 'cols' => '3'],
                    ['name' => 'description', 'label' => 'filter by description', 'cols' => '3'],
                ],
                'select_filters' => [
                    [
                        'name' => 'is_active',
                        'cols' => '3',
                        'default_option' => 'filter by is_active',
                        'options' => [
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
                ]
                // 'select_relation_filters' => [
                //     [
                //         'name' => 'category_id', 'cols' => '3', 'default_option' => 'filter by category_id', 'options' => [
                //             'value_attr' => 'id',
                //             'label_attr' => 'name',
                //         ],
                //         'query' => Category::get(['id', 'name']),
                //     ],
                // ]
            ],
        ];
    }

    //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////
}
