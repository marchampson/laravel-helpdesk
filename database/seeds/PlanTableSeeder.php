<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Plan;

class PlanTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->delete();

        Plan::create([
            'name' => 'holr_1',
            'cost' => 2.99,
            'num_agents' => 1,
            'num_domains' => 1
        ]);

        Plan::create([
            'name' => 'holr_2',
            'cost' => 14.99,
            'num_agents' => 2,
            'num_domains' => 5
        ]);

        Plan::create([
            'name' => 'holr_3',
            'cost' => 24.99,
            'num_agents' => 3,
            'num_domains' => 10
        ]);

        Plan::create([
            'name' => 'holr_4',
            'cost' => 5,
            'num_agents' => 1,
            'num_domains' => 1
        ]);

        Plan::create([
            'name' => 'holr_5',
            'cost' => 20,
            'num_agents' => 2,
            'num_domains' => 5
        ]);

        Plan::create([
            'name' => 'holr_6',
            'cost' => 35,
            'num_agents' => 3,
            'num_domains' => 10
        ]);

    }

}