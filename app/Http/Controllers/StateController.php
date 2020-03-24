<?php

namespace App\Http\Controllers;

use App\State;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\StateResource;
use Auth;
use DB;

class StateController extends Controller
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
      $states = State::all();
    } else {
      $states = State::orderBy('name')
      ->withCount('localGovernments')
      ->paginate();
    }
    return response()->json(
      $states, 200
    );
  }

  /**
   * Get a single $state or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    if (State::all()->pluck('id')->contains($id) || $this->isNewState($id)) {
      if ($this->isNewState($id)) {
        $id = DB::connection('tenant')->select("SHOW TABLE STATUS LIKE 'states'");
        return response()->json([
          'id' => $id[0]->Auto_increment,
        ], 200);
      } else {
        $state = State::find($id);

        if ($state) {
          return response()->json($state, 200);
        } else {
          return response()->json(null, 301);
        }
      }
    }
  }

  /**
   * Create or update a state.
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
      'code' => request('code')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'name' => 'required'
    ], $messages)->validate();

    if ($id !== 'create') {
      $state = State::find($id);
    } else {
      if ($state = State::onlyTrashed()->where('id', $id)->first()) {
        $state->restore();
      } else {
        $state = new State(['id' => request('id')]);
      }
    }

    $state->fill($data);
    $state->save();

    return response()->json($state->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $state = State::find($id);

    if ($state) {
      $state->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new state.
   *
   * @param string $id
   * @return bool
   */
  private function isNewState(string $id): bool
  {
    return $id === 'create';
  }
}
