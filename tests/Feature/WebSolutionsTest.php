<?php

namespace Tests\Feature;

use Tests\TestCase;

class WebSolutionsTest extends TestCase
{
    public function test_main_web_solutions_page_lists_projects_in_a_compact_grid(): void
    {
        $response = $this->get(route('web-solutions'));

        $response->assertOk();
        $response->assertSee('Web Solutions');
        $response->assertSee('GymSaaS');
        $response->assertSee('GrowNext');
        $response->assertSee('Chatter');
        $response->assertSee('UniMeal');
        $response->assertSee('Puzzle Block');
        $response->assertSee('Temp Mail');
        $response->assertSee('RajeLiker');
        $response->assertSee('Starlight Travels');
        $response->assertSee('ReelSwipe');
        $response->assertSee('NetFares');
        $response->assertSee('Crime India Live');
        $response->assertSee('Fourine');
        $response->assertSee('class="ws-work-grid"', false);
        $response->assertSee('https://play.google.com/store/apps/details?id=com.tempmail.autolikerlive', false);
        $response->assertSee('https://play.google.com/store/apps/details?id=com.rajeliker', false);
        $response->assertSee('https://github.com/Riyaz7364/chatter', false);
    }

    public function test_web_solutions_link_appears_in_global_navigation_and_footer(): void
    {
        $response = $this->get(route('about'));

        $response->assertOk();
        $response->assertSee('href="'.route('web-solutions').'"', false);
        $response->assertSee('Web Solutions');
    }

    public function test_web_solutions_lead_is_saved_to_the_existing_admin_table(): void
    {
        $email = 'web-solutions-'.bin2hex(random_bytes(4)).'@example.com';

        $response = $this->postJson(route('web-solutions.leads.store'), [
            'name' => 'Web Solutions Client',
            'email' => $email,
            'phone' => '+91 90000 00000',
            'company' => 'Example Co',
            'project_type' => 'web-app',
            'budget' => '1500-5000',
            'message' => 'Please build a Laravel SaaS dashboard with payments.',
        ]);

        $response->assertCreated();
        $response->assertJsonStructure(['message', 'id']);

        $this->assertDatabaseHas('demo_leads', [
            'email' => $email,
            'name' => 'Web Solutions Client',
            'source' => 'web-solutions',
            'status' => 'new',
        ]);
    }

    public function test_honeypot_submission_is_silently_ignored(): void
    {
        $email = 'web-solutions-spam-'.bin2hex(random_bytes(4)).'@example.com';

        $response = $this->postJson(route('web-solutions.leads.store'), [
            'name' => 'Spam Bot',
            'email' => $email,
            'message' => 'Buy cheap backlinks now.',
            'website' => 'https://spam.example.com',
        ]);

        $response->assertOk();

        $this->assertDatabaseMissing('demo_leads', [
            'email' => $email,
        ]);
    }

    public function test_web_solutions_lead_requires_valid_contact_details(): void
    {
        $response = $this->postJson(route('web-solutions.leads.store'), [
            'name' => '',
            'email' => 'not-an-email',
            'message' => '',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name', 'email', 'message']);
    }
}
