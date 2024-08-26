<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Resources\ItemResource;
use App\Models\Category;
use App\Models\Item;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends BaseController
{
    public function store(Request $request)
    {
        // dd($request->all());
        $this->authorize('store-' . $this->resourceName());

        $request->validate($this->getRequest()->rules(), $this->getRequest()->messages());
        $model = $this->getModel()::create($this->setCreateAttributes($request));

        foreach ($request['items'] as $item) {
            $model->items()->create([
                'category_id' => $model->id,
                'image' => null, // $this->uploadFile($request, $old_image = null, $filename = 'image', $disk = 'public', $path = '/'),
                'name' => [
                    'en' => $item['name_en'],
                    'ar' => $item['name_ar']
                ],
                'description' => [
                    'en' => $item['description_en'],
                    'ar' => $item['description_ar']
                ],
                'is_active' => 1, // $item['is_active'] == 'on' ? 1 : 0,
                'status' => $item['status'],
            ]);
        }
        if (!$model) {
            return response()->json(['type' => 'error', 'message' => __('common.somthing_went_wrong')], 400);
        }
        return response()->json(['type' => 'success', 'message' => __('common.created_successfully', ['model' => __($this->resourceName())])], 200);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->authorize('update-' . $this->resourceName());

        $model = $this->getModel()::find($id);
        if (!$model) {
            return response()->json(['type' => 'error', 'message' => __('common.does_not_exist', ['model' => __($this->resourceName())])], 400);
        }

        $old_image = count($model->getImageable()) == 1 ? $model[$model->getImageable()[0]] : $model->image;


        $request->validate($this->getRequest()->rules($id), $this->getRequest()->messages());


        $newModel = $model->update($this->setUpdateAttributes($request, $old_image));

        $model->items()->delete();
        foreach ($request['items'] as $item) {
            Item::create([
                'category_id' => $model->id,
                'image' => null, // $this->uploadFile($request, $old_image = null, $filename = 'image', $disk = 'public', $path = '/'),
                'name' => [
                    'en' => $item['name_en'],
                    'ar' => $item['name_ar']
                ],
                'description' => [
                    'en' => $item['description_en'],
                    'ar' => $item['description_ar']
                ],
                'is_active' => 1, // $item['is_active'] == 'on' ? 1 : 0,
                'status' => $item['status'],
            ]);
        }

        if ($newModel) {
            return response()->json(['type' => 'success', 'message' => __('common.updated_successfully', ['model' => __($this->resourceName())])], 200);
        }
    }
    public function createFormBuilder($model)
    {
        // dd( $model['items']);
        return [
            [
                'formtype' => 'input',
                'name' => 'name',
                'id' => 'name',
                'label' => 'name',
                'placeholder' => 'enter name',
                'type' => 'text',
                'value' => $model['name'],
                'required' => true,
                'condition' => null,
                'cols' => '6',
            ],
            [
                'formtype' => 'textarea',
                'name' => 'description',
                'id' => 'description',
                'label' => 'description',
                'placeholder' => 'enter description',
                'value' => $model['description'],
                'required' => 'required',
                'condition' => null,
                'rows' => '3',
                'cols' => '12'
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
            [
                'formtype' => 'repeater_table',
                'name' => 'items',
                'value' => $model['items'],
                'label' => 'العناصر',
                'condition' => null,
                'cols' => '12',
                'fields' => [
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
                        'cols' => '4',
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
                        'cols' => '4',
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
                        'cols' => '4',
                        'condition' => null,
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
                        'cols' => '6'
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
                        'cols' => '6'
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
                        'condition' => ['id' => 'items_is_active', 'value' => 'true'],
                        'cols' => '6',
                    ],
                ]
            ]
        ];
    }



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
                        'name' => 'is_active',
                        'label' => 'is_active',
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
                ],
            ],
        ];
    }


    //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////


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
