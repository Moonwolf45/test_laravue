<?php


use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('sections')->delete();

        factory(App\Models\Sections::class, 15)->create();
    }
}
