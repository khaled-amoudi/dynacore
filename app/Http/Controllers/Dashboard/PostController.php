<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Models\User;

class PostController extends BaseController
{

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
                return view('components.BaseComponents.layout.crud.parts.badges', $data)->render();
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
                        'name' => 'is_active', 'cols' => '3', 'default_option' => 'filter by is_active', 'options' => [
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
                        'name' => 'status', 'cols' => '3', 'default_option' => 'filter by status', 'options' => [
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
                        'name' => 'user_id', 'cols' => '3', 'default_option' => 'filter by user', 'options' => [
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


    public function formData()
    {
        return [
            'title_en', 'title_ar', 'description_en', 'description_ar', ['is_active', 'switch'], 'status',
            ['image', 'image']
        ];
    }


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
