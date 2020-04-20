<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Topic;
use App\Events\PostViewed;
use Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
  /**
   * return posts
   */
  public function getPosts($limit) {
    $posts = Post::published()->orderByDesc('published_at')->paginate($limit);

    return $posts;
  }

  /**
   * Show the blog homepage with a paginated list of results.
   *
   * @return JsonResponse
   */
  public function index(): JsonResponse
  {
    $data = Post::published()
      ->orderByDesc('published_at')
      ->withCount('views')
      ->with('tags')
      ->simplePaginate();

    if (request('filterBy') == 'tag' && request('filter')) {
      $data = $this->tag(request('filter'));
    }

    if (request('filterBy') == 'topic' && request('filter')) {
      $data = $this->topic(request('filter'));
    }

    return response()->json([
      'current_page' => $data->currentPage(),
      'data' => $data->items(),
      'first_page_url' => '',
      'from' => '',
      'next_page_url' => $data->nextPageUrl(),
      'path' => '',
      'per_page' => $data->perPage(),
      'prev_page_url' => $data->previousPageUrl(),
      'to' => '',
      'topics' => Topic::all(['name', 'slug']),
      'tags' => Tag::all(['name', 'slug'])
    ], 200);
  }

  /**
   * Show a single post.
   *
   * @param string $slug
   * @return JsonResponse
   */
  public function post(string $slug): JsonResponse
  {
    $posts = Post::with('user', 'editor', 'tags', 'topic')->published()->get();
    $post = $posts->firstWhere('slug', $slug);

    if (optional($post)->published) {
      $next = $posts->sortBy('published_at')->firstWhere('published_at', '>', optional($post)->published_at);

      $filtered = $posts->filter(function ($value, $key) use ($slug, $next) {
        return $value->slug != $slug && $value->slug != optional($next)->slug;
      });

      if ($post->tags->isNotEmpty()) {
        $related = Post::whereHas('tags', function ($query) use ($post, $next) {
          return $query->whereIn('name', $post->tags->pluck('slug'));
        })
          ->where('id', '!=', $post->id)
          ->where('id', '!=', optional($next)->id)
          ->get();

        if ($related->isEmpty()) {
          $random = $filtered->count() > 1 ? $filtered->random() : null;
        } else {
          $random = $related->random();
        }
      } else {
        if ($filtered->isNotEmpty()) {
          $filtered->random();
        }
        $random = null;
      }

      $data = [
        'post'   => $post,
        'meta'   => $post->meta,
        'next'   => $next,
        'random' => $random,
        'topic'  => $post->topic->first() ?? null,
      ];

      event(new PostViewed($post));

      return response()->json($data, 200);
    } else {
      abort(404);
    }
  }

  /**
   * Show all posts with a given tag.
   *
   * @param string $slug
   * @return object
   */
  public function tag(string $slug): object
  {
    $tag = Tag::with('posts')->where('slug', $slug)->first();

    if ($tag) {
      return Post::whereHas('tags', function ($query) use ($slug) {
          $query->where('slug', $slug);
      })->orderByDesc('published_at')
        ->withCount('views')
        ->with('tags')
        ->simplePaginate(10);
    } else {
      return [];
    }
  }

  /**
   * Show all posts under a given topic.
   *
   * @param string $slug
   * @return object
   */
  public function topic(string $slug): object
  {
    $topic = Topic::with('posts')->where('slug', $slug)->first();

    if ($topic) {
      return Post::whereHas('topic', function ($query) use ($slug) {
        $query->where('slug', $slug);
      })->orderByDesc('published_at')
        ->withCount('views')
        ->with('tags')
        ->simplePaginate(10);
    } else {
      return [];
    }
  }
}
