<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testApplicationLoads(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }
}
