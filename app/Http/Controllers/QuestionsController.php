<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class QuestionsController extends BaseController
{
    public function index(Request $request)
    {
        $sort = ['name' => '', 'direction' => ''];

        switch ($request->get('sort')) {
            case 'newest':
                $sort['name'] = 'created_at';
                $sort['direction'] = 'desc';
                break;
            case 'oldest':
                $sort['name'] = 'created_at';
                $sort['direction'] = 'asc';
                break;
            case 'most viewed':
                $sort['name'] = 'view_count';
                $sort['direction'] = 'desc';
                break;
            default:
                $sort['name'] = 'created_at';
                $sort['direction'] = 'desc';
                break;
        }

        $questions = Post::orderBy($sort['name'], $sort['direction'])
            ->where('post_type_id', '=', '1')
            ->paginate(10);
        $tags = Tag::all();

        $data = [
            'questions' => $questions,
            'tags' => $tags,
        ];

        return view('public.questions.index', $data);
    }
}
