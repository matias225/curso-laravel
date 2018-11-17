<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserEditTest extends TestCase
{
    /** @test */
    function itLoadsEditUserPage() {
        $this->get('/usuarios/10/edit')
        ->assertStatus(200)
        ->assertSee("Editando al usuario: 10");
    }
}
