<?php

namespace Tests\Feature\Http\Controllers;

use App\Events\ReportGenerated;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ReportController
 */
final class ReportControllerTest extends TestCase
{
    #[Test]
    public function __invoke_displays_view(): void
    {
        Event::fake();

        $response = $this->get(route('reports.__invoke'));

        $response->assertOk();
        $response->assertViewIs('report');

        Event::assertDispatched(ReportGenerated::class);
    }
}
