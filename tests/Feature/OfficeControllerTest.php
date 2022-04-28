<?php

namespace Tests\Feature;

use App\Models\Office;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OfficeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_lists_all_offices_in_paginated_way()
    {
        Office::factory()->count(3)->create();

        $response = $this->get('/api/offices');

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
        $this->assertNotNull($response->json('data')[0]['id']);
        $this->assertNotNull($response->json('meta'));
        $this->assertNotNull($response->json('links'));
    }

    public function test_only_lists_offices_that_are_not_hidden_and_approved()
    {
        Office::factory(3)->create();

        Office::factory()->create(['hidden' => true]);
        Office::factory()->create(['approval_status' => Office::APPROVAL_PENDING]);

        $response = $this->get('/api/offices');

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
    }
}
