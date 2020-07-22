<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Model\Blog\Post;
use Illuminate\Http\Request;

use App\Model\Util\CurrentTenant;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return the SPA with global variables.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request, $identifier = NULL, $slug = NULL)
    {
      $meta = array(
        'title' => '',
        'summary' => '',
        'summaryFromBody' => '',
        'image' => ''
      );

      if ($identifier) {
        $post = Post::where('slug', $slug)->with('user')->first();
        $meta['title'] = $post->title;
        $meta['summary'] = $post->summary;
        $meta['summaryFromBody'] = substr(strip_tags($post->body), 200);
        $meta['image'] = $post->featured_image;
        $meta['author'] = $post->user->name;
      }

      $currentTenant = new CurrentTenant();

      return view('layout', [
        'currentTenant' => $currentTenant->getState(),
        'meta' => $meta
      ]);
    }
}
