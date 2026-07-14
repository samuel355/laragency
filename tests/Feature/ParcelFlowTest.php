<?php

namespace Tests\Feature;

use App\Models\Parcel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParcelFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_it_renders_the_parcel_marketplace(): void
    {
        $response = $this->get('/parcels');

        $response->assertOk();
        $response->assertSee('app-blue.css');
        $response->assertSee('Buy verified land parcels');
        $response->assertSee('Demarcated Parcel Area');
        $response->assertDontSee('Adenta serviced residential plot');
    }

    public function test_it_returns_parcel_geojson(): void
    {
        $response = $this->getJson('/api/parcels');

        $response->assertOk();
        $response->assertJsonPath('type', 'FeatureCollection');
        $response->assertJsonCount(Parcel::whereNotNull('attributes->project_area')->count(), 'features');
        $response->assertJsonPath('features.0.type', 'Feature');
        $response->assertJsonStructure([
            'features' => [
                '*' => [
                    'geometry',
                    'properties' => [
                        'plot_number',
                        'status',
                        'status_color',
                        'detail_url',
                    ],
                ],
            ],
        ]);
    }

    public function test_it_renders_parcel_admin(): void
    {
        $this->actingAs(User::where('is_admin', true)->firstOrFail());

        $response = $this->get('/admin/parcels');

        $response->assertOk();
        $response->assertSee('Parcel Admin');
    }

    public function test_admin_pages_require_login(): void
    {
        $this->get('/admin/parcels')
            ->assertRedirect('/login');
    }

    public function test_it_renders_corporate_pages_and_listings(): void
    {
        $this->get('/')->assertOk()->assertSee('Professional, reliable, and results-driven real estate solutions');
        $this->get('/about')->assertOk()->assertSee('Company Profile');
        $this->get('/services')->assertOk()->assertSee('Property Acquisition')->assertSee('Compensation Consultancy');
        $this->get('/faq')->assertOk()->assertSee('What type of clients does SOMA PROPERTIES work with?');
        $this->get('/team')->assertOk()->assertSee('Ama Mensah');
        $this->get('/listings')->assertOk()->assertSee('Property listings is coming soon');

        $this->actingAs(User::where('is_admin', true)->firstOrFail());

        $this->get('/admin/listings')->assertOk()->assertSee('Property Listings');
        $this->get('/admin/services')->assertOk()->assertSee('Agency Services');
        $this->get('/admin/team')->assertOk()->assertSee('Team Members');
        $this->get('/admin/faqs')->assertOk()->assertSee('FAQ');
        $this->get('/admin/content')->assertOk()->assertSee('Editable Content');
    }
}
