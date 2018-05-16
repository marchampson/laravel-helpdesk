<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Domain;
use GuzzleHttp;
use Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddMemsetRecords extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $domain;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::raw('Hello world', function($message) {
            $message->to('mhampson@wk360.com')
                ->from('noreply@foo.com')
                ->subject('Adding memset record');
        });

        $client = new GuzzleHttp\Client();
        $res = $client->get('https://api.memset.com/v1/json/dns.zone_record_create', ['auth' =>  ['6a417319411545ebb322a716db820307', 'x'],
            'query' => [
                'zone_id' => '083d889ed87925e70b685d77bbef862f',
                'type' => 'MX',
                'record' => $this->domain->stub,
                'address' => '30248469.in1.mandrillapp.com',
                'priority' => 10]]);
        $res->getStatusCode();

        $res = $client->get('https://api.memset.com/v1/json/dns.zone_record_create', ['auth' =>  ['6a417319411545ebb322a716db820307', 'x'],
            'query' => [
                'zone_id' => '083d889ed87925e70b685d77bbef862f',
                'type' => 'MX',
                'record' => $this->domain->stub,
                'address' => '30248469.in2.mandrillapp.com',
                'priority' => 20]]);
        $res->getStatusCode();
    }
}
