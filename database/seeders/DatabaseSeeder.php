<?php

namespace Database\Seeders;

use App\Models\AgencyService;
use App\Models\BlogPost;
use App\Models\Community;
use App\Models\CompanyStat;
use App\Models\Faq;
use App\Models\Parcel;
use App\Models\PartnerBank;
use App\Models\PropertyListing;
use App\Models\SiteContent;
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
            ['email' => env('ADMIN_EMAIL', 'admin@bluegaterealty.test')],
            [
                'name' => env('ADMIN_NAME', 'BlueGate Admin'),
                'password' => bcrypt(env('ADMIN_PASSWORD', 'password')),
                'is_admin' => true,
            ]
        );

        $contents = [
            'home_hero' => [
                'title' => 'Real estate advisory, sales, and land acquisition in one place',
                'subtitle' => 'BlueGate Realty helps buyers, families, developers, and investors acquire verified property with clear documentation and accountable support.',
                'body' => 'From titled residential plots to move-in-ready homes, our team combines corporate-grade due diligence with a simple buying experience.',
                'image_path' => '/light/images/bg/12.jpg',
                'metadata' => ['cta_primary' => 'Explore listings', 'cta_secondary' => 'Talk to an advisor'],
            ],
            'about' => [
                'title' => 'A property company built for transparent transactions',
                'subtitle' => 'We combine field verification, digital records, and buyer support so every transaction has a clear paper trail.',
                'body' => 'Our agency works across residential sales, land banking, site acquisition, investment advisory, and post-sale support. Every listing is reviewed for ownership claims, parcel details, pricing, and buyer fit before it reaches our marketplace.',
                'image_path' => '/light/images/bg/10.jpg',
                'metadata' => ['founded' => '2018', 'transactions' => '420+', 'verified_assets' => '95'],
            ],
            'contact' => [
                'title' => 'Speak with a property advisor',
                'subtitle' => 'Send a request and our team will respond with availability, documents, inspection options, and next steps.',
                'body' => 'Office: East Legon, Accra. Hours: Monday to Friday, 8:30 AM to 5:30 PM.',
                'image_path' => '/light/images/bg/8.jpg',
                'metadata' => ['email' => 'hello@bluegaterealty.test', 'phone' => '+233 30 000 0000'],
            ],
            'why_choose_us' => [
                'title' => 'Why families, investors, and companies choose BlueGate',
                'subtitle' => 'Every transaction runs through the same verification and documentation workflow, whether it is a starter apartment or a multi-acre parcel.',
                'body' => null,
                'image_path' => null,
                'metadata' => [
                    'items' => [
                        ['icon' => 'fa-light fa-file-shield', 'title' => 'Verified documentation', 'text' => 'Ownership, site plans, and survey documents are checked before a listing reaches our marketplace.'],
                        ['icon' => 'fa-light fa-map-location-dot', 'title' => 'GIS-mapped land', 'text' => 'Every parcel ships with a boundary polygon you can review on a map before ever visiting the site.'],
                        ['icon' => 'fa-light fa-lock', 'title' => 'Secure Paystack payments', 'text' => 'Reserve a parcel or pay a deposit through a Paystack-backed checkout with instant confirmation.'],
                        ['icon' => 'fa-light fa-user-tie', 'title' => 'Dedicated advisors', 'text' => 'A named advisor follows your transaction from inspection through registration, not a call centre queue.'],
                    ],
                ],
            ],
        ];

        foreach ($contents as $key => $content) {
            SiteContent::updateOrCreate(['key' => $key], $content);
        }

        $services = [
            [
                'title' => 'Property Sales', 'slug' => 'property-sales',
                'summary' => 'End-to-end sales support for homeowners, developers, and institutions selling verified residential or commercial property.',
                'body' => 'BlueGate Realty prepares properties for market with pricing guidance, document checks, listing presentation, buyer qualification, inspection coordination, negotiation support, and closing follow-through. We position each property with clear facts, strong visuals, and a structured buyer pipeline so sellers can move from listing to signed agreement with fewer delays and cleaner documentation.',
                'process' => ['Review ownership documents, property condition, location, and seller objectives', 'Recommend pricing, marketing position, and likely buyer profile', 'Prepare listing content, photography guidance, and buyer-facing property notes', 'Qualify enquiries, coordinate inspections, and manage buyer feedback', 'Support negotiation, sale agreement review, payment milestones, and closing handover'],
                'benefits' => ['Professional pricing and market positioning before the property goes live', 'Buyer screening that reduces unserious enquiries and wasted inspections', 'Clear documentation checklist before negotiation begins', 'Advisor support from first listing through payment and handover'],
                'icon' => 'fa-light fa-sign-hanging', 'sort_order' => 1,
            ],
            [
                'title' => 'Property Purchase', 'slug' => 'property-purchase',
                'summary' => 'Guided purchase representation for buyers who need verified options, inspection support, and safer transaction steps.',
                'body' => 'Our purchase service helps buyers identify the right property, compare options, inspect shortlisted assets, check available documents, negotiate fair terms, and move through payment and completion with an accountable advisor. We focus on practical buyer protection: knowing what you are buying, who is selling it, what documents support the sale, and what must happen before money changes hands.',
                'process' => ['Capture your budget, preferred locations, property type, timeline, and financing position', 'Shortlist suitable homes, offices, land, or investment assets from verified sources', 'Arrange inspections and document review before serious negotiation', 'Negotiate price, payment milestones, fixtures, handover dates, and seller obligations', 'Coordinate legal review, payment confirmation, possession, and post-purchase registration steps'],
                'benefits' => ['A structured buying brief instead of random property chasing', 'Side-by-side comparison of location, price, condition, and documentation', 'Inspection and negotiation support from an advisor who represents your interest', 'Reduced risk of paying before key ownership and transaction checks are complete'],
                'icon' => 'fa-light fa-house-circle-check', 'sort_order' => 2,
            ],
            [
                'title' => 'Land Sales', 'slug' => 'land-sales',
                'summary' => 'Sales and buyer support for residential, commercial, and development land with boundary and documentation checks.',
                'body' => 'Land transactions require more than a plot description. We support sellers and buyers with site verification, boundary review, land search coordination, pricing guidance, site plan checks, allocation documentation, and transfer support. Every land brief is handled with attention to access roads, utilities, community context, title status, and future development potential.',
                'process' => ['Confirm plot location, boundary references, ownership claims, and available site documents', 'Review pricing against nearby land activity and development potential', 'Prepare buyer-facing parcel details, site notes, and inspection schedule', 'Coordinate buyer visits, survey confirmation, and reservation terms', 'Support indenture, allocation, transfer, and registration follow-up'],
                'benefits' => ['Clearer understanding of boundary, access, and documentation before commitment', 'GIS or site-plan assisted parcel review where available', 'Reservation and payment milestones that match the documentation process', 'Reduced confusion around allocation, indenture, transfer, and registration steps'],
                'icon' => 'fa-light fa-map-location-dot', 'sort_order' => 3,
            ],
            [
                'title' => 'Rentals', 'slug' => 'rentals',
                'summary' => 'Rental search, landlord coordination, lease review, and move-in support for individuals, families, and companies.',
                'body' => 'We help tenants find suitable rental property and help landlords secure reliable occupants. The service covers requirement capture, shortlist preparation, viewing coordination, landlord negotiation, lease condition review, rent advance guidance, move-in inspection, and renewal reminders. Corporate clients can also use us for staff housing and relocation support.',
                'process' => ['Confirm location, budget, household or staff needs, lease duration, and move-in deadline', 'Shortlist available properties and confirm viewing access with landlords or managers', 'Arrange inspections and collect feedback quickly after each viewing', 'Negotiate rent, service charges, furnishing, repairs, and lease start terms', 'Support lease signing, move-in condition notes, payment tracking, and renewal dates'],
                'benefits' => ['Faster search through filtered rental options', 'Negotiation support on rent, repairs, service charges, and lease terms', 'Move-in checklist that reduces disputes after possession', 'Useful support for executive rentals and staff relocation'],
                'icon' => 'fa-light fa-key', 'sort_order' => 4,
            ],
            [
                'title' => 'Property Management', 'slug' => 'property-management',
                'summary' => 'Management support for landlords who need rent collection, tenant handling, inspections, and maintenance coordination.',
                'body' => 'Our property management service helps owners protect rental income and preserve asset condition. We coordinate tenant onboarding, rent schedules, inspection routines, issue logging, maintenance vendors, arrears follow-up, renewal notices, and owner reporting. The goal is simple: fewer surprises, cleaner records, and better tenant accountability.',
                'process' => ['Document the property, tenancy status, rent terms, and maintenance baseline', 'Set up tenant communication, payment schedule, inspection calendar, and reporting format', 'Collect rent updates, track arrears, and escalate issues according to agreed rules', 'Coordinate repairs with approved vendors and keep cost records', 'Prepare owner reports covering occupancy, income, expenses, and upcoming renewals'],
                'benefits' => ['Consistent rent and tenancy administration', 'Routine inspections and maintenance tracking', 'Single point of contact for tenants and vendors', 'Owner reports that make income, expenses, and issues easier to monitor'],
                'icon' => 'fa-light fa-clipboard-list-check', 'sort_order' => 5,
            ],
            [
                'title' => 'Property Valuation', 'slug' => 'property-valuation',
                'summary' => 'Market-informed valuation support for sale, purchase, mortgage, insurance, reporting, and investment decisions.',
                'body' => 'BlueGate Realty coordinates valuation assignments for clients who need a defensible view of property value. We review property characteristics, location, condition, comparable transactions, rental potential, replacement considerations, and intended use of the valuation. Where a formal valuation report is required, we coordinate with qualified valuation professionals.',
                'process' => ['Confirm the purpose of valuation and required report format', 'Collect ownership details, property descriptions, site access information, and available plans', 'Inspect or coordinate inspection of the property and surrounding market context', 'Review comparable evidence, replacement indicators, rental data, and condition factors', 'Deliver valuation guidance or coordinate the formal valuation report and client review'],
                'benefits' => ['Better pricing decisions before sale or purchase negotiations', 'Support for mortgage, insurance, probate, accounting, and investment decisions', 'Clear explanation of assumptions and market evidence', 'Access to qualified professionals where formal certification is required'],
                'icon' => 'fa-light fa-scale-balanced', 'sort_order' => 6,
            ],
            [
                'title' => 'Surveying', 'slug' => 'surveying',
                'summary' => 'Survey coordination for boundary confirmation, site plans, subdivision, beacon checks, and development preparation.',
                'body' => 'Accurate survey information is critical for land purchase, construction, registration, and dispute prevention. We coordinate survey support for boundary identification, beacon location, site plan preparation, acreage confirmation, subdivision planning, and development set-out. Clients receive practical guidance on what the survey means for purchase, registration, or building decisions.',
                'process' => ['Review existing site plan, indenture, allocation note, or parcel reference', 'Arrange site visit with a survey professional and relevant local contacts', 'Confirm boundaries, access, beacons, dimensions, and neighbouring developments', 'Prepare or update survey outputs required for transaction or planning use', 'Explain findings and next steps for purchase, registration, development, or dispute handling'],
                'benefits' => ['Reduced boundary uncertainty before buying or building', 'Survey-backed information for documentation and planning', 'Support for subdivision, beacon replacement, and acreage confirmation', 'Clearer evidence when a land issue needs escalation'],
                'icon' => 'fa-light fa-ruler-combined', 'sort_order' => 7,
            ],
            [
                'title' => 'Architectural Design', 'slug' => 'architectural-design',
                'summary' => 'Concept and design coordination for homes, apartments, offices, mixed-use projects, and estate layouts.',
                'body' => 'We help clients move from land or property idea to a buildable design brief. The service covers requirements gathering, site context review, concept direction, space planning, architect coordination, approval considerations, budget alignment, and design revisions. The result is a clearer path from idea to drawings, costing, and construction planning.',
                'process' => ['Develop the design brief around use, budget, style, rooms, site constraints, and future plans', 'Review site orientation, access, utilities, setbacks, and planning considerations', 'Coordinate concept sketches, layouts, mood direction, and functional requirements', 'Refine drawings with client feedback and cost implications in view', 'Prepare next-step documentation for approvals, costing, or construction mobilisation'],
                'benefits' => ['A design brief that matches lifestyle, business use, and budget', 'Better coordination between land conditions, drawings, and construction expectations', 'Reduced redesign caused by unclear requirements at the start', 'Smooth handover from concept to costing and build planning'],
                'icon' => 'fa-light fa-compass-drafting', 'sort_order' => 8,
            ],
            [
                'title' => 'Building Construction', 'slug' => 'building-construction',
                'summary' => 'Construction coordination for residential and commercial projects from planning through supervised delivery.',
                'body' => 'BlueGate Realty supports clients who need dependable construction coordination rather than fragmented vendor management. We help define scope, review drawings and budgets, assemble the right project team, coordinate procurement, track milestones, manage site communication, and report progress. The focus is disciplined execution, cost visibility, and quality control.',
                'process' => ['Review drawings, site conditions, budget, timeline, and client quality expectations', 'Prepare construction scope, preliminary cost schedule, and contractor requirements', 'Coordinate mobilisation, permits or approvals, procurement plan, and site setup', 'Track milestone delivery, site issues, variations, payments, and quality checks', 'Support practical completion, snagging, handover, and maintenance guidance'],
                'benefits' => ['Clearer project scope and cost expectations before work starts', 'Milestone-based coordination and progress reporting', 'Reduced communication gaps between client, contractor, architect, and suppliers', 'Quality and handover checks before completion is accepted'],
                'icon' => 'fa-light fa-helmet-safety', 'sort_order' => 9,
            ],
            [
                'title' => 'Estate Development', 'slug' => 'estate-development',
                'summary' => 'Development advisory for landowners, investors, and developers planning residential or mixed-use estates.',
                'body' => 'Estate development needs land strategy, product planning, infrastructure thinking, approvals, sales positioning, and phased delivery discipline. We help clients assess development potential, define unit mix, coordinate master planning, model pricing, plan infrastructure, and prepare a sales or allocation strategy that matches market demand.',
                'process' => ['Assess land size, access, location demand, title position, and development constraints', 'Define target market, unit mix, infrastructure needs, phasing, and pricing assumptions', 'Coordinate concept layouts, professional inputs, cost estimates, and approval pathway', 'Prepare go-to-market plan for sales, reservations, or investor participation', 'Track development milestones, buyer communication, allocation, and handover planning'],
                'benefits' => ['Early feasibility view before major design or construction spend', 'Better alignment between product mix, infrastructure cost, and buyer demand', 'Structured reservation and sales strategy for phased projects', 'Advisor support across planning, development, sales, and handover'],
                'icon' => 'fa-light fa-city', 'sort_order' => 10,
            ],
            [
                'title' => 'Documentation', 'slug' => 'documentation',
                'summary' => 'Property document review and transaction file preparation for buyers, sellers, landlords, and developers.',
                'body' => 'Our documentation service helps clients organise, review, and understand the papers behind a property transaction. We support document checklists, ownership file review, seller or landlord documentation requests, offer letters, reservation notes, lease support, sale agreement coordination, receipts, handover notes, and transaction file archiving.',
                'process' => ['Identify the transaction type and prepare the required document checklist', 'Collect available ownership, survey, tax, lease, company, or transfer documents', 'Review completeness, consistency, names, property descriptions, dates, and missing items', 'Coordinate corrections, additional requests, or legal review where needed', 'Prepare an organised transaction file for signing, payment, registration, or future reference'],
                'benefits' => ['Fewer missing documents during negotiation or closing', 'Clearer understanding of what each document proves and what it does not prove', 'Cleaner transaction records for future resale, mortgage, or registration use', 'Better coordination between client, advisor, lawyer, surveyor, and seller'],
                'icon' => 'fa-light fa-folder-open', 'sort_order' => 11,
            ],
            [
                'title' => 'Property Registration', 'slug' => 'property-registration',
                'summary' => 'Registration coordination for land and property transfers, title follow-up, and post-purchase documentation.',
                'body' => 'Registration is often where otherwise good transactions slow down. We help clients understand the registration pathway, organise required documents, coordinate professional support, track submissions, respond to queries, and maintain follow-up until the client has a clearer ownership record. This service is especially useful after purchase, inheritance, allocation, or transfer.',
                'process' => ['Review the property type, current documents, transfer history, and registration objective', 'Prepare registration checklist and identify missing signatures, plans, receipts, or supporting documents', 'Coordinate with legal, survey, stool, family, developer, or registry contacts as needed', 'Track submission status, queries, corrections, and required follow-up actions', 'Update the client with milestones and organise the final registration records'],
                'benefits' => ['Clearer post-purchase path from agreement to registration follow-up', 'Reduced delays caused by missing documents or inconsistent property descriptions', 'Central tracking of submissions, queries, and next actions', 'Better file discipline for future sale, mortgage, or inheritance needs'],
                'icon' => 'fa-light fa-file-signature', 'sort_order' => 12,
            ],
            [
                'title' => 'Land Litigation Support', 'slug' => 'land-litigation-support',
                'summary' => 'Practical property support for clients dealing with boundary disputes, competing claims, encroachment, or land litigation.',
                'body' => 'BlueGate Realty does not replace legal counsel, but we support clients and lawyers with property facts, site coordination, document organisation, survey liaison, inspection notes, claim history, and transaction context. The service helps legal teams and clients work from a clearer property file and a better understanding of the land issue.',
                'process' => ['Capture the dispute background, parties involved, location, documents, and urgent risks', 'Organise available ownership, survey, transaction, payment, correspondence, and site records', 'Coordinate site inspection, boundary review, photographs, and survey input where appropriate', 'Prepare property notes and document summaries for client and legal review', 'Support follow-up actions requested by counsel, surveyors, mediators, or authorities'],
                'benefits' => ['Better organised property evidence for legal consultation', 'Survey and site context to clarify boundary or encroachment issues', 'Clear timeline of transaction events and document gaps', 'Practical coordination while your lawyer handles legal strategy'],
                'icon' => 'fa-light fa-gavel', 'sort_order' => 13,
            ],
            [
                'title' => 'Mortgage Assistance', 'slug' => 'mortgage-assistance',
                'summary' => 'Mortgage readiness, bank matching, document preparation, and purchase coordination for financed buyers.',
                'body' => 'We help buyers understand affordability, prepare lender documents, compare partner bank requirements, and align the property purchase process with mortgage approval timelines. Our role is to reduce confusion between the buyer, bank, seller, valuer, and legal teams so financing does not derail an otherwise suitable purchase.',
                'process' => ['Review income profile, deposit capacity, target property, and preferred repayment range', 'Match buyer requirements with suitable lender or partner bank options', 'Prepare mortgage document checklist and coordinate property information needed by the bank', 'Support valuation access, offer conditions, seller communication, and approval milestones', 'Coordinate closing timeline between lender, buyer, seller, lawyer, and registration steps'],
                'benefits' => ['Clearer affordability and deposit expectations before property negotiation', 'Guidance on lender requirements and likely approval conditions', 'Better coordination between mortgage timeline and seller expectations', 'Support with valuation access, documentation, and closing communication'],
                'icon' => 'fa-light fa-building-columns', 'sort_order' => 14,
            ],
            [
                'title' => 'Facility Management', 'slug' => 'facility-management',
                'summary' => 'Facility operations support for offices, residences, estates, and mixed-use properties that need reliable upkeep.',
                'body' => 'Facility management keeps buildings usable, safe, and presentable after construction or occupation. We coordinate inspections, maintenance schedules, service providers, cleaning, security, utilities, tenant issue logs, compliance reminders, and management reporting. The service is suited to landlords, estates, offices, and property owners who need structured operational oversight.',
                'process' => ['Assess building systems, occupancy, vendors, service contracts, and current maintenance issues', 'Create an operations calendar for inspections, cleaning, security, utilities, and preventive maintenance', 'Set up issue logging, vendor response rules, approvals, and cost tracking', 'Monitor service delivery, recurring problems, health and safety concerns, and tenant feedback', 'Deliver periodic facility reports with actions completed, pending risks, and budget notes'],
                'benefits' => ['Preventive maintenance instead of constant emergency repairs', 'Cleaner vendor coordination and service accountability', 'Better tenant, occupant, or owner communication', 'Facility reports that make costs, risks, and completed work visible'],
                'icon' => 'fa-light fa-screwdriver-wrench', 'sort_order' => 15,
            ],
        ];

        foreach ($services as $service) {
            AgencyService::updateOrCreate(['slug' => $service['slug']], ['is_active' => true, ...$service]);
        }

        AgencyService::whereNotIn('slug', array_column($services, 'slug'))->update(['is_active' => false]);

        $faqs = [
            ['question' => 'How do you verify a property before listing it?', 'answer' => 'We request ownership documents, inspect the site, review parcel boundaries where applicable, and flag missing documentation before a buyer commits.', 'category' => 'Verification', 'sort_order' => 1],
            ['question' => 'Can I reserve a parcel online?', 'answer' => 'Available parcels can move into checkout. Payment confirmation marks the parcel as reserved while the team completes documentation and allocation.', 'category' => 'Payments', 'sort_order' => 2],
            ['question' => 'Do you support inspections?', 'answer' => 'Yes. Buyers can request physical or virtual inspections for listings and land parcels. The team will confirm availability and meeting details.', 'category' => 'Inspections', 'sort_order' => 3],
            ['question' => 'Can companies buy through BlueGate Realty?', 'answer' => 'Yes. We support company purchases, staff housing, investment portfolios, and acquisition reporting for management teams.', 'category' => 'Corporate', 'sort_order' => 4],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['question' => $faq['question']], ['is_active' => true, ...$faq]);
        }

        $team = [
            ['name' => 'Ama Mensah', 'slug' => 'ama-mensah', 'role' => 'Managing Broker', 'bio' => 'Ama leads transaction strategy and seller verification. She has managed residential and land acquisition mandates across Accra, Tema, and Kumasi.', 'email' => 'ama@bluegaterealty.test', 'phone' => '+233 24 000 0001', 'image_path' => '/light/images/agents/1.jpg', 'sort_order' => 1],
            ['name' => 'Kojo Addo', 'slug' => 'kojo-addo', 'role' => 'Land Acquisition Lead', 'bio' => 'Kojo coordinates parcel inspections, site data, buyer allocation, and documentation follow-up for land buyers.', 'email' => 'kojo@bluegaterealty.test', 'phone' => '+233 24 000 0002', 'image_path' => '/light/images/agents/2.jpg', 'sort_order' => 2],
            ['name' => 'Nadia Boateng', 'slug' => 'nadia-boateng', 'role' => 'Corporate Client Advisor', 'bio' => 'Nadia supports corporate relocations, investor onboarding, and executive property search workflows.', 'email' => 'nadia@bluegaterealty.test', 'phone' => '+233 24 000 0003', 'image_path' => '/light/images/agents/3.jpg', 'sort_order' => 3],
            ['name' => 'Yaw Owusu', 'slug' => 'yaw-owusu', 'role' => 'Listings Manager', 'bio' => 'Yaw manages listing quality, media, price updates, and buyer feedback from inspections.', 'email' => 'yaw@bluegaterealty.test', 'phone' => '+233 24 000 0004', 'image_path' => '/light/images/agents/4.jpg', 'sort_order' => 4],
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
            PropertyListing::updateOrCreate(['slug' => $listing['slug']], ['currency' => 'GHS', 'is_published' => true, ...$listing]);
        }

        $testimonials = [
            ['client_name' => 'Efua Asante', 'client_role' => 'Homeowner, East Legon', 'avatar_path' => '/light/images/clients/1.png', 'quote' => 'BlueGate walked us through every document before we paid a cedi. The villa purchase closed faster than we expected, and the team stayed in touch through the whole registration process.', 'rating' => 5, 'sort_order' => 1],
            ['client_name' => 'Kwabena Ofori', 'client_role' => 'Land buyer, Oyarifa', 'avatar_path' => '/light/images/clients/2.png', 'quote' => 'I reserved my plot online and paid in instalments. Having the boundary polygon on a map before I ever visited the site gave me real confidence in the purchase.', 'rating' => 5, 'sort_order' => 2],
            ['client_name' => 'Linda Appiah', 'client_role' => 'Corporate relocation, tenant', 'avatar_path' => '/light/images/clients/3.png', 'quote' => 'Our company needed serviced apartments for three relocating staff within a month. BlueGate shortlisted options, handled inspections, and negotiated the lease terms directly with landlords.', 'rating' => 4, 'sort_order' => 3],
            ['client_name' => 'Samuel Nkrumah', 'client_role' => 'Investor, Airport Residential', 'avatar_path' => '/light/images/clients/4.png', 'quote' => 'The investment advisory team compared three neighbourhoods against yield and appreciation before we committed. That analysis is the reason we came back for a second acquisition.', 'rating' => 5, 'sort_order' => 4],
            ['client_name' => 'Abena Owusu', 'client_role' => 'Seller, Cantonments', 'avatar_path' => '/light/images/clients/5.png', 'quote' => 'Listing through BlueGate meant professional photography, a verified buyer pool, and a transaction that closed without the usual back-and-forth over documentation.', 'rating' => 5, 'sort_order' => 5],
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
            ['label' => 'Verified transactions', 'value' => '420+', 'icon' => 'fa-light fa-file-signature', 'sort_order' => 2],
            ['label' => 'Mapped land assets', 'value' => '95', 'icon' => 'fa-light fa-map-location-dot', 'sort_order' => 3],
            ['label' => 'Active agents & partners', 'value' => '36', 'icon' => 'fa-light fa-user-tie', 'sort_order' => 4],
        ];

        foreach ($stats as $stat) {
            CompanyStat::updateOrCreate(['label' => $stat['label']], ['is_active' => true, ...$stat]);
        }

        $posts = [
            ['title' => '5 documents to check before buying land in Ghana', 'slug' => '5-documents-to-check-before-buying-land-in-ghana', 'category' => 'Land Documentation', 'excerpt' => 'From site plans to indentures, here is the paperwork our team requests before any parcel goes up for sale.', 'body' => "Buying land in Ghana without checking documentation is the single biggest cause of disputes we see. Before BlueGate lists any parcel, we request the site plan, a current search report from Lands Commission, evidence of the vendor's root of title, the indenture or lease document, and confirmation that the land is free of any pending litigation.\n\nBuyers should also confirm that the boundaries on the ground match the coordinates on the site plan, which is why every parcel we list ships with a mapped polygon buyers can review before a site visit.\n\nIf a seller cannot produce these documents, treat that as a serious warning sign rather than a negotiating opportunity.", 'cover_path' => '/light/images/all/11.jpg', 'team_member_id' => $kojo?->id, 'published_at' => now()->subDays(6)],
            ['title' => 'How title registration works in Ghana', 'slug' => 'how-title-registration-works-in-ghana', 'category' => 'Property Law', 'excerpt' => 'A plain-language walkthrough of registering title with the Lands Commission after a purchase closes.', 'body' => "Once a sale agreement is signed, the next step is registering the transfer with the Lands Commission so the buyer's interest is protected against future claims. This typically involves stamping the instrument at the Domestic Tax Revenue Division, lodging the document at the Land Registration Division, and paying the applicable registration fees.\n\nProcessing times vary, and BlueGate's documentation team tracks each file until a buyer receives their registered document, rather than leaving buyers to follow up independently.", 'cover_path' => '/light/images/all/12.jpg', 'team_member_id' => $kojo?->id, 'published_at' => now()->subDays(14)],
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
    }
}
