<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Models\User;

class PostController extends BaseController
{
    public function createFormBuilder($model)
    {
        return [
            [
                'formtype' => 'input',
                'name' => 'title_en',
                'id' => 'title_en',
                'label' => 'title_en',
                'placeholder' => 'enter title_en',
                'type' => 'text',
                'value' => $model['title_en'],
                'required' => true,
                'condition' => null,
                'cols' => '6',
            ],
            [
                'formtype' => 'input',
                'name' => 'title_ar',
                'id' => 'title_ar',
                'label' => 'title_ar',
                'placeholder' => 'enter title_ar',
                'type' => 'text',
                'value' => $model['title_ar'],
                'required' => true,
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
                'data' => 'user_id',
                'name' => 'User Name',
            ],
            [
                'data' => 'title',
                'name' => 'title',
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
                return view('dashboard.post.parts.status_badges', $data)->render();
            });
    }
    public $rawColumns = ['image', 'is_active', 'status'];


    //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////


    // public function tableOptions_actions()
    // public function tableOptions_filters()
    public function tableOptions()
    {
        return [
            'actions' => [
                'route_show' => 'dashboard.post.show',
                'route_create' => 'dashboard.post.create',
                'route_edit' => 'dashboard.post.edit',
                'route_destroy' => 'dashboard.post.destroy',
                'route_force_delete' => 'dashboard.post.force-delete',
                'route_restore' => 'dashboard.post.restore',
                'configs' => [
                    'with_soft_delete' => true,
                    'with_multi_delete' => false,
                    'with_exports' => true,
                    'with_trans_switcher' => !empty(app($this->getModel())->getTranslatableOptions()),
                    'show_modal' => false,
                    'edit_modal' => false,
                ]
            ],
            ///////////////////////////////
            'filters' => [
                'text_filters' => [
                    ['name' => 'title', 'label' => 'filter by title', 'cols' => '3'],
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
                    [
                        'name' => 'status',
                        'cols' => '3',
                        'default_option' => 'filter by status',
                        'options' => [
                            [
                                'option_value' => '0',
                                'option_label' => 'pinned',
                            ],
                            [
                                'option_value' => '1',
                                'option_label' => 'published',
                            ],
                            [
                                'option_value' => '2',
                                'option_label' => 'blocked',
                            ],
                        ]
                    ]
                ],
                'select_relation_filters' => [
                    [
                        'name' => 'user_id',
                        'cols' => '3',
                        'default_option' => 'filter by user',
                        'options' => [
                            'value_attr' => 'id',
                            'label_attr' => 'name',
                        ],
                        'query' => User::get(['id', 'name']),
                    ],
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
            'user_id' => auth()->user()->id,
        ];
    }
    public function setUpdateResource($request, $old_image)
    {
        return [
            'user_id' => auth()->user()->id,
        ];
    }
}
