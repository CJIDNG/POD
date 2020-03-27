<?php

namespace App\Http\Controllers;

use App\Role;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(): JsonResponse
  {
    $all = request('all') ?? NULL;
    
    if ($all) {
      $roles = Role::all();
    } else {
      $roles = Role::orderBy('name')
        ->paginate();
    }
    return response()->json(
      $roles, 200
    );
  }

  /**
   * Get a single role or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    if (Role::all()->pluck('id')->contains($id) || $this->isNewRole($id)) {
      if ($this->isNewRole($id)) {
        return response()->json([
          'role' => Role::make([
            'id' => NULL
          ]),
          'permissions' => \App\Permission::get(['id', 'name'])
        ], 200);
      } else {
        $role = Role::find($id);

        if ($role) {
          return response()->json($role, 200);
        } else {
          return response()->json(null, 301);
        }
      }
    }
  }

  /**
   * Create or update a role.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'name' => request('name'),
      'permissions' => request('permissions', [])
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'name' => 'required'
    ], $messages)->validate();

    $role = $id !== 'create' ? Role::find($id) : new Role(['id' => request('id')]);

    $role->fill($data);
    $role->save();

    // admin role has everything
    if($role->name === 'Admin') {
      $role->syncPermissions(\App\Permission::all());
    } else {
      $role->syncPermissions($data['permissions']);
    }

    return response()->json($role->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $role = Role::find($id);

    if ($role) {
      $role->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new role.
   *
   * @param string $id
   * @return bool
   */
  private function isNewRole(string $id): bool
  {
    return $id === 'create';
  }
}
