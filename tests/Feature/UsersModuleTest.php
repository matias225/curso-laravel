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
            'name' => 'Joel',
        ]);

        $this->get('/usuarios')
        ->assertStatus(200)
        ->assertSee('Listado de usuarios')
        ->assertSee('Joel');
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

        $this->get("/usuarios/{$user->id}")
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
            'password' => '123456'
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
            'password' => '123456'
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
            'password' => '123456'
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
            'password' => '123456'
        ])
            ->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors([
                'email' => 'The email has already been taken.'
            ]);

        $this::assertEquals(1, User::count());
    }

    /** @test */
    function itLoadsTheEditUsersPage()
    {
        $user = factory(User::class)->create();

        $this->get("/usuarios/{$user->id}/editar")
            ->assertStatus(200)
            ->assertViewIs('users.edit')
            ->assertSee("Editando al usuario")
            ->assertViewHas('user', function ($viewUser) use ($user) {
                return $viewUser->id == $user->id;
            });
    }

    /** @test */
    function itUpdatesAUser()
    {
        $user = factory(User::class)->create();

        $this->withoutExceptionHandling();

        $this->put("/usuarios/{$user->id}", [
            'name' => 'Matias',
            'email' => 'mati@mati.com',
            'password' => '123456'
        ])->assertRedirect("/usuarios/{$user->id}");

        $this->assertCredentials([
            'name' => 'Matias',
            'email' => 'mati@mati.com',
            'password' => '123456'
        ]);
    }


    /* ############################################################
                              UPDATES
    ############################################################ */


    /** @test */
    function theNameIsRequiredWhenUpdatingTheUser()
    {
        $user = factory(User::class)->create();

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => '',
                'email' => 'mati@mati.com',
                'password' => '123456'
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors([
                'name' => 'The name field is required.'
            ]);

        $this->assertDatabaseMissing('users', ['email' => 'mati@mati.com']);
    }

    /** @test */
    function theEmailIsRequiredWhenUpdatingTheUser()
    {
        $user = factory(User::class)->create();

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Matias',
                'email' => '',
                'password' => '123456'
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors([
                'email' => 'The email field is required.'
            ]);

        $this->assertDatabaseMissing('users', ['name' => 'Matias']);
    }

    /** @test */
    function theEmailMustBeValidWhenUpdatingTheUser()
    {
        $user = factory(User::class)->create();

        $this->from("usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
                'name' => 'Nombre actualizado',
                'email' => 'correo-no-valido',
                'password' => '123456'
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors([
                'email' => 'The email must be a valid email address.'
            ]);

        $this->assertDatabaseMissing('users', ['name' => 'Nombre actualizado']);
    }

    /** @test */
    function thePasswordIsOptionalWhenUpdatingTheUser()
    {
        $oldPassword = 'CLAVE_ANTERIOR';

        $user = factory(User::class)->create([
            'password' => bcrypt($oldPassword)
        ]);

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Matias',
                'email' => 'mati@mati.com',
                'password' => ''
            ])
            ->assertRedirect("usuarios/{$user->id}"); // users.show

        $this->assertCredentials([
            'name' => 'Matias',
            'email' => 'mati@mati.com',
            'password' => $oldPassword
        ]);
    }

    /** @test */
    function theEmailMustBeUniqueWhenUpdatingTheUser()
    {
        factory(User::class)->create([
            'email' => 'existing.email@example.com'
        ]);
        $user = factory(User::class)->create([
            'email' => 'mati.kbza22@gmail.com'
        ]);

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Matias',
                'email' => 'existing.email@example.com',
                'password' => '123456'
            ])
            ->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors([
                'email' => 'The email has already been taken.'
            ]);
    }

    /** @test */
    function theUsersEmailCanStayTheSameWhenUpdatingTheUser()
    {
        $user = factory(User::class)->create([
            'email' => 'mati@mati.com'
        ]);

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Matias Romani 2',
                'email' => 'mati@mati.com',
                'password' => '123456'
            ])
            ->assertRedirect("usuarios/{$user->id}"); // users.show

        $this->assertDatabaseHas('users', [
            'name' => 'Matias Romani 2',
            'email' => 'mati@mati.com',
        ]);
    }

    /** @test */
    function itDeletesAUser()
    {
        $user = factory(User::class)->create();

        $this->delete("usuarios/{$user->id}")
            ->assertRedirect('usuarios');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}
