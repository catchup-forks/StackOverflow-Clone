<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;

class QuestionController extends BaseController
{
    public function index()
    {
        return response()->noContent();
    }

    public function create()
    {
        return response()->noContent();
    }

    public function store()
    {
        return response()->noContent();
    }

    public function show(int $id)
    {
        $post = Post::where('id', '=', $id)->first();
        $answer = Post::where('id', '=', optional($post)->accepted_answer_id)->first();
        $answers = Post::with(['votes'])
            ->where('parent_id', '=', optional($post)->id)
            ->where('id', '<>', optional($post)->accepted_answer_id)
            ->get();
        $tags = Tag::all();

        $data = [
            'post' => $post,
            'answer' => $answer,
            'answers' => $answers,
            'tags' => $tags,
        ];

        return view('public.question.index', $data);
    }

    public function edit(int $id)
    {
        return response()->noContent();
    }

    public function update(int $id)
    {
        return response()->noContent();
    }

    public function destroy(int $id)
    {
        return response()->noContent();
    }
}
