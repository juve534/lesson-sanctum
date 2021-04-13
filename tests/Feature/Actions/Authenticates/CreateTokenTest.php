<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Authenticates;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTokenTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    const URI = "api/v1/tokens/create";

    /**
     * @test
     * @return void
     */
    public function トークン発行成功()
    {
        $user = User::factory()->create();
        $response = $this->postJson(self::URI, [
            'id' => $user->id,
        ],['accept: application/json', "Content-Type: application/json"]);

        $response->assertHeader('content-type', 'application/json')
            ->assertStatus(200)->assertJsonStructure(['token']);
    }
}
