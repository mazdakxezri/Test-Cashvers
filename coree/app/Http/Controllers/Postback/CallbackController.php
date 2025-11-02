<?php

namespace App\Http\Controllers\Postback;

use Illuminate\Http\Request;
use App\Models\Network;

class CallbackController extends PostbackController
{
    public function index(Request $request, $param_secret, $network_slug)
    {
        $network = Network::where([
            ['param_secret', $param_secret],
            ['network_slug', $network_slug],
            ['network_status', 1]
        ])->first();

        if (!$network) {
            return response('Invalid secret or network slug.', 404);
        }

        if (!in_array($network->postback_method, ['GET', 'POST']) || !$request->isMethod($network->postback_method)) {
            return response('Invalid request method.', 405);
        }

        return $this->processRequest($request, $network->network_name);
    }
}