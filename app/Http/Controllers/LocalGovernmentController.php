<?php

namespace App\Http\Controllers;

use App\LocalGovernment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\LocalGovernmentResource;
use Auth;
use DB;

class LocalGovernmentController extends Controller
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
      $localGovernments = LocalGovernment::all();
    } else {
      $localGovernments = LocalGovernment::orderBy('name')
        ->with('state')
        ->withCount('governmentProjects')
        ->paginate();
    }

    return response()->json(
      $localGovernments, 200
    );
  }

  /**
   * Get a single age$localGovernment or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    if (LocalGovernment::all()->pluck('id')->contains($id) || $this->isNewLocalGovernment($id)) {
      if ($this->isNewLocalGovernment($id)) {
        $id = DB::connection('tenant')->select("SHOW TABLE STATUS LIKE 'local_governments'");
        return response()->json([
          'id' => $id[0]->Auto_increment,
        ], 200);
      } else {
        $localGovernment = LocalGovernment::find($id);

        if ($localGovernment) {
          return response()->json($localGovernment, 200);
        } else {
          return response()->json(null, 301);
        }
      }
    }
  }

  /**
   * Create or update a localGovernment.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'name' => request('name'),
      'latitude' => request('latitude'),
      'longitude' => request('longitude'),
      'code' => request('code'),
      'state_id' => request('state_id')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'name' => 'required'
    ], $messages)->validate();

    if ($id !== 'create') {
      $localGovernment = LocalGovernment::find($id);
    } else {
      if ($localGovernment = LocalGovernment::onlyTrashed()->where('id', $id)->first()) {
        $localGovernment->restore();
      } else {
        $localGovernment = new LocalGovernment(['id' => request('id')]);
      }
    }

    $localGovernment->fill($data);
    $localGovernment->save();

    return response()->json($localGovernment->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $localGovernment = LocalGovernment::find($id);

    if ($localGovernment) {
      $localGovernment->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new localGovernment.
   *
   * @param string $id
   * @return bool
   */
  private function isNewLocalGovernment(string $id): bool
  {
    return $id === 'create';
  }
}
