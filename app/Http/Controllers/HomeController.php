<?php

namespace App\Http\Controllers;

class HomeController extends BaseController
{
    public function index(): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('filament.app.resources.questions.index');
    }
}
