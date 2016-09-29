<?php

namespace App\Http\Controllers\Wordpress;

use App\Wordpress\Model\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    /**
     * PostController constructor.
     */
    public function __construct()
    {

    }

    /**
     * Get all post by search
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchPosts(Request $request) {

        $post = [];

        if ($query = $request->get('query', false)){

            $post = Post::where(function ($q) use($query) {
                    $q->orWhere('post_title', 'LIKE', "%{$query}%");
                    $q->orWhere('post_content', 'LIKE', "%{$query}%");
                    $q->orWhere('post_excerpt', 'LIKE', "%{$query}%");
                })
                ->where('post_type', 'page')
                ->where('post_status', 'publish')
                ->get();

            if ($post->count() > 0) {
                $post->transform(function ($post) use ($query) {
                    $cases = [
                        strtolower($query),
                        ucfirst($query)
                    ];

                    foreach ($cases as $case) {
                        $post->post_title = str_replace($case, '<b>' . $case . '</b>', $post->post_title);
                        $post->post_excerpt = str_replace($case, '<b>' . $case . '</b>', $post->post_excerpt);
                    }

                    $parent = $post->getParentTerm();
                    if ($parent) {
                        $post->link = 'http://' . $_SERVER['HTTP_HOST'] .'/'. 'posts/' . $parent->slug;
                    }

                    return $post;
                });

                $post = $post->toArray();
            }
        }

        return response()->json(['status' => 200, 'data' => $post]);
    }

    /**
     * Get all post
     *
     * @param $post_type string
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPosts($post_type = 'page') {
        $products = Post::where('post_type', $post_type)
            ->where('post_status', 'publish')
            ->get();

        foreach ($products as $product) {
            $files = $product->getFiles();

            if (count($files)) {
                $product->main_image = $files->last();
            }
        }

        return response()->json(['status' => 200, 'data' => $products]);
    }
    
}
