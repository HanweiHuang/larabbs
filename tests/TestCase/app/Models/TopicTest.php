<?php
namespace tests\TestCase\App\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TopicTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array seeders need loads
     */
    protected $seeder_include = [
        'UsersTableSeeder',
        'CategoriesTableSeeder',
    ];

    /**
     * setup function
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * test topic audit
     */
    public function testTopicAudit()
    {
        $topic = factory('App\Models\Topic')->create();
        $expect = DB::table('activities')->where([
            ['subject_id', $topic->id],
            ['subject_type', 'App\Models\Topic'],
        ])->first();

        $this->assertTrue(!empty($expect));
    }

}