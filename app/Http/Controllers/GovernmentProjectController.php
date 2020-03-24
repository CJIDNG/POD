<?php

namespace App\Http\Controllers;

use App\GovernmentProject;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\GovernmentProjectResource;
use Auth;
use DB;

class GovernmentProjectController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(): JsonResponse
  {
    if (request()->has('filter') && request()->has('filterId')) {
      $filter = request('filter');
      $filterId = request('filterId');
      switch ($filter) {
        case 'agency':
          $governmentProjects = \App\Agency::findOrFail($filterId)->governmentProjects()->latest(); 
          break;
        
        case 'ministry':
          $governmentProjects = \App\Ministry::findOrFail($filterId)->governmentProjects()->latest();
          break;

        case 'state':
          $governmentProjects = \App\State::findOrFail($filterId)->governmentProjects()->latest();
          break;

        case 'localGovernment':
          $governmentProjects = \App\LocalGovernment::findOrFail($filterId)->governmentProjects()->latest();
          break;

        case 'status':
          $governmentProjects = \App\Status::findOrFail($filterId)->governmentProjects()->latest();
          break;

        case 'type':
          $governmentProjects = \App\Type::findOrFail($filterId)->governmentProjects()->latest();
          break;
        default:
          $governmentProjects = GovernmentProject::latest();
          break;
      }
    } else {
      $governmentProjects = GovernmentProject::latest();
    }

    if (request()->has('query')) {
      $query = request('query');
      $governmentProjects = $governmentProjects->whereRaw("MATCH(description)
        AGAINST('$query' IN NATURAL LANGUAGE MODE)")->latest();
    }

    return response()->json(
      $governmentProjects
        ->with('type', 'status', 'location', 'ministry', 'agency')
        ->paginate(), 200
    );
  }

  /**
   * Get a single governmentProject or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    if (GovernmentProject::all()->pluck('id')->contains($id) || $this->isNewGovernmentProject($id)) {
      if ($this->isNewGovernmentProject($id)) {
        $id = DB::connection('tenant')->select("SHOW TABLE STATUS LIKE 'government_projects'");
        return response()->json([
          'id' => $id[0]->Auto_increment,
        ], 200);
      } else {
        $governmentProject = GovernmentProject::with(
          'type', 
          'status', 
          'location', 
          'ministry', 
          'agency'
        )->where('id', $id)->first();

        if ($governmentProject) {
          return response()->json($governmentProject, 200);
        } else {
          return response()->json(null, 301);
        }
      }
    }
  }

  /**
   * Create or update a governmentProjects.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'description' => request('description'),
      'allocation' => request('allocation'),
      'agency_id' => request('agency_id'),
      'ministry_id' => request('ministry_id'),
      'date_commissioned' => request('date_commissioned'),
      'location_type' => request('location_type'),
      'location_id' => request('location_id'),
      'status_id' => request('status_id'),
      'type_id' => request('type_id'),
      'user_id' => $id === 'create' ? 
        request()->user()->id :
        request('user_id')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'description' => 'required'
    ], $messages)->validate();

    if ($id !== 'create') {
      $governmentProjects = GovernmentProject::find($id);
    } else {
      if ($governmentProjects = GovernmentProject::onlyTrashed()->where('id', $id)->first()) {
        $governmentProjects->restore();
      } else {
        $governmentProjects = new GovernmentProject(['id' => request('id')]);
      }
    }

    $governmentProjects->fill($data);
    $governmentProjects->save();

    return response()->json($governmentProjects->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $governmentProjects = GovernmentProject::find($id);

    if ($governmentProjects) {
      $governmentProjects->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new governmentProjects.
   *
   * @param string $id
   * @return bool
   */
  private function isNewGovernmentProject(string $id): bool
  {
    return $id === 'create';
  }
}
