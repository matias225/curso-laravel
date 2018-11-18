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
            'password' => '123456'
        ])->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Matias',
            'email' => 'mati@mati.com',
            'password' => '123456'
        ]);
    }

    /** @test */
    function theNameIsRequired()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
            'name' => '',
            'email' => 'mati@mati.com',
            'password' => '1234'
        ])
        ->assertRedirect('usuarios/nuevo')
        ->assertSessionHasErrors([
            'name' => 'The name field is required.'
        ]);

        $this::assertEquals(0, User::count());

        /*
        $this->assertDatabaseMissing('users', [
            'email' => 'matias@gmail.com'
        ]);*/
    }

    /** @test */
    function theEmailIsRequired()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
            'name' => 'Matias',
            'email' => '',
            'password' => '1234'
        ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors([
                'email' => 'The email field is required.'
            ]);

        $this::assertEquals(0, User::count());
    }

    /** @test */
    function thePasswordIsRequired()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
            'name' => 'Matias',
            'email' => 'mati@mati.com',
            'password' => ''
        ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors([
                'password' => 'The password field is required.'
            ]);

        $this::assertEquals(0, User::count());
    }

    /** @test */
    function thePasswordMustBe6Characters()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
                'name' => 'Matias',
                'email' => 'mati@mati.com',
                'password' => '1234'
            ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors([
                'password' => 'The password must be at least 6 characters.'
            ]);

        $this::assertEquals(0, User::count());
    }

    /** @test */
    function theEmailMustBeValid()
    {
        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
            'name' => 'Matias',
            'email' => 'correo-no-valido',
            'password' => '1234'
        ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors([
                'email' => 'The email must be a valid email address.'
            ]);

        $this::assertEquals(0, User::count());
    }

    /** @test */
    function theEmailMustBeUnique()
    {
        factory(User::class)->create([
            'email' => 'mati@mati.com'
        ]);

        $this->from('usuarios/nuevo')
            ->post('/usuarios/', [
            'name' => 'Matias',
            'email' => 'mati@mati.com',
            'password' => '1234'
        ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors([
                'email' => 'The email has already been taken.'
            ]);

        $this::assertEquals(1, User::count());
    }
}
