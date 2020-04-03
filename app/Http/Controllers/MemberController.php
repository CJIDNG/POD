<?php

namespace App\Http\Controllers;

use App\Member;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemberController extends Controller
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
      $members = Member::all();
    } else {
      $members = Member::orderBy('name')
        ->with('designations:title')
        ->paginate();
    }
    return response()->json(
      $members, 200
    );
  }

  /**
   * Get a single member or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    if (Member::all()->pluck('id')->contains($id) || $this->isNewMember($id)) {
      if ($this->isNewMember($id)) {
        return response()->json([
          'member' => Member::make([
            'id' => NULL,
          ]),
          'designations' => \App\Designation::get(['id','title'])
        ], 200);
      } else {
        $member = Member::with('designations')->find($id);

        return response()->json([
          'member' => $member,
          'designations' => \App\Designation::get(['id','title'])
        ], 200);
      }
    } else {
      return response()->json(null, 301);
    }
  }

  /**
   * Create or update a member.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'name' => request('name'),
      'bio' => request('bio'),
      'email' => request('email'),
      'phone_number' => request('phone_number'),
      'socials_meta' => request('socials_meta'),
      'avatar' => request('avatar')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'name' => 'required',
    ], $messages)->validate();

    $member = $id !== 'create' ? Member::find($id) : new Member(['id' => request('id')]);

    $member->fill($data);
    $member->save();

    $member->designations()->sync(request('designations'));

    return response()->json($member->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $member = Member::find($id);

    if ($member) {
      $member->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new member.
   *
   * @param string $id
   * @return bool
   */
  private function isNewMember(string $id): bool
  {
    return $id === 'create';
  }
}