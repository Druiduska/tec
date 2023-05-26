<?php

namespace Tests\Feature\Staff;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Auth\User;
use App\Models\Staff\Staff;
use App\Models\Auth\Access;

class WorkingTimeTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Testing the display of the working time list
     *
     * @return void
     */
    public function test_index()
    {
        $user = User::factory()->count(1)->create();
        $staff = Staff::factory(['user_id' => $user->first()->id])->count(1)->create();

        $access=Access::factory(['user_id' => $user->first()->id])
            ->has(User::factory(), 'user')
            ->has(Staff::factory(), 'staff')
            ->count(1)
            ->create();

        $lastAccess = $access->max('access_at');
        $lastUserId = $access->where('access_at', $lastAccess)->first()->user_id;
        $params = '?user_id=' . $lastUserId
        . '&date=' . $lastAccess->format('Y-m-d')
        . '&count=' . rand(1,5);

        $response = $this->get('/api/staff/reports/working-time' . $params);

        $response->assertStatus(200);
    }
}
