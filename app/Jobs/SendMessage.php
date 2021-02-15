<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;
    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $message)
    {
        $this->to = $to;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            'to' => $this->to,
            'message' => $this->message,
        ];

        $client = new Client();
        $response = $client->request('POST', 'https://send.message/api/send', ['json' => $data]);

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Ошибка SendMessage сервиса');
        }
    }
}
