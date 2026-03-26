<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContainerOrganizerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_possible_case()
    {
        $service = new \App\Services\ContainerOrganizer();

        $matrix = [
            [1,3,1],
            [2,1,2],
            [0,2,1]
        ];

        $result = $service->canOrganize($matrix);

        $this->assertTrue($result['possible']);
    }
    
}
