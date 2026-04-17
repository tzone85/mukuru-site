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

    /**
     * Test that HomeController class exists
     *
     * @return void
     */
    public function testHomeControllerExists()
    {
        $this->assertTrue(class_exists('App\Http\Controllers\HomeController'));
    }

    /**
     * Test HomeController basic structure
     *
     * @return void
     */
    public function testHomeControllerBasicStructure()
    {
        $reflection = new \ReflectionClass('App\Http\Controllers\HomeController');

        // Test that the class exists and is instantiable
        $this->assertTrue($reflection->isInstantiable());

        // Test that it has the expected methods
        $this->assertTrue($reflection->hasMethod('index'));
        $this->assertTrue($reflection->hasMethod('__construct'));
    }

    /**
     * Test HomeController index method signature
     *
     * @return void
     */
    public function testHomeControllerIndexMethod()
    {
        $reflection = new \ReflectionClass('App\Http\Controllers\HomeController');
        $indexMethod = $reflection->getMethod('index');

        // Test that the index method exists and is public
        $this->assertTrue($indexMethod->isPublic());
        $this->assertEquals('index', $indexMethod->getName());
    }

    /**
     * Test that HomeController extends base Controller
     *
     * @return void
     */
    public function testHomeControllerExtendsController()
    {
        $reflection = new \ReflectionClass('App\Http\Controllers\HomeController');

        // Test that it extends the base Controller class
        $this->assertEquals('App\Http\Controllers\Controller', $reflection->getParentClass()->getName());
    }
}