<?php

namespace App\Http\Controllers;

use App\Ministry;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\MinistryResource;
use Auth;
use DB;

class MinistryController extends Controller
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
      $ministries = Ministry::all();
    } else {
      $ministries = Ministry::orderBy('name')
      ->withCount('governmentProjects')
      ->paginate();
    }

    return response()->json(
      $ministries, 200
    );
  }

  /**
   * Get a single minis$ministry or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    if (Ministry::all()->pluck('id')->contains($id) || $this->isNewMinistry($id)) {
      if ($this->isNewMinistry($id)) {
        $id = DB::connection('tenant')->select("SHOW TABLE STATUS LIKE 'ministries'");
        return response()->json([
          'id' => $id[0]->Auto_increment,
        ], 200);
      } else {
        $ministry = Ministry::find($id);

        if ($ministry) {
          return response()->json($ministry, 200);
        } else {
          return response()->json(null, 301);
        }
      }
    }
  }

  /**
   * Create or update a ministry.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'name' => request('name'),
      'hq' => request('hq'),
      'head' => request('head'),
      'email' => request('email'),
      'phone' => request('phone'),
      'website' => request('website'),
      'description' => request('description')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'name' => 'required'
    ], $messages)->validate();

    if ($id !== 'create') {
      $ministry = Ministry::find($id);
    } else {
      if ($ministry = Ministry::onlyTrashed()->where('id', $id)->first()) {
        $ministry->restore();
      } else {
        $ministry = new Ministry(['id' => request('id')]);
      }
    }

    $ministry->fill($data);
    $ministry->save();

    return response()->json($ministry->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $ministry = Ministry::find($id);

    if ($ministry) {
      $ministry->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new ministry.
   *
   * @param string $id
   * @return bool
   */
  private function isNewMinistry(string $id): bool
  {
    return $id === 'create';
  }
}
