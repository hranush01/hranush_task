<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCommentRequest;
use App\Http\Services\PostService;
use Illuminate\Http\JsonResponse;

class PostCommentController extends Controller
{
    /**
     * @param PostCommentRequest $request
     * @return JsonResponse
     */
    public function store(PostCommentRequest $request):JsonResponse
    {
        return response()->json(app(PostService::class)->createPostCommand($request), 201);
    }
}
