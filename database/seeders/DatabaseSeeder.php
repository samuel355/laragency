<?php

namespace Database\Seeders;

use App\Models\AgencyService;
use App\Models\BlogPost;
use App\Models\Community;
use App\Models\CompanyStat;
use App\Models\Faq;
use App\Models\Inquiry;
use App\Models\MortgageApplication;
use App\Models\Order;
use App\Models\Parcel;
use App\Models\PartnerBank;
use App\Models\PropertyListing;
use App\Models\SiteContent;
use App\Models\SiteVisit;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use App\Support\SampleParcelImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password'), 'is_admin' => false]
        );

        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@somaproperties.test')],
            [
                'name' => env('ADMIN_NAME', 'SOMA Admin'),
                'password' => bcrypt(env('ADMIN_PASSWORD', 'password')),
                'is_admin' => true,
            ]
        );

        $contents = [
            'home_hero' => [
                'title' => 'Professional, reliable, and results-driven real estate solutions',
                'subtitle' => 'SOMA PROPERTIES provides expert guidance at every stage of the property lifecycle for individuals, businesses, investors, developers, landlords, and tenants.',
                'body' => 'We help clients make informed decisions, protect their investments, and maximize the value of their properties through tailored advice and exceptional service.',
                'image_path' => '/light/images/bg/12.jpg',
                'metadata' => ['cta_primary' => 'Explore listings', 'cta_secondary' => 'Talk to an advisor'],
            ],
            'about' => [
                'title' => 'Company Profile',
                'subtitle' => 'Professional, reliable, and results-driven real estate solutions.',
                'body' => 'At SOMA PROPERTIES we are committed to delivering professional, reliable, and results-driven real estate solutions. Whether you are an individual, business, investor, developer, landlord, or tenant, we provide expert guidance at every stage of the property lifecycle. Our goal is to help clients make informed decisions, protect their investments, and maximize the value of their properties through tailored advice and exceptional service.',
                'image_path' => '/light/images/bg/10.jpg',
                'metadata' => ['founded' => '2018', 'transactions' => '420+', 'verified_assets' => '95'],
            ],
            'vision' => [
                'title' => 'Vision Statement',
                'subtitle' => 'To be the leading and most trusted property services company in Ghana and across Africa.',
                'body' => 'To be the leading and most trusted property services company in Ghana and across Africa, delivering innovative, sustainable, and value-driven real estate solutions that transform communities and enhance lives.',
                'image_path' => null,
                'metadata' => [],
            ],
            'mission' => [
                'title' => 'Mission Statement',
                'subtitle' => 'Professional, reliable, and client-focused property services.',
                'body' => 'To provide professional, reliable, and client-focused property services through expert advice, innovative solutions, and ethical business practices. We are committed to helping our clients acquire, develop, manage, market, and maximize the value of their real estate investments while building lasting relationships founded on integrity, excellence, and trust.',
                'image_path' => null,
                'metadata' => [],
            ],
            'contact' => [
                'title' => 'Speak with a property advisor',
                'subtitle' => 'Send a request and our team will respond with availability, documents, inspection options, and next steps.',
                'body' => 'Office: Adum-Nsuase, Opposite Railways Police Station (Otumfoɔ AkyeameHene Palace). Hours: Monday to Friday, 8:30 AM to 5:30 PM.',
                'image_path' => '/light/images/bg/8.jpg',
                'metadata' => ['email' => 'somaproperties@gmail.com', 'phone' => '+233 54 423 2686'],
            ],
            'why_choose_us' => [
                'title' => 'Why clients choose SOMA PROPERTIES',
                'subtitle' => 'We combine professional advice, market evidence, documentation discipline, and client-focused service across residential, commercial, and development property.',
                'body' => null,
                'image_path' => null,
                'metadata' => [
                    'items' => [
                        ['icon' => 'fa-light fa-file-shield', 'title' => 'Professional diligence', 'text' => 'We review property information, transaction requirements, and documentation risks before clients commit.'],
                        ['icon' => 'fa-light fa-chart-line', 'title' => 'Market-led advice', 'text' => 'Our recommendations are shaped by current demand, rental values, development potential, and investment objectives.'],
                        ['icon' => 'fa-light fa-handshake', 'title' => 'Client-focused negotiation', 'text' => 'We protect client interests during sales, leasing, renewals, rent reviews, and landlord or tenant discussions.'],
                        ['icon' => 'fa-light fa-user-tie', 'title' => 'End-to-end guidance', 'text' => 'A dedicated advisor coordinates the next step, from site search and planning advice to marketing, completion, and handover.'],
                    ],
                ],
            ],
        ];

        foreach ($contents as $key => $content) {
            SiteContent::updateOrCreate(['key' => $key], $content);
        }

        $services = [
            [
                'title' => 'Property Acquisition', 'slug' => 'property-acquisition',
                'summary' => 'Expert advice throughout the property purchasing process, from selection and negotiations to legal documentation.',
                'body' => 'We help clients identify and acquire suitable properties by providing expert advice throughout the purchasing process. From property selection and negotiations to legal documentation, we ensure every transaction is handled professionally and efficiently.',
                'process' => [],
                'benefits' => [],
                'icon' => 'fa-light fa-house-circle-check', 'sort_order' => 1,
            ],
            [
                'title' => 'Property Development', 'slug' => 'property-development',
                'summary' => 'Developer support from concept to completion, including site identification, approvals, funding, pre-letting, and sale.',
                'body' => 'Our team supports developers from concept to completion. We assist with site identification, land acquisition, planning approvals, project coordination, funding arrangements, pre-letting, and the sale of completed developments.',
                'process' => [],
                'benefits' => [],
                'icon' => 'fa-light fa-city', 'sort_order' => 2,
            ],
            [
                'title' => 'Planning and Development Consultancy', 'slug' => 'planning-development-consultancy',
                'summary' => 'Planning application guidance through policy research, planning authority engagement, and approval strategy.',
                'body' => 'Navigating planning regulations can be complex. We provide expert guidance on planning applications by researching local planning policies, engaging with planning authorities, and advising clients on the most effective approach to secure approvals.',
                'process' => [],
                'benefits' => [],
                'icon' => 'fa-light fa-compass-drafting', 'sort_order' => 3,
            ],
            [
                'title' => 'Property Valuation', 'slug' => 'property-valuation',
                'summary' => 'Accurate and reliable property valuations for reporting, finance, taxation, insurance, investment, rent, and sales.',
                'body' => 'We provide accurate and reliable property valuations for a variety of purposes, including financial reporting, mortgage financing, taxation, insurance, investment analysis, rental assessments, and property sales. Our valuation services help clients understand the true value of their assets and make informed decisions.',
                'process' => [],
                'benefits' => [],
                'icon' => 'fa-light fa-scale-balanced', 'sort_order' => 4,
            ],
            [
                'title' => 'Marketing and Estate Agency', 'slug' => 'marketing-estate-agency',
                'summary' => 'Marketing strategies, professional materials, viewings, buyer and tenant matching, sales, and leasing management.',
                'body' => 'Our marketing team develops effective strategies to showcase properties to the right audience. We prepare professional marketing materials, coordinate property viewings, connect buyers and tenants with suitable properties, and manage sales and leasing transactions from start to finish.',
                'process' => [],
                'benefits' => [],
                'icon' => 'fa-light fa-sign-hanging', 'sort_order' => 5,
            ],
            [
                'title' => 'Project Management', 'slug' => 'project-management',
                'summary' => 'Development and refurbishment project oversight covering financial control, consultants, contracts, and supervision.',
                'body' => 'We oversee property development and refurbishment projects to ensure they are delivered on time, within budget, and to the highest standards. Our services include financial control, consultant coordination, contract administration, and project supervision.',
                'process' => [],
                'benefits' => [],
                'icon' => 'fa-light fa-clipboard-list-check', 'sort_order' => 6,
            ],
            [
                'title' => 'Refurbishment Consultancy', 'slug' => 'refurbishment-consultancy',
                'summary' => 'Refurbishment advice that improves functionality, appeal, long-term value, and occupant suitability.',
                'body' => 'We advise clients on refurbishment projects that improve the functionality, appeal, and long-term value of their properties while ensuring they meet the needs of current and future occupants.',
                'process' => [],
                'benefits' => [],
                'icon' => 'fa-light fa-screwdriver-wrench', 'sort_order' => 7,
            ],
            [
                'title' => 'Landlord and Tenant Advisory', 'slug' => 'landlord-tenant-advisory',
                'summary' => 'Practical advice for landlords and tenants on leases, rent reviews, renewals, dilapidations, and tenancy matters.',
                'body' => 'We provide practical advice to both landlords and tenants on lease agreements, rent reviews, lease renewals, dilapidations, and other tenancy matters, helping both parties achieve fair and mutually beneficial outcomes.',
                'process' => [],
                'benefits' => [],
                'icon' => 'fa-light fa-handshake', 'sort_order' => 8,
            ],
            [
                'title' => 'Leasing and Lease Renewals', 'slug' => 'leasing-lease-renewals',
                'summary' => 'New lease and lease renewal negotiation support that protects client interests and complies with legal requirements.',
                'body' => 'Whether negotiating a new lease or renewing an existing one, we ensure that lease terms and conditions protect our clients\' interests while complying with applicable legal requirements.',
                'process' => [],
                'benefits' => [],
                'icon' => 'fa-light fa-file-contract', 'sort_order' => 9,
            ],
            [
                'title' => 'Rent Reviews', 'slug' => 'rent-reviews',
                'summary' => 'Landlord and tenant representation during rent review negotiations, fair rental value assessments, and disputes.',
                'body' => 'We represent both landlords and tenants during rent review negotiations, using our market knowledge and professional expertise to achieve fair rental values and resolve disputes where necessary.',
                'process' => [],
                'benefits' => [],
                'icon' => 'fa-light fa-chart-line', 'sort_order' => 10,
            ],
            [
                'title' => 'Site Identification', 'slug' => 'site-identification',
                'summary' => 'Development site identification based on market demand, planning, infrastructure, accessibility, workforce, and growth potential.',
                'body' => 'Selecting the right location is critical to the success of any development. We help clients identify suitable development sites by assessing market demand, planning requirements, infrastructure, accessibility, workforce availability, and future growth potential.',
                'process' => [],
                'benefits' => [],
                'icon' => 'fa-light fa-map-location-dot', 'sort_order' => 11,
            ],
            [
                'title' => 'Market Research', 'slug' => 'market-research',
                'summary' => 'Research on market trends, property availability, rental values, investment opportunities, and development potential.',
                'body' => 'Our research services provide valuable insights into market trends, property availability, rental values, investment opportunities, and development potential, enabling clients to make well-informed investment decisions.',
                'process' => [],
                'benefits' => [],
                'icon' => 'fa-light fa-magnifying-glass-chart', 'sort_order' => 12,
            ],
            [
                'title' => 'Property Disposal', 'slug' => 'property-disposal',
                'summary' => 'Disposal strategy and sale support for surplus land and other property assets.',
                'body' => 'When a property is no longer required, we advise clients on the most effective disposal strategy to maximize returns. We also assist with the sale of surplus land and other property assets.',
                'process' => [],
                'benefits' => [],
                'icon' => 'fa-light fa-arrow-up-right-from-square', 'sort_order' => 13,
            ],
            [
                'title' => 'Compensation Consultancy', 'slug' => 'compensation-consultancy',
                'summary' => 'Support for compensation claims from compulsory acquisition, property loss, business interruption, disturbance, and goodwill.',
                'body' => 'We assist clients in pursuing compensation claims arising from compulsory land acquisition, property loss, business interruption, disturbance, goodwill, and other property-related matters.',
                'process' => [],
                'benefits' => [],
                'icon' => 'fa-light fa-scale-balanced', 'sort_order' => 14,
            ],
        ];

        foreach ($services as $service) {
            AgencyService::updateOrCreate(['slug' => $service['slug']], ['is_active' => true, ...$service]);
        }

        AgencyService::whereNotIn('slug', array_column($services, 'slug'))->update(['is_active' => false]);

        $faqs = [
            ['question' => 'What type of clients does SOMA PROPERTIES work with?', 'answer' => 'We work with individuals, companies, investors, developers, landlords, tenants, institutions, and property owners who need professional real estate advice or transaction support.', 'category' => 'Company', 'sort_order' => 1],
            ['question' => 'Can you help us acquire a property or development site?', 'answer' => 'Yes. We support property acquisition and site identification by preparing a client brief, researching suitable options, reviewing market and planning factors, coordinating inspections, and supporting negotiations.', 'category' => 'Acquisition', 'sort_order' => 2],
            ['question' => 'Do you provide valuation and market research?', 'answer' => 'Yes. We provide valuation support and market research for sales, purchases, finance, insurance, taxation, rent reviews, investment analysis, and development feasibility.', 'category' => 'Advisory', 'sort_order' => 3],
            ['question' => 'Can you support lease renewals and rent reviews?', 'answer' => 'Yes. We advise landlords and tenants on leasing, lease renewals, rent reviews, tenancy obligations, dilapidations, and practical negotiation strategy.', 'category' => 'Leasing', 'sort_order' => 4],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['question' => $faq['question']], ['is_active' => true, ...$faq]);
        }

        Faq::whereNotIn('question', array_column($faqs, 'question'))->update(['is_active' => false]);

        $team = [
            ['name' => 'Ama Mensah', 'slug' => 'ama-mensah', 'role' => 'Principal Property Advisor', 'bio' => 'Ama leads acquisition, disposal, and client advisory mandates, helping buyers, sellers, landlords, and investors structure practical property decisions.', 'email' => 'ama@somaproperties.test', 'phone' => '+233 24 000 0001', 'image_path' => '/light/images/agents/1.jpg', 'sort_order' => 1],
            ['name' => 'Kojo Addo', 'slug' => 'kojo-addo', 'role' => 'Development and Site Lead', 'bio' => 'Kojo coordinates site identification, development feasibility, planning follow-up, and land documentation support for clients and developers.', 'email' => 'kojo@somaproperties.test', 'phone' => '+233 24 000 0002', 'image_path' => '/light/images/agents/2.jpg', 'sort_order' => 2],
            ['name' => 'Nadia Boateng', 'slug' => 'nadia-boateng', 'role' => 'Leasing and Corporate Advisor', 'bio' => 'Nadia supports corporate occupiers, tenants, landlords, lease renewals, rent reviews, and relocation requirements.', 'email' => 'nadia@somaproperties.test', 'phone' => '+233 24 000 0003', 'image_path' => '/light/images/agents/3.jpg', 'sort_order' => 3],
            ['name' => 'Yaw Owusu', 'slug' => 'yaw-owusu', 'role' => 'Marketing and Agency Manager', 'bio' => 'Yaw manages property marketing, viewings, buyer and tenant qualification, and sale or leasing follow-through.', 'email' => 'yaw@somaproperties.test', 'phone' => '+233 24 000 0004', 'image_path' => '/light/images/agents/4.jpg', 'sort_order' => 4],
        ];

        foreach ($team as $member) {
            TeamMember::updateOrCreate(['slug' => $member['slug']], ['is_active' => true, 'social_links' => ['linkedin' => '#', 'twitter' => '#'], ...$member]);
        }

        $communities = [
            ['name' => 'East Legon', 'slug' => 'east-legon', 'city' => 'Accra', 'region' => 'Greater Accra', 'description' => 'An established residential district known for executive homes, international schools, and a dense retail and dining strip along the American House road.', 'image_path' => '/light/images/all/1.jpg', 'sort_order' => 1],
            ['name' => 'Airport Residential', 'slug' => 'airport-residential', 'city' => 'Accra', 'region' => 'Greater Accra', 'description' => 'A premium mixed-use enclave near Kotoka International Airport, popular with diplomats, corporate tenants, and short-stay travellers.', 'image_path' => '/light/images/all/2.jpg', 'sort_order' => 2],
            ['name' => 'Cantonments', 'slug' => 'cantonments', 'city' => 'Accra', 'region' => 'Greater Accra', 'description' => 'A quiet diplomatic enclave with tree-lined streets, embassies, and some of the city\'s most established family compounds.', 'image_path' => '/light/images/all/15.jpg', 'sort_order' => 3],
            ['name' => 'Oyarifa Hills', 'slug' => 'oyarifa-hills', 'city' => 'Oyarifa', 'region' => 'Greater Accra', 'description' => 'A fast-growing hillside suburb north-east of Accra with surveyed residential plots, new estate developments, and improving road access.', 'image_path' => '/light/images/all/10.jpg', 'sort_order' => 4],
        ];

        foreach ($communities as $community) {
            Community::updateOrCreate(['slug' => $community['slug']], ['is_active' => true, ...$community]);
        }

        $eastLegon = Community::where('slug', 'east-legon')->first();
        $airport = Community::where('slug', 'airport-residential')->first();
        $oyarifa = Community::where('slug', 'oyarifa-hills')->first();
        $cantonments = Community::where('slug', 'cantonments')->first();
        $ama = TeamMember::where('slug', 'ama-mensah')->first();
        $kojo = TeamMember::where('slug', 'kojo-addo')->first();
        $nadia = TeamMember::where('slug', 'nadia-boateng')->first();
        $yaw = TeamMember::where('slug', 'yaw-owusu')->first();

        $listings = [
            ['title' => 'Executive family villa in East Legon', 'slug' => 'executive-family-villa-east-legon', 'property_code' => 'BGR-2026-0001', 'type' => 'sale', 'property_type' => 'villa', 'status' => 'available', 'address' => 'Boundary Road', 'city' => 'East Legon', 'region' => 'Greater Accra', 'community_id' => $eastLegon?->id, 'team_member_id' => $ama?->id, 'price' => 3850000, 'bedrooms' => 5, 'bathrooms' => 6, 'garages' => 3, 'floors' => 2, 'year_built' => 2019, 'area_sqm' => 620, 'description' => 'A private family villa with generous living areas, staff quarters, fitted kitchen, pool-ready compound, and secure parking.', 'features' => ['Gated compound', 'Staff quarters', 'Fitted kitchen', 'Family lounge', 'Swimming pool', 'CCTV', 'Air conditioning', 'Generator backup'], 'image_paths' => ['/light/images/all/1.jpg', '/light/images/all/8.jpg', '/light/images/all/14.jpg'], 'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'virtual_tour_url' => null, 'floor_plan_paths' => ['/light/images/map.png'], 'nearby_places' => ['Lincoln Community School - 1.2km', 'North Legon Hospital - 2.4km', 'A&C Shopping Mall - 3.1km', 'Trasacco Estate police post - 1.8km'], 'title_status' => 'Registered freehold', 'latitude' => 5.6401, 'longitude' => -0.1537, 'is_featured' => true, 'is_investment' => false, 'is_new' => false],
            ['title' => 'Modern apartment near Airport City', 'slug' => 'modern-apartment-airport-city', 'property_code' => 'BGR-2026-0002', 'type' => 'rent', 'property_type' => 'apartment', 'status' => 'available', 'address' => 'Liberation Road', 'city' => 'Airport', 'region' => 'Greater Accra', 'community_id' => $airport?->id, 'team_member_id' => $nadia?->id, 'price' => 18000, 'bedrooms' => 3, 'bathrooms' => 3, 'garages' => 1, 'floors' => 1, 'year_built' => 2022, 'area_sqm' => 210, 'description' => 'Serviced apartment with elevator access, backup power, concierge reception, gym, and short commute to business districts.', 'features' => ['Backup power', 'Gym', 'Elevator', 'Concierge', 'Internet', 'Parking', 'Security'], 'image_paths' => ['/light/images/all/2.jpg', '/light/images/all/3.jpg', '/light/images/all/9.jpg'], 'video_url' => null, 'virtual_tour_url' => 'https://momento360.com/e/u/example', 'floor_plan_paths' => ['/light/images/map.png'], 'nearby_places' => ['Kotoka International Airport - 2.0km', 'Airport West Hospital - 1.5km', 'Marina Mall - 2.8km'], 'title_status' => null, 'latitude' => 5.6045, 'longitude' => -0.1710, 'is_featured' => true, 'is_investment' => false, 'is_new' => true],
            ['title' => 'Serviced plots at Oyarifa hillside', 'slug' => 'serviced-plots-oyarifa-hillside', 'property_code' => 'BGR-2026-0003', 'type' => 'sale', 'property_type' => 'land', 'status' => 'available', 'address' => 'Oyarifa Hills', 'city' => 'Oyarifa', 'region' => 'Greater Accra', 'community_id' => $oyarifa?->id, 'team_member_id' => $kojo?->id, 'price' => 145000, 'bedrooms' => 0, 'bathrooms' => 0, 'garages' => 0, 'floors' => 0, 'year_built' => null, 'area_sqm' => 520, 'description' => 'Surveyed residential plots with road access, electricity nearby, and clear allocation workflow for buyers.', 'features' => ['Surveyed', 'Road access', 'Residential zoning', 'Payment plan'], 'image_paths' => ['/light/images/all/10.jpg', '/light/images/all/11.jpg', '/light/images/all/12.jpg'], 'video_url' => null, 'virtual_tour_url' => null, 'floor_plan_paths' => ['/light/images/map.png'], 'nearby_places' => ['Oyarifa SDA Hospital - 1.6km', 'Oyarifa Community Market - 0.8km'], 'title_status' => 'Site plan available, indenture in progress', 'latitude' => 5.7215, 'longitude' => -0.1520, 'is_featured' => true, 'is_investment' => true, 'is_new' => true],
            ['title' => 'Townhouse cluster in Cantonments', 'slug' => 'townhouse-cluster-cantonments', 'property_code' => 'BGR-2026-0004', 'type' => 'sale', 'property_type' => 'house', 'status' => 'reserved', 'address' => '5th Avenue', 'city' => 'Cantonments', 'region' => 'Greater Accra', 'community_id' => $cantonments?->id, 'team_member_id' => $yaw?->id, 'price' => 4200000, 'bedrooms' => 4, 'bathrooms' => 5, 'garages' => 2, 'floors' => 2, 'year_built' => 2017, 'area_sqm' => 480, 'description' => 'Low-density townhouse in a quiet diplomatic enclave with premium finishes and private outdoor space.', 'features' => ['Private garden', 'Security', 'Premium finishes', 'Two lounges', 'CCTV', 'Parking'], 'image_paths' => ['/light/images/all/15.jpg', '/light/images/all/16.jpg', '/light/images/all/20.jpg'], 'video_url' => null, 'virtual_tour_url' => null, 'floor_plan_paths' => ['/light/images/map.png'], 'nearby_places' => ['Ghana International School - 1.0km', 'Ridge Hospital - 2.2km', 'Villagio Vista - 2.6km'], 'title_status' => 'Registered freehold', 'latitude' => 5.5889, 'longitude' => -0.1676, 'is_featured' => false, 'is_investment' => false, 'is_new' => false],
            ['title' => 'Commercial office suite, Airport City', 'slug' => 'commercial-office-suite-airport-city', 'property_code' => 'BGR-2026-0005', 'type' => 'lease', 'property_type' => 'office', 'status' => 'available', 'address' => 'Airport Bypass Road', 'city' => 'Airport', 'region' => 'Greater Accra', 'community_id' => $airport?->id, 'team_member_id' => $nadia?->id, 'price' => 42000, 'bedrooms' => 0, 'bathrooms' => 2, 'garages' => 6, 'floors' => 1, 'year_built' => 2021, 'area_sqm' => 340, 'description' => 'Grade-A office suite with fibre internet, backup power, and dedicated parking, suited to corporate headquarters and financial services tenants.', 'features' => ['Internet', 'Backup power', 'Parking', 'CCTV', 'Air conditioning', 'Conference room'], 'image_paths' => ['/light/images/all/4.jpg', '/light/images/all/5.jpg'], 'video_url' => null, 'virtual_tour_url' => null, 'floor_plan_paths' => ['/light/images/map.png'], 'nearby_places' => ['Kotoka International Airport - 1.4km', 'Rendezvous Restaurant - 0.6km'], 'title_status' => null, 'latitude' => 5.6070, 'longitude' => -0.1690, 'is_featured' => false, 'is_investment' => true, 'is_new' => true],
            ['title' => 'Sold: Riverside bungalow in Tema Community 25', 'slug' => 'riverside-bungalow-tema-community-25', 'property_code' => 'BGR-2025-0091', 'type' => 'sale', 'property_type' => 'house', 'status' => 'sold', 'address' => 'Community 25', 'city' => 'Tema', 'region' => 'Greater Accra', 'community_id' => null, 'team_member_id' => $ama?->id, 'price' => 1250000, 'bedrooms' => 3, 'bathrooms' => 3, 'garages' => 2, 'floors' => 1, 'year_built' => 2015, 'area_sqm' => 260, 'description' => 'A three-bedroom bungalow sold to a returning-resident family after a two-week inspection and documentation process.', 'features' => ['Garden', 'Security', 'Parking'], 'image_paths' => ['/light/images/all/6.jpg', '/light/images/all/7.jpg'], 'video_url' => null, 'virtual_tour_url' => null, 'floor_plan_paths' => null, 'nearby_places' => ['Tema General Hospital - 3.0km'], 'title_status' => 'Registered freehold', 'latitude' => 5.6698, 'longitude' => -0.0166, 'is_featured' => false, 'is_investment' => false, 'is_new' => false, 'sold_at' => now()->subDays(18)],
        ];

        foreach ($listings as $listing) {
            PropertyListing::updateOrCreate(['property_code' => $listing['property_code']], ['currency' => 'GHS', 'is_published' => true, ...$listing]);
        }

        $testimonials = [
            ['client_name' => 'Efua Asante', 'client_role' => 'Homeowner, East Legon', 'avatar_path' => '/light/images/clients/1.png', 'quote' => 'SOMA PROPERTIES walked us through the acquisition process clearly, from inspections and document review to negotiation and completion.', 'rating' => 5, 'sort_order' => 1],
            ['client_name' => 'Kwabena Ofori', 'client_role' => 'Developer, Oyarifa', 'avatar_path' => '/light/images/clients/2.png', 'quote' => 'Their site identification advice helped us compare access, planning constraints, demand, and infrastructure before committing to the development site.', 'rating' => 5, 'sort_order' => 2],
            ['client_name' => 'Linda Appiah', 'client_role' => 'Corporate tenant', 'avatar_path' => '/light/images/clients/3.png', 'quote' => 'Our company needed lease advice and suitable office options quickly. SOMA handled the shortlist, viewings, and lease negotiations with discipline.', 'rating' => 4, 'sort_order' => 3],
            ['client_name' => 'Samuel Nkrumah', 'client_role' => 'Investor, Airport Residential', 'avatar_path' => '/light/images/clients/4.png', 'quote' => 'The market research compared rental values, occupier demand, and resale potential before we made the investment decision.', 'rating' => 5, 'sort_order' => 4],
            ['client_name' => 'Abena Owusu', 'client_role' => 'Seller, Cantonments', 'avatar_path' => '/light/images/clients/5.png', 'quote' => 'Their disposal strategy gave us better pricing confidence, stronger buyer qualification, and a smoother closing process.', 'rating' => 5, 'sort_order' => 5],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(['client_name' => $testimonial['client_name']], ['is_active' => true, ...$testimonial]);
        }

        $partnerBanks = [
            ['name' => 'GCB Bank', 'logo_path' => '/light/images/clients/1.png', 'url' => null, 'sort_order' => 1],
            ['name' => 'Ecobank Ghana', 'logo_path' => '/light/images/clients/2.png', 'url' => null, 'sort_order' => 2],
            ['name' => 'Stanbic Bank', 'logo_path' => '/light/images/clients/3.png', 'url' => null, 'sort_order' => 3],
            ['name' => 'CalBank', 'logo_path' => '/light/images/clients/4.png', 'url' => null, 'sort_order' => 4],
            ['name' => 'Fidelity Bank Ghana', 'logo_path' => '/light/images/clients/5.png', 'url' => null, 'sort_order' => 5],
        ];

        foreach ($partnerBanks as $bank) {
            PartnerBank::updateOrCreate(['name' => $bank['name']], ['is_active' => true, ...$bank]);
        }

        $stats = [
            ['label' => 'Years in operation', 'value' => '8+', 'icon' => 'fa-light fa-calendar', 'sort_order' => 1],
            ['label' => 'Client assignments', 'value' => '420+', 'icon' => 'fa-light fa-file-signature', 'sort_order' => 2],
            ['label' => 'Sites and assets reviewed', 'value' => '95', 'icon' => 'fa-light fa-map-location-dot', 'sort_order' => 3],
            ['label' => 'Advisors & partners', 'value' => '36', 'icon' => 'fa-light fa-user-tie', 'sort_order' => 4],
        ];

        foreach ($stats as $stat) {
            CompanyStat::updateOrCreate(['label' => $stat['label']], ['is_active' => true, ...$stat]);
        }

        CompanyStat::whereNotIn('label', array_column($stats, 'label'))->update(['is_active' => false]);

        $posts = [
            ['title' => '5 documents to check before buying land in Ghana', 'slug' => '5-documents-to-check-before-buying-land-in-ghana', 'category' => 'Land Documentation', 'excerpt' => 'From site plans to ownership history, here is the paperwork our team reviews before a land acquisition.', 'body' => "Buying land in Ghana without checking documentation remains a major cause of disputes. Before a client commits, SOMA PROPERTIES reviews available site plans, search information, ownership history, indentures or lease documents, and any claim or litigation concerns raised during due diligence.\n\nBuyers should also confirm that boundaries on the ground match the documents and that access, utilities, planning conditions, and future development potential are understood.\n\nIf a seller cannot produce basic documents, treat that as a serious warning sign rather than a negotiating opportunity.", 'cover_path' => '/light/images/all/11.jpg', 'team_member_id' => $kojo?->id, 'published_at' => now()->subDays(6)],
            ['title' => 'How title registration works in Ghana', 'slug' => 'how-title-registration-works-in-ghana', 'category' => 'Property Law', 'excerpt' => 'A plain-language walkthrough of registration follow-up after a property purchase closes.', 'body' => "Once a sale agreement is signed, the next step is protecting the buyer's interest through the appropriate registration process. This commonly involves stamping the instrument, lodging documents with the relevant division, resolving queries, and paying applicable fees.\n\nProcessing times vary, so SOMA PROPERTIES helps clients organize the file, coordinate professional support, and track follow-up actions instead of leaving the buyer to manage the process alone.", 'cover_path' => '/light/images/all/12.jpg', 'team_member_id' => $kojo?->id, 'published_at' => now()->subDays(14)],
            ['title' => '2026 property market outlook for Greater Accra', 'slug' => '2026-property-market-outlook-greater-accra', 'category' => 'Market Trends', 'excerpt' => 'Where demand is heading across East Legon, Airport Residential, and the fast-growing Oyarifa corridor.', 'body' => "Demand in established districts like East Legon and Cantonments remains steady, driven by returning residents and corporate tenants. The bigger story for 2026 is the north-eastern corridor toward Oyarifa and Adenta, where new road investment and serviced-plot developments are pulling first-time buyers away from more expensive central neighbourhoods.\n\nRental yields for serviced apartments near Airport City continue to outperform standalone houses, largely due to corporate relocation demand.", 'cover_path' => '/light/images/all/10.jpg', 'team_member_id' => $nadia?->id, 'published_at' => now()->subDays(2)],
            ['title' => 'A buyer\'s guide to mortgage financing with our partner banks', 'slug' => 'buyers-guide-mortgage-financing-partner-banks', 'category' => 'Buying Guides', 'excerpt' => 'What to prepare before applying for mortgage financing through GCB, Ecobank, Stanbic, CalBank, or Fidelity.', 'body' => "Each of our partner banks has slightly different requirements, but most mortgage applications in Ghana ask for six months of bank statements, proof of income or a letter from your employer, a valuation report on the property, and your Ghana Card.\n\nOur advisory team can introduce buyers directly to a relationship officer at any of our five partner banks and will assemble the property-side documents, including the valuation report, so financing does not stall the purchase.", 'cover_path' => '/light/images/all/14.jpg', 'team_member_id' => $ama?->id, 'published_at' => now()->subDays(24)],
        ];

        foreach ($posts as $post) {
            BlogPost::updateOrCreate(['slug' => $post['slug']], ['is_published' => true, ...$post]);
        }

        $parcels = [
            [
                'plot_number' => 'AD-101',
                'title' => 'Adenta serviced residential plot',
                'location_name' => 'Adenta, Greater Accra',
                'price' => 180000,
                'area_sqm' => 640,
                'geometry' => [
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [-0.16910, 5.69820],
                        [-0.16780, 5.69830],
                        [-0.16770, 5.69690],
                        [-0.16900, 5.69680],
                        [-0.16910, 5.69820],
                    ]],
                ],
                'attributes' => ['zoning' => 'Residential', 'tenure' => 'Freehold', 'road_access' => 'Titled road'],
            ],
            [
                'plot_number' => 'OY-224',
                'title' => 'Oyarifa hillside parcel',
                'location_name' => 'Oyarifa, Greater Accra',
                'price' => 145000,
                'area_sqm' => 520,
                'geometry' => [
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [-0.15260, 5.72240],
                        [-0.15140, 5.72220],
                        [-0.15120, 5.72100],
                        [-0.15270, 5.72090],
                        [-0.15260, 5.72240],
                    ]],
                ],
                'attributes' => ['zoning' => 'Residential', 'tenure' => 'Leasehold', 'road_access' => 'Laterite road'],
            ],
            [
                'plot_number' => 'PR-043',
                'title' => 'Prampram investment plot',
                'location_name' => 'Prampram, Greater Accra',
                'price' => 95000,
                'area_sqm' => 700,
                'geometry' => [
                    'type' => 'Polygon',
                    'coordinates' => [[
                        [0.10520, 5.71220],
                        [0.10670, 5.71210],
                        [0.10660, 5.71070],
                        [0.10500, 5.71080],
                        [0.10520, 5.71220],
                    ]],
                ],
                'attributes' => ['zoning' => 'Mixed use', 'tenure' => 'Freehold', 'road_access' => 'Surveyed access'],
            ],
        ];

        foreach ($parcels as $parcel) {
            Parcel::updateOrCreate(
                ['plot_number' => $parcel['plot_number']],
                ['currency' => 'GHS', 'status' => 'available', ...$parcel]
            );
        }

        app(SampleParcelImport::class)->import(base_path('sample-parcel.js'));

        $this->seedLeadsAndOrders();
    }

    /**
     * Demo leads/bookings/payments so the admin dashboard has real activity to show.
     */
    private function seedLeadsAndOrders(): void
    {
        $listingIds = PropertyListing::pluck('id')->all();
        $parcelIds = Parcel::where('status', 'available')->pluck('id')->all();
        $teamIds = TeamMember::pluck('id')->all();
        $bankIds = PartnerBank::pluck('id')->all();

        if (empty($listingIds) || empty($parcelIds)) {
            return;
        }

        $inquiries = [
            ['name' => 'Kwabena Owusu', 'email' => 'kwabena.owusu@example.com', 'phone' => '+233 24 111 2222', 'subject' => 'Viewing request', 'message' => 'Is this property still available? I would like to schedule a viewing this week.', 'source' => 'listing', 'days_ago' => 1, 'status' => 'new'],
            ['name' => 'Efua Asante', 'email' => 'efua.asante@example.com', 'phone' => '+233 20 333 4444', 'subject' => 'Price negotiation', 'message' => 'Would the seller consider an offer slightly below asking price?', 'source' => 'listing', 'days_ago' => 2, 'status' => 'new'],
            ['name' => 'Michael Tetteh', 'email' => 'michael.tetteh@example.com', 'phone' => '+233 27 555 6666', 'subject' => 'Documentation', 'message' => 'Please send the title documents and site plan for review.', 'source' => 'listing', 'days_ago' => 5, 'status' => 'contacted'],
            ['name' => 'Abena Frimpong', 'email' => 'abena.frimpong@example.com', 'phone' => '+233 55 777 8888', 'subject' => 'General enquiry', 'message' => 'Do you have similar properties in Cantonments or Airport Residential?', 'source' => 'listing', 'days_ago' => 9, 'status' => 'contacted'],
            ['name' => 'Yaw Boateng', 'email' => 'yaw.boateng@example.com', 'phone' => '+233 24 999 0000', 'subject' => 'Investment interest', 'message' => 'Interested in bulk purchase for investment purposes, please call back.', 'source' => 'listing', 'days_ago' => 14, 'status' => 'closed'],
            ['name' => 'Grace Adjei', 'email' => 'grace.adjei@example.com', 'phone' => '+233 26 222 1111', 'subject' => 'Rental terms', 'message' => 'What are the lease terms and minimum tenancy period?', 'source' => 'listing', 'days_ago' => 20, 'status' => 'closed'],
        ];

        foreach ($inquiries as $i => $data) {
            $days = $data['days_ago'];
            unset($data['days_ago']);
            $inquiry = Inquiry::updateOrCreate(
                ['email' => $data['email'], 'subject' => $data['subject']],
                [...$data, 'property_listing_id' => $listingIds[$i % count($listingIds)]]
            );
            $inquiry->forceFill(['created_at' => now()->subDays($days), 'updated_at' => now()->subDays($days)])->save();
        }

        $siteVisits = [
            ['name' => 'Andy Sarpong', 'email' => 'andy.sarpong@example.com', 'phone' => '+233 24 123 4567', 'days_ago' => 1, 'status' => 'requested'],
            ['name' => 'Linda Mensah', 'email' => 'linda.mensah@example.com', 'phone' => '+233 20 234 5678', 'days_ago' => 3, 'status' => 'confirmed'],
            ['name' => 'Ebenezer Kufuor', 'email' => 'ebenezer.kufuor@example.com', 'phone' => '+233 27 345 6789', 'days_ago' => 6, 'status' => 'confirmed'],
            ['name' => 'Patience Nyarko', 'email' => 'patience.nyarko@example.com', 'phone' => '+233 55 456 7890', 'days_ago' => 11, 'status' => 'completed'],
            ['name' => 'Solomon Aidoo', 'email' => 'solomon.aidoo@example.com', 'phone' => '+233 24 567 8901', 'days_ago' => 17, 'status' => 'completed'],
        ];

        foreach ($siteVisits as $i => $data) {
            $days = $data['days_ago'];
            unset($data['days_ago']);
            $useParcel = $i % 2 === 0;
            $visit = SiteVisit::updateOrCreate(
                ['email' => $data['email'], 'phone' => $data['phone']],
                [
                    ...$data,
                    'property_listing_id' => $useParcel ? null : $listingIds[$i % count($listingIds)],
                    'parcel_id' => $useParcel ? $parcelIds[$i % count($parcelIds)] : null,
                    'team_member_id' => $teamIds[$i % count($teamIds)] ?? null,
                    'preferred_date' => now()->addDays(3 + $i)->toDateString(),
                    'preferred_time' => ['10:00 AM', '12:00 PM', '2:00 PM', '4:00 PM'][$i % 4],
                ]
            );
            $visit->forceFill(['created_at' => now()->subDays($days), 'updated_at' => now()->subDays($days)])->save();
        }

        if (! empty($bankIds)) {
            $mortgageApps = [
                ['name' => 'Daniel Osei', 'email' => 'daniel.osei@example.com', 'phone' => '+233 24 111 3333', 'property_price' => 850000, 'down_payment' => 170000, 'monthly_income' => 25000, 'loan_term_years' => 15, 'employment_status' => 'employed', 'days_ago' => 2, 'status' => 'new'],
                ['name' => 'Comfort Adusei', 'email' => 'comfort.adusei@example.com', 'phone' => '+233 20 222 4444', 'property_price' => 1250000, 'down_payment' => 312500, 'monthly_income' => 38000, 'loan_term_years' => 20, 'employment_status' => 'self_employed', 'days_ago' => 8, 'status' => 'under_review'],
                ['name' => 'Isaac Appiah', 'email' => 'isaac.appiah@example.com', 'phone' => '+233 27 333 5555', 'property_price' => 620000, 'down_payment' => 124000, 'monthly_income' => 18000, 'loan_term_years' => 10, 'employment_status' => 'employed', 'days_ago' => 15, 'status' => 'approved'],
                ['name' => 'Rebecca Amoah', 'email' => 'rebecca.amoah@example.com', 'phone' => '+233 55 444 6666', 'property_price' => 980000, 'down_payment' => 196000, 'monthly_income' => 30000, 'loan_term_years' => 20, 'employment_status' => 'employed', 'days_ago' => 25, 'status' => 'declined'],
            ];

            foreach ($mortgageApps as $i => $data) {
                $days = $data['days_ago'];
                unset($data['days_ago']);
                $app = MortgageApplication::updateOrCreate(
                    ['email' => $data['email']],
                    [
                        ...$data,
                        'property_listing_id' => $listingIds[$i % count($listingIds)],
                        'partner_bank_id' => $bankIds[$i % count($bankIds)],
                    ]
                );
                $app->forceFill(['created_at' => now()->subDays($days), 'updated_at' => now()->subDays($days)])->save();
            }
        }

        $orders = [
            ['buyer_name' => 'Prince Owusu-Ansah', 'buyer_email' => 'prince.oa@example.com', 'buyer_phone' => '+233 24 777 1111', 'amount' => 145000, 'status' => 'paid', 'days_ago' => 4],
            ['buyer_name' => 'Vivian Darko', 'buyer_email' => 'vivian.darko@example.com', 'buyer_phone' => '+233 20 888 2222', 'amount' => 210000, 'status' => 'paid', 'days_ago' => 12],
            ['buyer_name' => 'Nana Yaw Asiedu', 'buyer_email' => 'nana.asiedu@example.com', 'buyer_phone' => '+233 27 999 3333', 'amount' => 95000, 'status' => 'pending', 'days_ago' => 1],
            ['buyer_name' => 'Joyce Ampofo', 'buyer_email' => 'joyce.ampofo@example.com', 'buyer_phone' => '+233 55 000 4444', 'amount' => 320000, 'status' => 'paid', 'days_ago' => 22],
            ['buyer_name' => 'Kwame Antwi', 'buyer_email' => 'kwame.antwi@example.com', 'buyer_phone' => '+233 24 555 9999', 'amount' => 178000, 'status' => 'failed', 'days_ago' => 30],
        ];

        foreach ($orders as $i => $data) {
            $days = $data['days_ago'];
            unset($data['days_ago']);
            $order = Order::updateOrCreate(
                ['buyer_email' => $data['buyer_email']],
                [
                    ...$data,
                    'currency' => 'GHS',
                    'parcel_id' => $parcelIds[$i % count($parcelIds)],
                    'paystack_reference' => 'DEMO-'.strtoupper(uniqid()),
                    'paid_at' => $data['status'] === 'paid' ? now()->subDays($days) : null,
                ]
            );
            $order->forceFill(['created_at' => now()->subDays($days), 'updated_at' => now()->subDays($days)])->save();
        }
    }
}
