<?php

namespace App\Http\Controllers;

use App\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\StatusResource;
use Auth;
use DB;

class StatusController extends Controller
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
      $statuses = Status::all();
    } else {
      $statuses = Status::orderBy('name')
      ->withCount('governmentProjects')
      ->paginate();
    }
    return response()->json(
      $statuses, 200
    );
  }

  /**
   * Get a single status or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    if (Status::all()->pluck('id')->contains($id) || $this->isNewStatus($id)) {
      if ($this->isNewStatus($id)) {
        return response()->json([
          'id' => NULL,
        ], 200);
      } else {
        $status = Status::find($id);

        if ($status) {
          return response()->json($status, 200);
        } else {
          return response()->json(null, 301);
        }
      }
    }
  }

  /**
   * Create or update a status.
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
      $status = Status::find($id);
    } else {
      if ($status = Status::onlyTrashed()->where('id', $id)->first()) {
        $status->restore();
      } else {
        $status = new Status(['id' => request('id')]);
      }
    }

    $status->fill($data);
    $status->save();

    return response()->json($status->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $status = Status::find($id);

    if ($status) {
      $status->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new status.
   *
   * @param string $id
   * @return bool
   */
  private function isNewStatus(string $id): bool
  {
    return $id === 'create';
  }
}
