<?php

namespace Tests\Feature;

use App\Event;
use App\TicketType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function user_can_view_event()
    {
        $event = factory(Event::class)->create([
            'title' => 'MBLGTACC 2018',
            'slug' => 'mblgtacc-2018',
            'subtitle' => 'All Roads Lead to Intersectionality',
            'start' => '2018-02-16 19:00:00',
            'end' => '2018-02-18 19:30:00',
            'timezone' => 'America/Chicago',
            'place' => 'University of Nebraska',
            'location' => 'Omaha, Nebraska',
            'description' => 'Bacon ipsum dolor amet rump andouille landjaeger ham shoulder.',
            'links' => [
                'facebook' => 'https://facebook.com/mblgtacc',
                'twitter' => 'https://twitter.com/mblgtacc',
                'instagram' => 'https://instagram.com/mblgtacc',
                'external-link' => 'https://mblgtacc.org',
            ],
        ]);
        $regular = factory(TicketType::class)->make([
            'cost' => 6500,
            'name' => 'Regular Ticket',
        ]);
        $late = factory(TicketType::class)->make([
            'cost' => 6500,
            'name' => 'Late Ticket',
            'description' => 'You are not guaranteed to receive a conference
T-shirt, program, or other memorabilia.',
        ]);

        $event->ticket_types()->save($regular);
        $event->ticket_types()->save($late);

        $response = $this->withoutExceptionHandling()->get("/events/{$event->slug}");

        $response->assertStatus(200);
        $response->assertSee('MBLGTACC 2018');
        $response->assertSee('All Roads Lead to Intersectionality');
        $response->assertSee('Fri, Feb 16');
        $response->assertSee('Sun, Feb 18');
        $response->assertSee('University of Nebraska');
        $response->assertSee('Omaha, Nebraska');
        $response->assertSee('Friday February 16, 2018 1:00 PM to Sunday February 18, 2018 1:30 PM CST');
        $response->assertSee('https://facebook.com/mblgtacc');
        $response->assertSee('https://twitter.com/mblgtacc');
        $response->assertSee('https://instagram.com/mblgtacc');
        $response->assertSee('https://mblgtacc.org');
    }
}
