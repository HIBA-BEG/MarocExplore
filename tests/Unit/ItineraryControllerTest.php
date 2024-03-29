<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItineraryControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_store_itinerary()
    {
        $user = \App\Models\User::factory()->create();

        $data = [
            'title' => 'Sample Itinerary',
            'category' => 'Sample Category',
            'image' => 'sample_image.jpg',
            'departure' => '2024-04-01',
            'arrival' => '2024-04-05',
            'duration' => '4 days',
            'destinations' => [
                [
                    'name' => 'Destination 1',
                    'housing' => 'Hotel A',
                    'list' => 'Activity 1, Activity 2',
                ],
                [
                    'name' => 'Destination 2',
                    'housing' => 'Hotel B',
                    'list' => 'Activity 3, Activity 4',
                ],
            ],
        ];

        $response = $this->actingAs($user)->postJson('/api/store', $data);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Route with its destinations successfully created',
                'itinerary' => [
                    'title' => $data['title'],
                    'category' => $data['category'],
                    'image' => $data['image'],
                    'departure' => $data['departure'],
                    'arrival' => $data['arrival'],
                    'duration' => $data['duration'],
                    'user_id' => $user->id,
                    'destinations' => [
                        [
                            'name' => 'Destination 1',
                            'housing' => 'Hotel A',
                            'list' => 'Activity 1, Activity 2',
                        ],
                        [
                            'name' => 'Destination 2',
                            'housing' => 'Hotel B',
                            'list' => 'Activity 3, Activity 4',
                        ],
                    ],
                ],
            ]);
    }


}
