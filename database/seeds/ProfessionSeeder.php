<?php

use Illuminate\Database\Seeder;
use App\Profession;
// Darle un alias
// use App\Profession as Profesion;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // SQL
        // DB::insert('INSERT INTO professions (title) VALUES (:title)', [
        //     'title' => 'Back-end Developer',
        // ]);

        // Constructor de laravel
        // DB::table('professions')->insert([
        //     'title' => 'Back-end developer',
        // ]);

        // Modelo
        Profession::create([
            'title' => 'Back-end developer',
        ]);

        Profession::create([
            'title' => 'Front-end developer',
        ]);

        Profession::create([
            'title' => 'Web developer',
        ]);

        factory(Profession::class)->times(17)->create();
        
        // Borrar profesion
        //DB::delete('DELETE FROM professions WHERE id = 1');
    }
}
