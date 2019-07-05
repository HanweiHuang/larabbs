<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use Auth;
use DB;
use Tests\TestCase;


/**
 * Class UserControllerTest
 *
 * @package Tests\Feature
 */
class UserControllerTest extends TestCase
{

    public function setUp()
    {
        parent::setup();
        //turncate table before test
        //ignore foreign key when truncate table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    //use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     * @test
     */
    public function test_show_one_user()
    {
        $this->createOneUserForTest(1);

        $user = User::find(1);
        $user->name = 'test_name';
        $user->save();

        $response = $this->get('/users/1');
        $response->assertStatus(200);
        $response->assertSeeText('test_name');
    }


    /**
     * @test
     */
    public function test_show_one_user_with_specific_id()
    {
        $this->createOneUserForTest(1);
        $response = $this->get('/users/<?php?>sds');
        $response->assertStatus(404);

    }

    /**
     * @test
     */
    public function test_show_one_user_with_para(){
        //create one user
        $this->createOneUserForTest(1);
        $response = $this->get('/users/1?id=1');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_edit_user(){
        $user = factory('App\Models\User')->create();
        $this->actingAs($user);
        $response = $this->get("/users/{$user->id}/edit");
        $response->assertStatus(200);
        $response->assertSee($user->email);
        $response->assertSee($user->name);
        $response->assertSee($user->avatar);
        $response->assertSee($user->introduction);
    }

    /**
     * @test
     */
    public function test_update_one_user(){
        $this->createOneUserForTest(1);
        $user = User::find(1);
        $data=[
            'name' => 'Harvey01'
        ];

        $this->be($user);
        $this->patch(route('users.update',1),$data)
            ->assertStatus(302);
    }


    /**
     * @param $count
     * how many users need
     */
    public function createOneUserForTest($count){
        $users = factory(User::class)
            ->times($count)
            ->make();
        /**
         * password has been encode in factory,
        as a result, it will be ignored if it does not set it visible
         * */
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();
        User::insert($user_array);
    }
}
