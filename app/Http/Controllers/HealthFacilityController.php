<?php

namespace App\Http\Controllers;

use App\HealthFacility;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Auth, DB, Exception;

class HealthFacilityController extends Controller
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
      $healthFacilities = HealthFacility::all();
    } else {
      $healthFacilities = HealthFacility::orderBy('name')
        ->paginate();
    }

    return response()->json(
      $healthFacilities, 200
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
    if (HealthFacility::all()->pluck('id')->contains($id) || $this->isNewHealthFacility($id)) {
      if ($this->isNewHealthFacility($id)) {
        return response()->json([
          'id' => NULL,
        ], 200);
      } else {
        $healthFacility = HealthFacility::find($id);

        if ($healthFacility) {
          return response()->json($healthFacility, 200);
        } else {
          return response()->json(null, 301);
        }
      }
    }
  }

  /**
   * Create or update a healthFacility.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'unique_id' => request('unique_id'),
      'local_government_id' => request('local_government_id'),
      'ward' => request('ward'),
      'code' => request('code'),
      'name' => request('name'),
      'registration_no' => request('registration_no'),
      'start_date' => request('start_date'),
      'ownership' => request('ownership'),
      'facility_level' => request('facility_level'),
      'latitude' => request('latitude'),
      'longitude' => request('longitude'),
      'operation_status' => request('operation_status'),
      'registration_status' => request('registration_status'),
      'license_status' => request('license_status')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'unique_id' => 'required',
      'name' => 'required',
      'local_government_id' => 'required'
    ], $messages)->validate();

    if ($id !== 'create') {
      $healthFacility = HealthFacility::find($id);
    } else {
      if ($healthFacility = HealthFacility::onlyTrashed()->where('id', $id)->first()) {
        $healthFacility->restore();
      } else {
        $healthFacility = new HealthFacility(['id' => request('id')]);
      }
    }

    $healthFacility->fill($data);
    $healthFacility->save();

    return response()->json($healthFacility->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $healthFacility = HealthFacility::find($id);

    if ($healthFacility) {
      $healthFacility->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new healthFacility.
   *
   * @param string $id
   * @return bool
   */
  private function isNewHealthFacility(string $id): bool
  {
    return $id === 'create';
  }
}
