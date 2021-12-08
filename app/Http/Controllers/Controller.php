<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $requestData;

    public function __construct()
    {
        $request           = request();
        $this->requestData = $request->all();
    }

    protected function catchError($error)
    {
        // OR some functionality here
        throw $error;
    }

}
