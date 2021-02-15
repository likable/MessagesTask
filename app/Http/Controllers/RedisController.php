<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendMessage;

class RedisController extends Controller
{
    /**
     * Обработка Post запроса - постановка отправки сообщения в очередь
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function multisend(Request $request)
    {
        if (empty($request->to) || empty($request->message) || !is_array($request->to)) {
            return response('', 400);
        }

        foreach ($request->to as $to) {
            if (is_int($to)) {
                SendMessage::dispatch($to, $request->message);
            }
        }

        return response('', 200);
    }

}
