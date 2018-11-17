<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WelcomeUsersTest extends TestCase
{
    /** @test */
    public function itWelcomesUserWithNickname()
    {
        $this->get('/saludo/matias/kbza')
        ->assertStatus(200)
        ->assertSee("Bienvenido Matias, tu apodo es kbza");
    }

    /** @test */
    public function itWelcomesUserWithoutNickname()
    {
        $this->get('/saludo/matias')
        ->assertStatus(200)
        ->assertSee("Bienvenido Matias");
    }
}
