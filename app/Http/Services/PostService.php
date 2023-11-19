<?php

namespace App\Http\Services;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Http\Requests\PostCommentRequest;
use App\Models\Language;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class PostService{

    /**
     * @param CreatePostRequest $request
     * @return Post
     */
    public function createPost(CreatePostRequest $request):Post
    {
        return DB::transaction(function () use ($request) {

            $path = ($request->file('image'))
                ->store('images', 'public');

            $post = new Post();
            $post->image = $path;

            $post->save();
            $post->translations()->createMany($this->getPostContentWithLanguage($request->contents));
            $post->load('translations');

            return $post;
        });

    }

    /**
     * @param array $contents
     * @return array
     */
    private function getPostContentWithLanguage(array $contents):array
    {
        $languageCodes = array_keys($contents);
        $languages = Language::whereIn('code', $languageCodes)->pluck('id', 'code');

        $postTranslations = [];

        foreach ($contents as $languageCode => $value){
            $postTranslations[] =[
                'name' => $value['title'],
                'description' => $value['description'],
                'language_id' => $languages[$languageCode]
            ];
        }

        return $postTranslations;

    }

    /**
     * @param PostCommentRequest $request
     * @return PostComment
     */
    public function createPostCommand(PostCommentRequest $request):PostComment
    {
        $post_comment = new PostComment();
        $post_comment->setPostComment($request);
        $post_comment->save();

        return $post_comment;
    }


    /**
     * @param EditPostRequest $request
     * @return void
     */
    public function edit(EditPostRequest $request):void
    {
        DB::transaction(function () use ($request) {

            $post = Post::find($request->post_id);

            if ($image = $request->file('image')) {
                Storage::delete('/images/'.$post->image);

                $post->image = $image->store('images', 'public');
                $post->save();
            }

            $language = Language::where('code', $request->language_code)->first();
            $postTranslation = $post->translations()->where('language_id', $language->id)->first();

            if (!$postTranslation) {
                throw new UnprocessableEntityHttpException("Post translation not found for
             the given language");
            }

            $postTranslation->update([
                'name' => $request->title
            ]);

        });
    }

    /**
     * @param string $languageKey
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getPosts(string $languageKey)
    {
        $language = Language::where('code', $languageKey)->first();

        if (!$language) {
            throw new UnprocessableEntityHttpException("Language not found");
        }

        return Post::with(['translations' => function ($query) use ($language) {
            $query->where('language_id', $language->id)->with(['comments']);
        }])->get();
    }


}
