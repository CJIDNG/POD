<?php

namespace App\Http\Controllers;

use App\Type;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Auth;
use DB;

class TypeController extends Controller
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
      $types = Type::all();
    } else {
      $types = Type::orderBy('name')
      ->withCount('governmentProjects')
      ->paginate();
    }

    return response()->json(
      $types, 200
    );
  }

  /**
   * Get a single agency or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    if (Type::all()->pluck('id')->contains($id) || $this->isNewType($id)) {
      if ($this->isNewType($id)) {
        return response()->json([
          'id' => NULL,
        ], 200);
      } else {
        $type = Type::find($id);

        if ($type) {
          return response()->json($type, 200);
        } else {
          return response()->json(null, 301);
        }
      }
    }
  }

  /**
   * Create or update a type.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'name' => request('name')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'name' => 'required'
    ], $messages)->validate();

    if ($id !== 'create') {
      $type = Type::find($id);
    } else {
      if ($type = Type::onlyTrashed()->where('id', $id)->first()) {
        $type->restore();
      } else {
        $type = new Type(['id' => request('id')]);
      }
    }

    $type->fill($data);
    $type->save();

    return response()->json($type->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $type = Type::find($id);

    if ($type) {
      $type->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new type.
   *
   * @param string $id
   * @return bool
   */
  private function isNewType(string $id): bool
  {
    return $id === 'create';
  }
}
