<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function welcome_page_loads(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
