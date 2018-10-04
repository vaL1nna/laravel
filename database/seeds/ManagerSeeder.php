<?php

use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*\DB::table('manager')->insert(
            ['username'=>'admin', 'password'=>bcrypt('123456')]
        );*/

        $faker = \Faker\Factory::create('zh_CN');
        for($i=0; $i<10; $i++){
            \App\Manager::create([
                'username'=>$faker->name,
                'password'=>bcrypt('123456')
            ]);
        }
    }
}
