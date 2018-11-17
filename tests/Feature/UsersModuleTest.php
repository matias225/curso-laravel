<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersModuleTest extends TestCase
{
    use RefreshDatabase;

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
        ->assertSee('Crear Usuario');
    }

    /** @test */
    function itDisplaysA404ErrorIfTheUserIsNotFound() {
        $this->get('/usuarios/999')
            ->assertStatus(404)
            ->assertSee('Página no encontrada');
    }

    /** @test */
    function itCreatesANewUser()
    {
        $this->withoutExceptionHandling();

        $this->post('/usuarios/', [
            'name' => 'Matias',
            'email' => 'mati@mati.com',
            'password' => '1234'
        ])->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Matias',
            'email' => 'mati@mati.com',
            'password' => '1234'
        ]);
    }
}
