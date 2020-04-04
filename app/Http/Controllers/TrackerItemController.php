<?php

namespace App\Http\Controllers;

use App\TrackerItem;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrackerItemController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index($trackerId): JsonResponse
  {
    $tracker = \App\Tracker::find($trackerId);

    $trackerItems = $tracker
      ->trackedItems()
      ->orderBy('created_at', 'DESC')
      ->paginate();

    return response()->json(
      $trackerItems, 200
    );
  }

  /**
   * Get a single trackerItem or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($trackerId, $id = null): JsonResponse
  {
    if (TrackerItem::all()->pluck('id')->contains($id) || $this->isNewTrackerItem($id)) {
      if ($this->isNewTrackerItem($id)) {
        return response()->json(TrackerItem::make([
          'id' => NULL,
        ]), 200);
      } else {
        $trackerItem = TrackerItem::find($id);

        return response()->json($trackerItem, 200);
      }
    } else {
      return response()->json(null, 301);
    }
  }

  /**
   * Create or update a trackerItem.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'tracker_id' => request('tracker_id'),
      'title' => request('title'),
      'location_id' => request('location_id'),
      'location_type' => request('location_type'),
      'meta' => request('meta'),
      'confirmed' => request('confirmed'),
      'user_id' => $this->isNewTrackerItem(request('id')) ? request()->user()->id : request('user_id')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'tracker_id' => 'required',
      'title' => 'required',
      'meta' => 'required',
      'confirmed' => 'required',
      'user_id' => 'required',
    ], $messages)->validate();

    $trackerItem = $id !== 'create' ? TrackerItem::find($id) : new TrackerItem(['id' => request('id')]);

    $trackerItem->fill($data);
    $trackerItem->save();

    return response()->json($trackerItem->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $trackerItem = TrackerItem::find($id);

    if ($trackerItem) {
      $trackerItem->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new trackerItem.
   *
   * @param string $id
   * @return bool
   */
  private function isNewTrackerItem(string $id): bool
  {
    return $id === 'create';
  }
}
