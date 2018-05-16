<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp;

class DnsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function zonelist()
    {
        $client = new GuzzleHttp\Client();
        $res = $client->get('https://api.memset.com/v1/json/dns.zone_list', ['auth' => ['6a417319411545ebb322a716db820307', 'x']]);
        echo $res->getStatusCode(); // 200
        $decode = json_decode($res->getBody());
//        echo '<pre>';
//        print_r($decode);
//        echo '</pre>';
        $zone_ids = [];
        foreach($decode as $domain) {
//            if($domain->domains[0]->domain == 'holr.help') {
            if(array_key_exists('0',$domain->domains)) {
                if($domain->domains[0]->domain == 'holr.help') {
//                    echo '<pre>';
//                    print_r($domain->records);
//                    echo '</pre>';
                    foreach($domain->records as $record) {
                        if($record->record == 'foo' && ($record->address == '30248469.in1.mandrillapp.com' || $record->address = '30248469.in2.mandrillapp.com')) {
                            $zone_ids[] = $record->id;
                        }
                    }
                }
            }
        }

        foreach($zone_ids as $zid) {
            $res = $client->get('https://api.memset.com/v1/json/dns.zone_record_delete', ['auth' =>  ['6a417319411545ebb322a716db820307', 'x'],
                'query' => [
                    'id' => $zid
                    ]]);
            $res->getStatusCode();
        }
    }

    public function zoneRecordList()
    {
        $client = new GuzzleHttp\Client();
        $res = $client->get('https://api.memset.com/v1/json/dns.zone_record_list', ['auth' => ['3b87a641676042e6ace804b8c62114ec', 'x'],
        ]);
        echo $res->getStatusCode();
        echo $res->getBody();
    }


    public function zoneRecordCreate($domain)
    {
        $client = new GuzzleHttp\Client();
        $res = $client->get('https://api.memset.com/v1/json/dns.zone_record_create', ['auth' =>  ['3b87a641676042e6ace804b8c62114ec', 'x'],
            'query' => [
            'zone_id' => '083d889ed87925e70b685d77bbef862f',
            'type' => 'MX',
            'record' => strtolower($domain),
            'address' => '30248469.in1.mandrillapp.com',
            'priority' => 10]]);
        $res->getStatusCode();


        $res = $client->get('https://api.memset.com/v1/json/dns.zone_record_create', ['auth' =>  ['3b87a641676042e6ace804b8c62114ec', 'x'],
                'query' => [
                'zone_id' => '083d889ed87925e70b685d77bbef862f',
                'type' => 'MX',
                'record' => strtolower($domain),
                'address' => '30248469.in2.mandrillapp.com',
                'priority' => 20]]);
        $res->getStatusCode();
        echo $res->getBody();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
