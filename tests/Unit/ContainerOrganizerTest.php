<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ContainerOrganizer;

class ContainerOrganizerTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ContainerOrganizer();
    }

    /** Valid Possible Case */
    public function test_possible_case()
    {
        $matrix = [
            [1,1],
            [1,1]
        ];

        $result = $this->service->canOrganize($matrix);

        $this->assertTrue($result['possible']);
    }

    /** Not Possible Case */
    public function test_not_possible_case()
    {
        $matrix = [
            [1,3,1],
            [2,1,2],
            [0,2,1]
        ];

        $result = $this->service->canOrganize($matrix);

        $this->assertFalse($result['possible']);
    }

    /** Empty Matrix */
    public function test_empty_matrix()
    {
        $matrix = [];

        $result = $this->service->canOrganize($matrix);

        $this->assertFalse($result['possible'] ?? false);
    }

    /** Invalid Matrix (non-square) */
    public function test_invalid_matrix_structure()
    {
        $matrix = [
            [1,2,3],
            [4,5] // invalid row
        ];

        $result = $this->service->canOrganize($matrix);

        $this->assertFalse($result['possible'] ?? false);
    }

    /** Negative Values */
    public function test_negative_values()
    {
        $matrix = [
            [1, -1],
            [2, 3]
        ];

        $result = $this->service->canOrganize($matrix);

        $this->assertFalse($result['possible'] ?? false);
    }

    /** Large Matrix Test */
    public function test_large_matrix()
    {
        $matrix = [];

        // create 10x10 matrix
        for ($i = 0; $i < 10; $i++) {
            $row = array_fill(0, 10, 1);
            $matrix[] = $row;
        }

        $result = $this->service->canOrganize($matrix);

        $this->assertTrue($result['possible']);
    }
}