<?php

namespace App\Http\Controllers;

use App\Incident;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Auth, DB, Exception;

class IncidentController extends Controller
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
      $incidents = Incident::all();
    } else {
      if (request()->has('filter') && request()->has('filterId')) {
        $filter = request('filter');
        $filterId = request('filterId');
        switch ($filter) {
          case 'health-facility':
            $incidents = \App\HealthFacility::findOrFail($filterId)->incidents()->latest(); 
            break;
  
          case 'status':
            $incidents = \App\Status::findOrFail($filterId)->incidents()->latest();
            break;
  
          case 'type':
            $incidents = \App\Type::findOrFail($filterId)->incidents()->latest();
            break;
          default:
            $incidents = Incident::latest();
            break;
        }
      } else {
        $incidents = Incident::latest();
      }
  
      if (request()->has('query')) {
        $query = request('query');
        $incidents = $incidents->whereRaw("MATCH(title,description,address)
          AGAINST('$query' IN NATURAL LANGUAGE MODE)")->latest();
      }
    }

    return response()->json(
      $incidents
        ->with('type', 'status')
        ->paginate(), 200
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
    if (Incident::all()->pluck('id')->contains($id) || $this->isNewIncident($id)) {
      if ($this->isNewIncident($id)) {
        return response()->json([
          'id' => NULL,
          'status_id' => \App\Status::select('id')->where('name', 'Unverified')->first()->id ?? NULL
        ], 200);
      } else {
        $incident = Incident::with(
          'status', 
          'type', 
          'healthFacility', 
          'user'
        )->where('id', $id)->first();
        if ($incident) {
          return response()->json($incident, 200);
        } else {
          return response()->json(null, 301);
        }
      }
    }
  }

  /**
   * Create or update a incident.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'title' => request('title'),
      'description' => request('description'),
      'date' => request('date'),
      'type_id' => request('type_id'),
      'status_id' => request('status_id'),
      'health_facility_id' => request('health_facility_id'),
      'address' => request('address'),
      'news_source_link' => request('news_source_link'),
      'external_video_link' => request('external_video_link'),
      'user_id' => $id === 'create' ? request()->user()->id : request('user_id')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'title' => 'required',
      'address' => 'required',
      'description' => 'required',
      'date' => 'required',
      'type_id' => 'required',
      'status_id' => 'required',
      'health_facility_id' => 'required',
      'address' => 'required'
    ], $messages)->validate();

    if ($id !== 'create') {
      $incident = Incident::find($id);
    } else {
      if ($incident = Incident::onlyTrashed()->where('id', $id)->first()) {
        $incident->restore();
      } else {
        $incident = new Incident(['id' => request('id')]);
      }
    }

    $incident->fill($data);
    $incident->save();

    return response()->json($incident->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $incident = Incident::find($id);

    if ($incident) {
      $incident->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new incident.
   *
   * @param string $id
   * @return bool
   */
  private function isNewIncident(string $id): bool
  {
    return $id === 'create';
  }
}
