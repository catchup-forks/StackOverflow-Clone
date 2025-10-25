<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View as ViewContract;

abstract class BaseController extends Controller
{
    protected ViewContract|string|null $layout = null;

    protected function setupLayout(): void
    {
        if ($this->layout instanceof ViewContract) {
            return;
        }

        if (! is_null($this->layout)) {
            $this->layout = view($this->layout);
        }
    }
}
