<?php

namespace Tests\Feature;

use App\Models\DemoLead;
use Tests\TestCase;

class WebsiteLeadsAdminTest extends TestCase
{
    private function lead(array $overrides = []): DemoLead
    {
        return DemoLead::create(array_merge([
            'name' => 'Test Client',
            'email' => 'client@example.com',
            'phone' => '+1 555 0100',
            'company' => 'Test Co',
            'project_type' => 'web-development',
            'budget' => '5k-10k',
            'message' => 'Please build a new website with lead capture.',
            'source' => 'services_page',
            'status' => 'new',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'PHPUnit',
        ], $overrides));
    }

    private function adminUrl(string $name, array|DemoLead $parameters = []): string
    {
        $url = route($name, $parameters);

        return $url.(str_contains($url, '?') ? '&' : '?').'admin_key='.urlencode((string) config('admin.secret_key'));
    }

    public function test_admin_can_view_website_leads_from_the_existing_panel(): void
    {
        $lead = $this->lead();

        $response = $this->get($this->adminUrl('admin.website-leads.index'));

        $response->assertOk();
        $response->assertSee('Website Leads');
        $response->assertSee($lead->name);
        $response->assertSee($lead->email);
        $response->assertSee('Services Page');
    }

    public function test_admin_can_filter_and_search_website_leads(): void
    {
        $this->lead(['name' => 'Alpha Client', 'email' => 'alpha@example.com']);
        $this->lead(['name' => 'Beta Client', 'email' => 'beta@example.com', 'status' => 'contacted']);

        $response = $this->get($this->adminUrl('admin.website-leads.index', ['status' => 'contacted', 'q' => 'Beta']));

        $response->assertOk();
        $response->assertSee('Beta Client');
        $response->assertDontSee('Alpha Client');
    }

    public function test_admin_can_update_a_lead_status(): void
    {
        $lead = $this->lead();

        $response = $this->patch(
            $this->adminUrl('admin.website-leads.status', $lead),
            ['status' => 'contacted']
        );

        $response->assertRedirect();
        $this->assertDatabaseHas('demo_leads', [
            'id' => $lead->id,
            'status' => 'contacted',
        ]);
    }

    public function test_admin_can_delete_a_lead(): void
    {
        $lead = $this->lead();

        $response = $this->delete($this->adminUrl('admin.website-leads.destroy', $lead));

        $response->assertRedirect();
        $this->assertDatabaseMissing('demo_leads', ['id' => $lead->id]);
    }
}
