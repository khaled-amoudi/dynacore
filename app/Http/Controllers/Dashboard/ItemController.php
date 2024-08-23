<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Models\Category;

class ItemController extends BaseController
{


    public function create()
    {
        $this->authorize('create-' . $this->resourceName());
        $model = new $this->model;

        $data['resource_name'] = $this->resourceName();
        $data['form_data'] = $this->formData();
        $data['route_index'] = $this->_index_link();
        $data['additionalData'] = $this->createAdditionalData();
        $formInputs = [
            [
                'formtype' => 'checkbox',
                'name' => 'type',
                'id' => 'type',
                'label' => 'type',
                'value' => '',
                'display' => 'inline',
                'options' => [
                    1 => 'label 1',
                    2 => 'label 2',
                    3 => 'label 3',
                ],
                'required' => 'required',
                'condition' => null,
                'cols' => '6',
            ],
            [
                'formtype' => 'radio',
                'name' => 'type_radio',
                'id' => 'type_radio',
                'label' => 'type_radio',
                'value' => '',
                'display' => 'inline',
                'options' => [
                    1 => 'label 1',
                    2 => 'label 2',
                    3 => 'label 3',
                ],
                'required' => 'required',
                'condition' => null,
                'cols' => '6',
            ],
            [
                'formtype' => 'select',
                'name' => 'category_id',
                'id' => 'category_id',
                'label' => 'category_id',
                'value' => '',
                'options' => Category::pluck('name', 'id')->toArray(),
                'searchable' => true,
                'allow_clear' => true,
                'cols' => '12',
                // 'get' => [
                //     'route' => route('dashboard.ajax.getOptions'),
                //     'id' => 'category_id',
                //     'target' => 'status',
                //     'input' => ''
                // ],
                'condition' => null
            ],
            [
                'formtype' => 'input',
                'name' => 'name_en',
                'id' => 'name_en',
                'label' => 'name_en',
                'placeholder' => 'enter name_en',
                'type' => 'text',
                'value' => '',
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
                'value' => '',
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
                'value' => '',
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
                'value' => '',
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
                'value' => '',
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
                'value' => '',
                'required' => 'required',
                'condition' => null,
                'cols' => '6'
            ],
            [
                'formtype' => 'image',
                'name' => 'image',
                'path' => 'storage/',
                'label' => 'image upload',
                'value' => '',
                'required' => 'required',
                'condition' => ['id' => 'is_active', 'value' => 'true'],
                'cols' => '6',
            ],
        ];

        return response()->view($this->_create_link(), compact('model', 'data', 'formInputs'));
    }


    public function edit($id)
    {
        $this->authorize('edit-' . $this->resourceName());


        $object = $this->getModel()::find($id);

        $objectResource = $this->getResource($object);
        $model = $objectResource->resolve();

        if (!$model) {
            return response()->json(['type' => 'error', 'message' => __('common.does_not_exist', ['model' => __($this->resourceName())])], 400);
        }

        $data['resource_name'] = $this->resourceName();
        $data['form_data'] = $this->formData();
        $data['route_index'] = $this->_index_link();
        $data['additionalData'] = $this->editAdditionalData($id);
        $formInputs = [

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
                'condition' => null
            ],
            [
                'formtype' => 'input',
                'name' => 'name_en',
                'id' => 'name_en',
                'label' => 'name_en',
                'placeholder' => 'enter name_en',
                'type' => 'text',
                'value' => $model['name_en'],
                'required' => 'required',
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

        return response()->view($this->_edit_link(), compact('model', 'data', 'formInputs'));
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
    //////////////////////////////////////////////////////////////////


    public function formData()
    {
        return [
            ['type', 'checkbox'], ['type_radio', 'radio'], 'category_id', 'name_en', 'name_ar', 'description_en', 'description_ar', 'status', ['is_active', 'switch'], ['image', 'image']
        ];
    }


    public function createEditAdditionalData()
    {
        $category = Category::get(['id', 'name']);
        return $category;
    }
}
