<?php

namespace Tests\Feature;

use App\Http\Controllers\HomeController;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(HomeController::class)]
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

    #[Test]
    public function it_rejects_non_get_requests(): void
    {
        /** @Arrange */

        /** @Act */
        $response = $this->post('/');

        /** @Assert */
        $response->assertStatus(405);
    }
}
