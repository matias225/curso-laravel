<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Profession;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Con SQL
        //$professions = DB::select('SELECT id FROM professions WHERE title = ?', ['Back-end developer']);

        // Usando el constructor
        // $professionId = DB::table('professions')
        //     ->whereTitle('Back-end developer')
        //     ->value('id');

        // Con modelo
        $professionId = Profession::where('title', 'Back-end developer')->value('id');

        // Crear con constructor
        // DB::table('users')->insert([
        //     'name' => 'Matias Romani',
        //     'email' => 'mati.kbza22@gmail.com',
        //     'password' => bcrypt('1234'),
        //     'profession_id' => $professionId
        // ]);

        // Usuario insertado con SQL
        // DB::insert('INSERT INTO users (name, email, password, profession_id) 
        // values (:name, :email, :password, :profession_id)', [
        //     'name' => 'Gabriel Saez',
        //     'email' => 'gabi.kbza2014@gmail.com',
        //     'password' => bcrypt('cabezon'),
        //     'profession_id' => $professionId
        // ]);

        // User::create([
        //     'name' => 'Matias Romani',
        //     'email' => 'mati.kbza22@gmail.com',
        //     'password' => bcrypt('1234'),
        //     'profession_id' => $professionId,
        //     'is_admin' => true
        // ]);

        factory(User::class)->create([
            'name' => 'Matias Romani',
            'email' => 'mati.kbza22@gmail.com',
            'password' => bcrypt('1234'),
            'profession_id' => $professionId,
            'is_admin' => true
        ]);

        factory(User::class)->create([
            'profession_id' => $professionId
        ]);

        factory(User::class, 48)->create();
        
        // User::create([
        //     'name' => 'Santiago Romani',
        //     'email' => 'bachi225@gmail.com',
        //     'password' => bcrypt('hola'),
        //     'profession_id' => $professionId
        // ]);
        
        // User::create([
        //     'name' => 'Gabriel Saez',
        //     'email' => 'gabi.kbza2014@gmail.com',
        //     'password' => bcrypt('cabezon123'),
        //     'profession_id' => null
        // ]);
    }
}
