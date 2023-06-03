<?php

namespace Afaqy\Core\Http\Controllers;

use Afaqy\Core\Actions\Helpers\GenerateImageAction;

class CoreController extends Controller
{
    public function generateImage($path, $name)
    {
        return (new GenerateImageAction($path . '/' . $name))->execute();
    }

    public function debug()
    {
        throw new \Exception('My first Sentry error!');
    }
}
