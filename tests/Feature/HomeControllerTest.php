<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test authenticated user can access home route
     *
     * @return void
     */
    public function testAuthenticatedUserCanAccessHome()
    {
        // Create and authenticate a user
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    /**
     * Test unauthenticated user is redirected from home route
     *
     * @return void
     */
    public function testUnauthenticatedUserCannotAccessHome()
    {
        $response = $this->get('/home');

        // Should be redirected to login (typically 302 status)
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test middleware protection is working
     *
     * @return void
     */
    public function testMiddlewareProtectionIsWorking()
    {
        // Test without authentication
        $response = $this->get('/home');

        // Verify redirect happens (middleware working)
        $this->assertTrue($response->isRedirect());
        $response->assertRedirect('/login');
    }

    /**
     * Test home route returns correct view
     *
     * @return void
     */
    public function testHomeRouteReturnsCorrectView()
    {
        // Create and authenticate a user
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    /**
     * Test home route name is accessible
     *
     * @return void
     */
    public function testHomeRouteNameIsAccessible()
    {
        // Create and authenticate a user
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertStatus(200);
        $response->assertViewIs('home');
    }
}