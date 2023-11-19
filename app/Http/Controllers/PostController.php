<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Http\Services\PostService;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{

    public function __construct(private PostService $postService)
    {
    }


    /**
     * @param CreatePostRequest $request
     * @return JsonResponse
     */
    public function store(CreatePostRequest $request):JsonResponse
    {
        return response()->json(['post' => $this->postService->createPost($request)], 201);
    }

    /**
     * @param EditPostRequest $request
     * @return JsonResponse
     */
    public function edit(EditPostRequest $request)
    {
        $this->postService->edit($request);

        return response()->json(['message' => 'Post updated successfully']);
    }


    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id):JsonResponse
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $post->delete();

        return response()->json(['message' => 'Post and translations deleted successfully'], 200);
    }

    /**
     * @param string $languageKey
     * @return JsonResponse
     */
    public function getPosts(string $languageKey):JsonResponse
    {
        return response()->json($this->postService->getPosts($languageKey), 200);
    }
}
