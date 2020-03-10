<?php


use App\Models\Sections;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class UserSectionTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker::create();

        $usersIds = User::pluck('id')->all();
        $sectionsIds = Sections::pluck('id')->all();

        for($i = 1; $i <= 20; $i++) {
            DB::table('user_section')->insert([
                'sections_id' => $faker->randomElement($sectionsIds),
                'user_id' => $faker->randomElement($usersIds)
            ]);
        }
    }
}
