<?php

namespace App\Jobs;

use App\Jobs\Job;
use Mandrill;
use App\Domain;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class AddMandrillDomain extends Job implements SelfHandling, ShouldQueue
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
                ->subject('Adding Mandrill Domain');
        });
        try {
            $mandrill = new Mandrill(env('MANDRILL_API'));
            $mandrill_domain = $this->domain->stub.'.holr.help';
            $result = $mandrill->inbound->addDomain($mandrill_domain);
        } catch(Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Invalid_Key - Invalid API key
            throw $e;
        }
    }
}
