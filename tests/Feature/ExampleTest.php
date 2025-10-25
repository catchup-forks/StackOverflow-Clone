<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    #[Test]
    public function it_redirects_home_to_questions(): void
    {
        /** @Arrange */

        /** @Act */
        $response = $this->get('/');

        /** @Assert */
        $response->assertRedirect(route('questions.index'));
    }
}
