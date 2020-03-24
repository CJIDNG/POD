<?php

namespace App\Http\Controllers;

use App\Agency;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\AgencyResource;
use Auth;
use DB;

class AgencyController extends Controller
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
      $agencies = Agency::all();
    } else {
      $agencies = Agency::orderBy('name')
      ->withCount('governmentProjects')
      ->paginate();
    }

    return response()->json(
      $agencies, 200
    );
  }

  /**
   * Get a single age$agency or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    if (Agency::all()->pluck('id')->contains($id) || $this->isNewAgency($id)) {
      if ($this->isNewAgency($id)) {
        $id = DB::connection('tenant')->select("SHOW TABLE STATUS LIKE 'agencies'");
        return response()->json([
          'id' => $id[0]->Auto_increment,
        ], 200);
      } else {
        $agency = Agency::find($id);

        if ($agency) {
          return response()->json($agency, 200);
        } else {
          return response()->json(null, 301);
        }
      }
    }
  }

  /**
   * Create or update a agency.
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
      $agency = Agency::find($id);
    } else {
      if ($agency = Agency::onlyTrashed()->where('id', $id)->first()) {
        $agency->restore();
      } else {
        $agency = new Agency(['id' => request('id')]);
      }
    }

    $agency->fill($data);
    $agency->save();

    return response()->json($agency->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $agency = Agency::find($id);

    if ($agency) {
      $agency->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new agency.
   *
   * @param string $id
   * @return bool
   */
  private function isNewAgency(string $id): bool
  {
    return $id === 'create';
  }
}
