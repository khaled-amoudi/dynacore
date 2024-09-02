<?php

namespace App\Http\Controllers;

use App\Exports\BaseExport;
use App\Imports\BaseImport;
use Illuminate\Http\Request;
use App\Http\Traits\uploadFile;
use App\Models\BaseModel\BaseModel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Requests\BaseRequest\BaseRequest;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use App\Http\Resources\BaseResource\BaseResource;
use App\Models\User;
use Exception;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Yajra\DataTables\DataTables;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, uploadFile;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $model;    // public $model = "App\Models\Category";
    public $resource;
    protected $request;    // public $request = "App\Http\Requests\CategoryRequest";
    public $paginate = 3;

    public $print_model_text;    // the model name to show in Alert messages // نادر الإستخدام
    public $resource_name = 'default';

    public $tableOptions;

    public $importChildObject = BaseController::class;    // public $importChildObject = ProductController::class;



    public function __construct()
    {
        $this->init();
    }
    public function init()
    {
        if (!isset($this->model) && class_exists($this->getDefaultModel()))
            $this->model = $this->getDefaultModel();

        if (!isset($this->resource) && class_exists($this->getDefaultResource()))
            $this->resource = $this->getDefaultResource();


        $this->tableOptions = $this->tableOptions();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public $rawColumns;
    public function index()
    {
        $this->authorize('index-list-' . $this->resourceName());

        $data['resource_name'] = $this->resourceName();
        $data['datatable_list_route'] = route('dashboard.'.$this->resourceName().'.datatable');
        $data['table_data'] = $this->tableOptions;
        $data['columns'] = array_merge($this->checkboxColumn(), $this->datatableColumns());

        return response()->view($this->_index_link(), compact('data'));
    }
    public function getDatatableIndex(Request $request)
    {
        if ($request->ajax()) {
            $model = $this->indexQuery();
            $data = $this->resource::collection($model)->resolve();
            $dataTable = DataTables::of($data);

            if (isset($this->tableOptions['actions']['configs']['with_multi_delete']) && $this->tableOptions['actions']['configs']['with_multi_delete'] == true) {
                $dataTable->addColumn('checkbox', function ($row) {
                    $data['id'] = $row['id'];
                    return view('components.BaseComponents.layout.crud.parts.select-delete', $data)->render();
                });
            }


            $dataTable->addColumn('#', function ($row) {
                static $order = 0;
                return ++$order;
            });

            $this->addColumns($dataTable);


            $dataTable->addColumn('actions', function ($row) {
                $data['id'] = $row['id'];
                $data['actions'] = $this->tableOptions['actions'];
                $data['resource_name'] = $this->resourceName();
                return view('components.BaseComponents.layout.crud.parts.actions', $data)->render();
            })
                ->rawColumns(array_merge(['checkbox', '#'], $this->rawColumns, ['actions']))
                ->escapeColumns(['*']);

            return $dataTable->make(true);
        }
    }
    public function indexQuery()
    {
        return $this->getModel()::search(request()->query())->get();
    }

    public function addColumns($dataTable)
    {
        return 0;
    }
    // public function addColumns($dataTable)
    // {
    //     return $dataTable->addColumn('image', function ($row) {
    //         $data['image'] = $row['image'];
    //         return view('components.BaseComponents.layout.crud.parts.image', $data)->render();
    //     })->addColumn('is_active', function ($row) {
    //         $data['id'] = $row['id'];
    //         $data['is_active'] = $row['is_active'];
    //         return view('components.BaseComponents.layout.crud.parts.switcher', $data)->render();
    //     });
    // }

    // public function datatableColumns()
    // {
    //     return  [
    //         [
    //             'data' => '#',
    //             'name' => '#',
    //             'orderable' => true,
    //         ],
    //         [
    //             'data' => 'title',
    //             'name' => 'title',
    //         ],
    //         [
    //             'data' => 'actions',
    //             'name' => 'actions',
    //         ],
    //     ];
    // }
    public function checkboxColumn()
    {
        if (isset($this->tableOptions['actions']['configs']['with_multi_delete']) && $this->tableOptions['actions']['configs']['with_multi_delete'] == true) {
            return [
                [
                    'data' => 'checkbox',
                    'name' => 'checkbox'
                ]
            ];
        } else {
            return [];
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function createFormBuilder($model)
    {
        return [];
    }
    public function create()
    {
        $this->authorize('create-' . $this->resourceName());
        $model = new $this->model;

        $data['resource_name'] = $this->resourceName();
        $data['form_data'] = $this->formData($model);
        $data['route_index'] = $this->_index_link();

        $formInputs = $this->createFormBuilder($model);

        return response()->view($this->_create_link(), compact('model', 'data', 'formInputs'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->authorize('store-' . $this->resourceName());

        $request->validate($this->getRequest()->rules(), $this->getRequest()->messages(), $this->getRequest()->attributes());
        // $model = $this->getModel()::create($this->setCreateAttributes($request));

        // if (!$model) {
        //     return response()->json(['type' => 'error', 'message' => __('common.somthing_went_wrong')], 400);
        // }
        return response()->json(['type' => 'success', 'message' => __('common.created_successfully', ['model' => __($this->resourceName())])], 200);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function show($id)
    {
        $this->authorize('show-' . $this->resourceName());


        $object = $this->getModel()::find($id);
        $objectResource = $this->getResource($object);

        $model = $objectResource->resolve();

        $data['resource_name'] = $this->resourceName();
        $data['route_index'] = $this->_index_link();
        $data['additionalData'] = $this->showAdditionalData($id);

        if (!$model) {
            return response()->json(['type' => 'error', 'message' => __('common.does_not_exist', ['model' => __($this->resourceName())])], 400);
        }
        return response()->view($this->_show_link(), compact('model', 'data'));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
        $data['form_data'] = $this->formData($model);
        $data['route_index'] = $this->_index_link();

        $formInputs = $this->createFormBuilder($model);

        return response()->view($this->_edit_link(), compact('model', 'data', 'formInputs'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update-' . $this->resourceName());

        $model = $this->getModel()::find($id);
        if (!$model) {
            return response()->json(['type' => 'error', 'message' => __('common.does_not_exist', ['model' => __($this->resourceName())])], 400);
        }

        $old_image = count($model->getImageable()) == 1 ? $model[$model->getImageable()[0]] : $model->image;


        $request->validate($this->getRequest()->rules($id), $this->getRequest()->messages(), $this->getRequest()->attributes());


        $newModel = $model->update($this->setUpdateAttributes($request, $old_image));

        if ($newModel) {
            return response()->json(['type' => 'success', 'message' => __('common.updated_successfully', ['model' => __($this->resourceName())])], 200);
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function destroy($id)
    {
        $this->authorize('destroy-' . $this->resourceName());


        $model = $this->getModel()::find($id);
        if (!$model) {
            return response()->json(['type' => 'error', 'message' => __('common.does_not_exist', ['model' => __($this->resourceName())])], 400);
        }
        $deleted = $model->delete();

        if ($deleted) // DO NOT check if the image was deleted, it will case an error
            return response()->json(['type' => 'success', 'message' => __('common.deleted_successfully', ['model' => __($this->resourceName())])], 200);
    }

    public function deleteRelations($model)
    {
        $images = app($this->getModel())->getImageable();
        foreach ($images as $image) {
            $deleted = $this->deleteFile($model[$image]);
        }
        // $deleted = $model->parts()->delete();
        return $deleted ?? null;
    }


    public function delete_all(Request $request)
    {
        try {
            $selected_ids = $request->input('selected_ids');
            if (empty($selected_ids)) {
                return response()->json(['type' => 'error', 'message' => __('common.no_selected_records_to_delete')], 400);
            }
            $this->getModel()::whereIn('id', $selected_ids)->delete();
            return response()->json(['type' => 'success', 'message' => __('common.selected_items_deleted_successfully')], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => __('common.somthing_went_wrong')], 400);
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function trash()
    {
        $this->authorize('trash-list-' . $this->resourceName());

        $data['resource_name'] = $this->resourceName();
        $data['datatable_trash_list_route'] = route('dashboard.'.$this->resourceName().'.trash-datatable');
        $data['table_data'] = $this->tableOptions;
        $data['columns'] = $this->datatableColumns();

        return response()->view($this->_trash_link(), compact('data'));
    }
    public function getDatatableTrash(Request $request)
    {
        if ($request->ajax()) {
            $model = $this->getModel()::onlyTrashed()->search(request()->query())->get();
            $data = $this->resource::collection($model)->resolve();
            $dataTable = DataTables::of($data)
                ->addColumn('#', function ($row) {
                    static $order = 0;
                    return ++$order;
                });

            $this->addColumns($dataTable);


            $dataTable->addColumn('actions', function ($row) {
                $data['id'] = $row['id'];
                $data['actions'] = $this->tableOptions['actions'];
                $data['resource_name'] = $this->resourceName();
                return view('components.BaseComponents.layout.crud.parts.trash-actions', $data)->render();
            })
                ->rawColumns(array_merge(['#'], $this->rawColumns, ['actions']))
                ->escapeColumns(['*']);

            return $dataTable->make(true);
        }
    }

    public function restore(Request $request, $id)
    {
        $this->authorize('restore-' . $this->resourceName());

        $model = $this->getModel()::onlyTrashed()->findOrFail($id);
        $model->restore();  // make deleted_at = NULL
        return response()->json(['type' => 'success', 'message' => __('common.restored_successfully', ['model' => __($this->resourceName())])], 200);
    }

    public function forceDelete($id)
    {
        $this->authorize('force-delete-' . $this->resourceName());

        $model = $this->getModel()::onlyTrashed()->findOrFail($id);
        $model->forceDelete();
        $this->deleteRelations($model);

        return response()->json(['type' => 'success', 'message' => __('common.deleted_successfully', ['model' => __($this->resourceName())])], 200);
    }

    public function trash_all(Request $request)
    {
        // dd($request->input('selected_ids'));
        try {
            $selected_ids = $request->input('selected_ids');
            if (empty($selected_ids)) {
                return response()->json(['type' => 'error', 'message' => __('common.no_selected_records_to_delete')], 400);
            }
            $this->getModel()::whereIn('id', $selected_ids)->delete();
            return response()->json(['type' => 'success', 'message' => __('common.selected_items_deleted_successfully')], 200);
        } catch (Exception $e) {
            return response()->json(['type' => 'error', 'message' => __('common.somthing_went_wrong')], 400);
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function switcher_update_trash($id)
    {
        $this->authorize('update-' . $this->resourceName());

        $model = $this->getModel()::onlyTrashed()->findOrFail($id);
        $updated = $model->update(['is_active' => $model->is_active ? 0 : 1]);

        if ($updated) {
            return response()->json(['type' => 'success', 'message' => __('common.activation_updated_successfully', ['model' => __($this->resourceName())])], 200);
        }
        return response()->json(['type' => 'error', 'message' => __('common.somthing_went_wrong')], 400);
    }


    public function updateStatus($id)
    {
        $this->authorize('update-' . $this->resourceName());
        $model = $this->getModel()::find($id);
        if ($model) {
            $model->update(['is_active' => $model->is_active ? 0 : 1]);

            return response()->json(['type' => 'success', 'message' => __('common.activation_updated_successfully', ['model' => __($this->resourceName())])], 200);
        }

        return response()->json(['type' => 'error', 'message' => __('common.somthing_went_wrong')], 400);
    }





    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Export Excel File
    // public function exportExcelHeadings()
    // {
    //     return $this->exportHeadings() ?? $this->exportCollection();
    // }
    // public function exportExcelCollection()
    // {
    //     return $this->exportCollection();
    // }
    // public function exportExcel()
    // {
    //     $headings = $this->exportExcelHeadings();
    //     $collection = $this->getModel()::get($this->exportExcelCollection());
    //     // $collection = $this->resource::collection($this->exportExcelCollection())->collect();
    //     return Excel::download(new BaseExport($headings, $collection), $this->printModelText() . '.xlsx');
    // }
    // public function exportExcelDemo()
    // {
    //     $headings = $this->exportExcelHeadings();
    //     $collection = collect(new $this->model);
    //     return Excel::download(new BaseExport($headings, $collection), $this->printModelText() . '_demo.xlsx');
    // }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    // // Export PDF File
    // public function exportPdfHeadings()
    // { // set the headings of PDF to export
    //     return $this->exportHeadings() ?? $this->exportCollection();
    // }
    // public function exportPdfCollection()
    // { // set the collection of PDF to export
    //     return $this->exportCollection();
    // }
    // public function exportPdf()
    // {
    //     $headings = $this->exportPdfHeadings();
    //     $collection_array = $this->exportPdfCollection();
    //     // $collection = $this->getModel()::get($this->exportPdfCollection());
    //     $collection = $this->resource::collection($this->getModel()::all())->resolve();
    //     $pdf = LaravelMpdf::loadView('components.BaseComponents.tabel.export_templates.template_pdf', compact('collection', 'collection_array', 'headings'));
    //     return $pdf->stream($this->printModelText() . '.pdf');
    // }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Set the Headings & Collections of Excel & PDF
    public function exportHeadings()
    {
        return null; // return [];
    }
    public function exportCollection()
    {
        return !is_null(app($this->getModel())->getColumnsForSheets()) ? app($this->getModel())->getColumnsForSheets() : app($this->getModel())->getFillable();
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Import Excel File

    // public function importRules()
    // {
    //     return [];
    //     // return [
    //     //     '*.name' => ['required', 'unique:categories'],
    //     //     '*.status' => ['required'],
    //     // ];
    // }

    // public function importCollection($row)
    // {
    //     return [];
    //     // return [
    //     //     'name' => $row['name'],
    //     //     'description' => $row['description'],
    //     //     'parent_id' => $row['parent_id'],
    //     //     'slug' => Str::slug($row['name']),
    //     //     'status' => $row['status'],
    //     // ];
    // }
    // public function importExcel()
    // {
    //     $importChildObject = get_class($this);
    //     // $importChildObject2 = $this->importChildObject;
    //     $model = $this->getModel();
    //     $rules = $this->importRules();
    //     $import = Excel::import(new BaseImport($importChildObject, $model, $rules), request()->file('import_file'));
    //     if (!$import) {
    //         return redirect()->route($this->route_index())->with('import_errors', 'something went wrong');
    //     }
    //     return redirect()->route($this->route_index())->with('success', 'File Imported Successfully');
    //     // return response()->json(['success' => 'You have successfully upload file, click submit button to store the data.']);
    // }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    // define the attributes as key => value to send it to database in Create & Update
    // same as Resource
    public function setCreateAttributes($request)
    {
        return array_merge($this->setResource($request), $this->serializeImagableOptions($request), $this->serializeTranslatableOptions($request), $this->setCreateResource($request));
    }
    public function setUpdateAttributes($request, $old_image)
    {
        return array_merge($this->setResource($request), $this->serializeImagableOptions($request, $old_image), $this->serializeTranslatableOptions($request), $this->setUpdateResource($request, $old_image));
    }
    // use it when Update has new different data than normal [e.g. 'image' => uploadFile(request, path)]
    public function setCreateResource($request)
    {
        return $this->setCreateUpdateResource($request);
    }
    // use it when Update has new different data than normal [e.g. 'image' => uploadFile(request, oldimage, path)]
    public function setUpdateResource($request, $old_image)
    {
        return $this->setCreateUpdateResource($request, $old_image);
    }
    // use it when Update & Create has new different data than normal [e.g. 'parts' => $model->parts->name]
    public function setCreateUpdateResource($request, $old_image = null)
    {
        return [];
    }

    public function serializeTranslatableOptions($request)
    {
        $translatabelOptions = app($this->getModel())->getTranslatableOptions();
        $serializedOptions = [];
        foreach ($translatabelOptions as $option) {
            $serializedOptions[$option] = [
                'en' => $request->input($option . '_en'),
                'ar' => $request->input($option . '_ar')
            ];
        }
        return $serializedOptions;
    }
    public function serializeImagableOptions($request, $old_image = null)
    {
        $imagableOptions = app($this->getModel())->getImageable();
        $serializedOptions = [];
        foreach ($imagableOptions as $option) {
            $serializedOptions[$option] = $this->uploadFile(request: $request, old_image: $old_image, path: 'uploads/' . $this->resourceName());
        }
        return $serializedOptions;
    }


    // use it when create & update has the same data, [default = $request->all()]
    public function setResource($request)
    {
        return $request->all();
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    // return some variabels in functions [ GETTERS ]
    public function getModel()
    {
        return $this->getDefaultModel();
    }
    public function getRequest()
    {
        return $this->getDefaultRequest();
    }
    public function getResource($object)
    {
        return new ($this->resource)($object);
    }

    public function getDefaultModel()
    {
        $custom_model = "App\\Models\\" . str_replace(["Controllers", "Controller"], ["", ""], get_class_name($this));
        return class_exists($custom_model) ? $custom_model : BaseModel::class;
    }
    public function getDefaultRequest()
    {
        $custom_request = "App\\Http\\Requests\\" . str_replace(["Controllers", "Controller"], ["Requests", "Request"], get_class_name($this));
        $request = class_exists($custom_request) ? $custom_request : BaseRequest::class;
        return new $request;
    }
    public function getDefaultResource()
    {
        $custom_resource = "App\\Http\\Resources\\" . str_replace(["Controllers", "Controller"], ["Resources", "Resource"], get_class_name($this));
        return class_exists($custom_resource) ? $custom_resource : BaseResource::class;
    }


    public function printModelText()
    {
        $model = str_replace(["Controllers", "Controller"], ["", ""], get_class_name($this));
        $basename = basename($model);
        $model_name = preg_replace('/(?<!\ )[A-Z]/', ' $0', $basename);
        return isset($this->print_model_text) && $this->print_model_text != null ? $this->print_model_text : $model_name;
    }
    public function resourceName()
    {
        $model = str_replace(["Controllers", "Controller"], ["", ""], get_class_name($this));
        $basename = basename($model);
        $resource_name = strtolower(preg_replace('/(?<=\w)([A-Z])/', '_$1', $basename));
        return $resource_name;
    }

    public function formData($model)
    {
        $formBuilder = $this->createFormBuilder($model);
        $formData = [];

        foreach ($formBuilder as $field) {
            if (in_array($field['formtype'], ['switch', 'radio', 'checkbox', 'image', 'file', 'repeater', 'repeater_table'])) {
                $formData[] = [$field['name'], $field['formtype']];
            } else {
                $formData[] = $field['name'];
            }
        }
        return $formData;
        // return [
        //     'category_id', 'name_en', 'name_ar', 'description_en', 'description_ar', 'status', ['is_active', 'switch'], ['image', 'image']
        // ];
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Send Additional Data To View

    public function indexAdditionalData()
    {
        return null;
    }
    public function showAdditionalData($id)
    {
        return null;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Operation befor saving the new model

    public function afterCreate($request, $model)
    {
        return $this->saving($request, $model);
    }
    public function afterUpdate($request, $model)
    {
        return $this->saving($request, $model);
    }
    public function saving($request, $model)
    {
        return null;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    // dynamic route & view system

    public function _link_theme()
    {
        return 'dashboard.' . $this->resourceName();
    }

    public function _index_link()
    {
        return $this->_link_theme() . '.index';
    }
    public function _show_link()
    {
        return $this->_link_theme() . '.show';
    }
    public function _create_link()
    {
        return $this->_link_theme() . '.create';
    }
    public function _edit_link()
    {
        return $this->_link_theme() . '.edit';
    }
    public function _trash_link()
    {
        return $this->_link_theme() . '.trash';
    }
    public function _restore_link()
    {
        return $this->_link_theme() . '.restore';
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////

}
