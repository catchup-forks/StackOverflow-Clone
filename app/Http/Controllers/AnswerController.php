<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Jinput;
use SOC\Create\Answer as AnswerCreator;
use SOC\Validate\Answer as AnswerValidator;

class AnswerController extends BaseController
{
    public function index(): Response
    {
        return response()->noContent();
    }

    public function create(): Response
    {
        return response()->noContent();
    }

    public function store(): Response
    {
        $input = Jinput::all();

        $validation = new AnswerValidator($input);

        if ($validation->passes()) {
            $answer = new AnswerCreator($input);
            $answer->add();

            return response('Answer created!');
        }

        return response()->json($validation->getErrors(), 422);
    }

    public function show(int $id): Response
    {
        return response()->noContent();
    }

    public function edit(int $id): Response
    {
        return response()->noContent();
    }

    public function update(int $id): Response
    {
        return response()->noContent();
    }

    public function destroy(int $id): Response
    {
        return response()->noContent();
    }
}
