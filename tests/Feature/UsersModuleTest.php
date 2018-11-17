<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UsersModuleTest extends TestCase
{

    /** @test */
    function itShowsTheUsersList() {

        factory(User::class)->create([
            'name' => 'Rocio',
        ]);

        factory(User::class)->create([
            'name' => 'Joel',
        ]);

        $this->get('/usuarios')
        ->assertStatus(200)
        ->assertSee('Listado de usuarios')
        ->assertSee('Joel')
        ->assertSee('Rocio');
    }
   
    /** @test */
    function itShowsADefaultMessageIfTheUsersListIsEmpty() {
        DB::table('users')->truncate();
        $this->get('/usuarios')
        ->assertStatus(200)
        ->assertSee('No hay usuarios registrados.');
    }
    
    /** @test */
    function itDisplaysTheUsersDetails() {
        $user = factory(User::class)->create([
            'name' => 'Matias Romani'
        ]);

        $this->get('/usuarios/'.$user->id)
        ->assertStatus(200)
        ->assertSee('Matias Romani');
    }
    
    /** @test */
    function itLoadsTheNewUsersPage() {
        $this->get('/usuarios/nuevo')
        ->assertStatus(200)
        ->assertSee('Crear nuevo usuario');
    }

    /** @test */
    function itDisplaysA404ErrorIfTheUserIsNotFound() {
        $this->get('/usuarios/999')
            ->assertStatus(404)
            ->assertSee('Página no encontrada');
    }
}
