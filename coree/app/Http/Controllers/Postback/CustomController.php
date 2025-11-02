<?php

namespace App\Http\Controllers\Postback;

use Illuminate\Http\Request;

class CustomController extends PostbackController
{
    public function index(Request $request, $param_secret, $network_name)
    {
        return $this->processRequest($request, $network_name, $param_secret, null, true);
    }
}
