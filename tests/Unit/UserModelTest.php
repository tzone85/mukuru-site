<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Notifiable;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that User class exists
     *
     * @return void
     */
    public function testUserClassExists()
    {
        $this->assertTrue(class_exists('App\User'));
    }

    /**
     * Test basic User class properties
     *
     * @return void
     */
    public function testUserClassBasicProperties()
    {
        $reflection = new \ReflectionClass('App\User');

        // Test that the class exists
        $this->assertTrue($reflection->isInstantiable());

        // Test that it has the expected properties
        $this->assertTrue($reflection->hasProperty('fillable'));
        $this->assertTrue($reflection->hasProperty('hidden'));
    }

    /**
     * Test that the User model has the correct fillable attributes.
     *
     * @return void
     */
    public function testFillableAttributes()
    {
        $user = new User();

        $expectedFillable = [
            'name',
            'email',
            'password'
        ];

        $this->assertEquals($expectedFillable, $user->getFillable());
    }

    /**
     * Test User model has expected fillable attributes
     *
     * @return void
     */
    public function testUserModelHasFillableAttributes()
    {
        // Create a User instance without Laravel bootstrap
        $user = new \App\User();

        $expected = ['name', 'email', 'password'];
        $this->assertEquals($expected, $user->getFillable());
    }

    /**
     * Test that the User model has the correct hidden attributes.
     *
     * @return void
     */
    public function testHiddenAttributes()
    {
        $user = new User();

        $expectedHidden = [
            'password',
            'remember_token'
        ];

        $this->assertEquals($expectedHidden, $user->getHidden());
    }

    /**
     * Test User model has expected hidden attributes
     *
     * @return void
     */
    public function testUserModelHasHiddenAttributes()
    {
        // Create a User instance without Laravel bootstrap
        $user = new \App\User();

        $expected = ['password', 'remember_token'];
        $this->assertEquals($expected, $user->getHidden());
    }

    /**
     * Test that the User model uses the Notifiable trait.
     *
     * @return void
     */
    public function testNotifiableTrait()
    {
        $user = new User();

        $this->assertContains(Notifiable::class, class_uses($user));
    }

    /**
     * Test User model uses Notifiable trait
     *
     * @return void
     */
    public function testUserModelUsesNotifiableTrait()
    {
        $user = new \App\User();

        $this->assertTrue(method_exists($user, 'notify'));
        $this->assertTrue(method_exists($user, 'notifyNow'));
    }

    /**
     * Test that a User model can be created using the factory.
     *
     * @return void
     */
    public function testUserCanBeCreatedViaFactory()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotNull($user->name);
        $this->assertNotNull($user->email);
        $this->assertNotNull($user->password);
        $this->assertDatabaseHas('users', [
            'email' => $user->email
        ]);
    }

    /**
     * Test that factory creates User with all required attributes.
     *
     * @return void
     */
    public function testFactoryCreatesUserWithRequiredAttributes()
    {
        $user = factory(User::class)->make();

        $this->assertTrue(isset($user->name));
        $this->assertTrue(isset($user->email));
        $this->assertTrue(isset($user->password));
        $this->assertTrue(isset($user->remember_token));
    }
}