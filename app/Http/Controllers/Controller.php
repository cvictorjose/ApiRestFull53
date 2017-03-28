<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function createMessage($msg, $code)
    {
        return response()->json(['data' => $msg, 'code' => $code], $code);
    }

    public function createMetaMessage($msg, $code)
    {
        return response()->json(['meta' => $msg, 'code' => $code], $code);
    }

    public function createMessageError($msg, $code)
    {
        return response()->json(['message' => $msg, 'code' => $code], $code);
    }

}
