<?php

namespace AuthenticateTest;

use Authenticate\Facades\AuthFacade;
use Authenticate\Facades\ResponderFacade;
use Authenticate\Models\User;
use Authenticate\Repositories\User\UserProviderFacade;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{

    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function a_new_user_registered_succssfully()
    {
        User::Unguard();

        $inputs = [
            "full-name" => "Addam Johnson",
            'username' => "AddmJnson",
            'password' => "12345678",
        ];

        $user = User::factory()->make($inputs);

        UserProviderFacade::shouldReceive('create')->with($inputs)
            ->once()->andReturn($user);

        ResponderFacade::shouldReceive('userRegistered')->with($user)->once()
            ->andReturn(response()->json($user));

        $this->postJson(route('v1.users.register.new-user'), $inputs);
    }

    /** @test */

    public function when_user_input_for_username_is_in_valid()
    {

        $inputs = [
            "full-name" => "Addam Johnson",
            'username' => "sala*21233",
            'password' => "12345678",
        ];

        UserProviderFacade::shouldReceive('create')->never();
        ResponderFacade::shouldReceive('userRegistered')->never();

        $response = $this->postJson(route('v1.users.register.new-user'), $inputs);

        $response->assertStatus(422)->assertJsonValidationErrors('username')
            ->assertJsonValidationErrorFor('username');
    }

    /** @test */

    public function when_user_input_for_password_is_in_valid()
    {

        $inputs = [
            "full-name" => "Addam Johnson",
            'username' => "AddmJnson",
            'password' => "",
        ];

        UserProviderFacade::shouldReceive('create')->never();
        ResponderFacade::shouldReceive('userRegistered')->never();

        $response = $this->postJson(route('v1.users.register.new-user'), $inputs);

        $response->assertStatus(422)->assertJsonValidationErrors('password');
    }

    /** @test */
    public function a_user_login_successfully()
    {

        User::Unguard();

        $inputs = [
            'username' => "AddmJnson",
            'password' => "12345678",
        ];

        $user = User::factory()->create($inputs);

        $token = Str::random(100);

        AuthFacade::shouldReceive('attempt')->with($inputs)->once()
            ->andReturn($token);

        
        ResponderFacade::shouldReceive("inputsIsInvalid")->never();


        ResponderFacade::shouldReceive("loggedIn")->with($token)
            ->once();

        $res = $this->postJson(route('v1.users.login.success'), $inputs);

    }



    /** @test */
    public function when_a_user_not_exist()
    {

        User::Unguard();

        $inputs = [
            'username' => "AddmJnson",
            'password' => "123456",
        ];

        $user = User::factory()->create($inputs);

        AuthFacade::shouldReceive('attempt')->with($inputs)->once()
            ->andReturnFalse();

        ResponderFacade::shouldReceive("inputsIsInvalid")->once();

        ResponderFacade::shouldReceive("loggedIn")->never();

        $this->postJson(route('v1.users.login.success'), $inputs);
    }


    /** @test */
    public function when_username_invalid_in_login()
    {

        User::Unguard();

        $inputs = [
            'username' => "",
            'password' => "12345678",
        ];

        AuthFacade::shouldReceive('attempt')->never();

        ResponderFacade::shouldReceive("inputsIsInvalid")->never();

        ResponderFacade::shouldReceive("loggedIn")->never();

        $response = $this->postJson(route('v1.users.login.success'), $inputs);

        $response->assertStatus(422)->assertJsonValidationErrors('username')
            ->assertJsonValidationErrorFor('username');
    }
}
