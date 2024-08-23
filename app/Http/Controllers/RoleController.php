<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function __construct()
    {
        // Apply the 'admin' middleware to all methods in the controller
        $this->middleware('has_admin_role');
    }

    public function index()
    {
        $data['columns'] = $this->datatableColumns();
        $data['resource_name'] = 'role';
        $data['table_data'] = $this->tableOptions();

        return response()->view('dashboard.role.index', compact('data'));
    }
    public function getDatatableIndex(Request $request)
    {
        if ($request->ajax()) {
            $model = Role::get();
            $data = RoleResource::collection($model)->resolve();
            $dataTable = DataTables::of($data);

            $dataTable->addColumn('#', function ($row) {
                static $order = 0;
                return ++$order;
            });

            $dataTable->addColumn('name', function ($row) {
                return $row['name'];
            });

            $dataTable->addColumn('actions', function ($row) {
                $data['id'] = $row['id'];


                $data['actions'] = [
                    // 'route_show' => 'dashboard.role.show',
                    'route_create' => 'dashboard.role.create',
                    'route_edit' => 'dashboard.role.edit',
                    'route_manage' => 'dashboard.role.manage',
                    'route_destroy' => 'dashboard.role.destroy',
                    'route_force_delete' => 'dashboard.role.force-delete',
                    'route_restore' => 'dashboard.role.restore',
                    'configs' => [
                        'with_soft_delete' => false,
                        'with_multi_delete' => false,
                        'with_exports' => true,
                        'with_trans_switcher' => true,
                    ]
                ];
                return view('dashboard.role.parts.actions', $data)->render();
            })
                ->rawColumns(array_merge(['#', 'name', 'actions']))
                ->escapeColumns(['*']);

            return $dataTable->make(true);
        }
    }

    public function tableOptions()
    {
        return [
            'actions' => [
                // 'route_show' => 'dashboard.role.show',
                'route_create' => 'dashboard.role.create',
                'route_edit' => 'dashboard.role.edit',
                'route_manage' => 'dashboard.role.manage',
                'route_destroy' => 'dashboard.role.destroy',
                'route_force_delete' => 'dashboard.role.force-delete',
                'route_restore' => 'dashboard.role.restore',
                'configs' => [
                    'with_soft_delete' => false,
                    'with_multi_delete' => false,
                    'with_exports' => true,
                    'with_trans_switcher' => true,
                ]
            ],
            ///////////////////////////////
            'filters' => [
                // 'text_filters' => [
                //     ['name' => 'name', 'label' => 'filter by name', 'cols' => '3'],
                // ],
            ],
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
                'data' => 'name',
                'name' => 'name',
            ],
            [
                'data' => 'actions',
                'name' => 'actions',
            ],
        ];
    }

    #########################################################
    #########################################################


    public function create()
    {
        $model = new Role();
        $data['resource_name'] = 'role';
        $data['form_data'] = [
            'name'
        ];
        $data['route_index'] = 'dashboard.role.index';

        return response()->view('dashboard.role.create', compact('model', 'data'));
    }


    public function store(Request $request)
    {
        // $request->validate(RoleRequest::rules(), RoleRequest::messages());
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => '',
        ]);

        $model = Role::create($request->all());

        if (!$model) {
            return response()->json(['type' => 'error', 'message' => __('common.somthing_went_wrong')], 400);
        }
        return response()->json(['type' => 'success', 'message' => __('common.created_successfully', ['model' => __('Role')])], 200);
    }

    #########################################################
    #########################################################


    public function edit($id)
    {
        $object = Role::find($id);

        $model = new RoleResource($object);

        if (!$model) {
            return response()->json(['type' => 'error', 'message' => __('common.does_not_exist', ['model' => __('role')])], 400);
        }

        $data['resource_name'] = 'role';
        $data['form_data'] = [
            'name'
        ];
        $data['route_index'] = 'dashboard.role.index';

        return response()->view('dashboard.role.edit', compact('model', 'data'));
    }

    public function update(Request $request, $id)
    {
        $model = Role::find($id);
        if (!$model) {
            return response()->json(['type' => 'error', 'message' => __('common.does_not_exist', ['model' => __('role')])], 400);
        }

        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $id,
            'permission' => '',
        ]);

        $newModel = $model->update($request->all());

        if ($newModel) {
            return response()->json(['type' => 'success', 'message' => __('common.updated_successfully', ['model' => __('role')])], 200);
        }
    }


    #########################################################
    #########################################################

    public function destroy($id)
    {
        $model = Role::find($id);
        if (!$model) {
            return response()->json(['type' => 'error', 'message' => __('common.does_not_exist', ['model' => __('role')])], 400);
        }
        $deleted = $model->delete();

        if ($deleted) // DO NOT check if the image was deleted, it will case an error
            return response()->json(['type' => 'success', 'message' => __('common.deleted_successfully', ['model' => __('role')])], 200);
    }

    #########################################################
    #########################################################


    public function manage($id)
    {

        $role = Role::find($id);

        $ordered_permissions = Permission::orderBy('group_name')->get();
        $permissions = $ordered_permissions->groupBy('group_name');

        // $permissions = Permission::groupBy('group_name')->get();

        return view('dashboard.role.manage', compact('role', 'permissions'));
    }
    public function update_permissions(Request $request, Role $role)
    {
        $permissionIds = $request->input('permissions', []);
        $permissions = Permission::whereIn('id', $permissionIds)->get();

        // Ensure the role is "admin" before proceeding
        if ($role->name !== 'admin') {
            // Check if any permissions with group_name 'SECRET' are being assigned
            if ($permissions->contains(function ($permission) {
                return $permission->group_name === 'SECRET';
            })) {
                return response()->json(['type' => 'error', 'message' => __('You do not have permission to assign these permissions to this role.', ['model' => __('role')])], 403);
            }
        }

        // Sync permissions for the role
        $role->syncPermissions($permissionIds);

        return response()->json(['type' => 'success', 'message' => __('common.updated_successfully', ['model' => __('role')])], 200);
    }
}
