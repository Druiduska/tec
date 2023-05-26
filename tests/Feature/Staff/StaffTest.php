<?php

namespace Tests\Feature\Staff;

use App\Models\Auth\Access;
use App\Models\Auth\User;
use App\Models\Staff\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StaffTest extends TestCase
{
    use DatabaseTransactions,
        WithFaker;

    /**
     * Testing the display of the staff list.
     *
     * @return void
     */
    public function test_index()
    {
        $user = User::factory()->count(1)->create();
        $staff = Staff::factory(['user_id' => $user->first()->id])->count(1)->create();

        $access = Access::factory(['user_id' => $user->first()->id])
            ->has(User::factory(), 'user')
            ->has(Staff::factory(), 'staff')
            ->count(1)
            ->create();

        $response = $this->get('/api/staff');

        $response->assertStatus(200);
    }

    /**
     * Testing the load staff from the csv file
     *
     * @return void
     */
    public function test_loadCSV()
    {
        $auth = $this->json('POST',
            '/api/auth/login',
            [
                "name" => "ioan",
                "password" => "123"],
        )->json();

        $dataList [] = 'family;name;patronymic;email;login;pass';
        for ($i = 0; $i < 10; $i++) {
            $dataList [] = implode(';', [
                $this->faker->lastName(), // family
                $this->faker->firstName(), // name
                $this->faker->firstName(), // patronymic
                $this->faker->unique()->safeEmail, // email
                $this->faker->unique()->word(), // login
                $this->faker->unique()->word(), // password
            ]);
        }
        $csv = implode("\n", $dataList);

        Storage::fake('test.csv');
        $file = UploadedFile::fake()->createWithContent('test.csv', $csv);
        $response = $this->withHeaders([
            'Authorization' => 'bearer ' . $auth['access_token'],
        ])
            ->post('/api/staff/load-csv', [
                'file' => $file,
            ]);
        $response->assertStatus(200);
    }
}
