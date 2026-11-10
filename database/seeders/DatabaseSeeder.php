<?php

namespace Database\Seeders;

use App\Models\AttendanceRecord;
use App\Models\AuditLog;
use App\Models\CatalogItem;
use App\Models\ConsentRecord;
use App\Models\Customer;
use App\Models\IntegrationSetting;
use App\Models\JobTicket;
use App\Models\ModuleSetting;
use App\Models\ServiceRequest;
use App\Models\Technician;
use App\Models\User;
use App\Services\AiQuoteDrafter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@electricalquotecraft.test'],
            ['name' => 'Alex Admin', 'password' => Hash::make('password'), 'role' => User::ROLE_ADMIN, 'phone' => '555-0100', 'is_active' => true]
        );
        $owner = User::query()->updateOrCreate(
            ['email' => 'owner@electricalquotecraft.test'],
            ['name' => 'Olivia Owner', 'password' => Hash::make('password'), 'role' => User::ROLE_OWNER, 'phone' => '555-0101', 'is_active' => true]
        );
        $staff = User::query()->updateOrCreate(
            ['email' => 'staff@electricalquotecraft.test'],
            ['name' => 'Sam Staff', 'password' => Hash::make('password'), 'role' => User::ROLE_STAFF, 'phone' => '555-0102', 'is_active' => true]
        );
        $techUser = User::query()->updateOrCreate(
            ['email' => 'tech@electricalquotecraft.test'],
            ['name' => 'Taylor Technician', 'password' => Hash::make('password'), 'role' => User::ROLE_TECHNICIAN, 'phone' => '555-0103', 'is_active' => true]
        );
        User::query()->updateOrCreate(
            ['email' => 'customer@electricalquotecraft.test'],
            ['name' => 'Casey Customer', 'password' => Hash::make('password'), 'role' => User::ROLE_CUSTOMER, 'phone' => '555-0199', 'is_active' => true]
        );

        foreach (config('modules', []) as $key => $meta) {
            ModuleSetting::query()->updateOrCreate(
                ['key' => $key],
                [
                    'name' => $meta['name'],
                    'description' => $meta['description'] ?? null,
                    'enabled' => (bool) ($meta['enabled'] ?? false),
                    'is_core' => (bool) ($meta['core'] ?? false),
                ]
            );
        }

        $tech = Technician::query()->updateOrCreate(
            ['user_id' => $techUser->id],
            [
                'employee_code' => 'TECH-07',
                'license_number' => 'EL-44821',
                'license_expires_on' => now()->addYear()->toDateString(),
                'specialty' => 'Residential panels & EV chargers',
                'is_available' => true,
                'safety_certified' => true,
                'notes' => 'Journeyman electrician',
            ]
        );

        $catalog = [
            ['sku' => 'LAB-JR', 'name' => 'Journeyman electrician labor', 'category' => 'labor', 'unit' => 'hr', 'unit_price' => 95, 'keywords' => 'labor,install,wire,troubleshoot'],
            ['sku' => 'LAB-AP', 'name' => 'Apprentice electrician labor', 'category' => 'labor', 'unit' => 'hr', 'unit_price' => 55, 'keywords' => 'labor,helper'],
            ['sku' => 'PNL-200', 'name' => '200A main panel upgrade', 'category' => 'materials', 'unit' => 'ea', 'unit_price' => 1850, 'keywords' => 'panel,upgrade,200a,breaker'],
            ['sku' => 'PNL-100', 'name' => '100A subpanel', 'category' => 'materials', 'unit' => 'ea', 'unit_price' => 620, 'keywords' => 'subpanel,panel'],
            ['sku' => 'OUT-20', 'name' => '20A duplex outlet install', 'category' => 'materials', 'unit' => 'ea', 'unit_price' => 85, 'keywords' => 'outlet,receptacle,duplex'],
            ['sku' => 'GFCI', 'name' => 'GFCI outlet', 'category' => 'materials', 'unit' => 'ea', 'unit_price' => 45, 'keywords' => 'gfci,outlet,kitchen,bath'],
            ['sku' => 'EV-48', 'name' => '48A EV charger circuit', 'category' => 'materials', 'unit' => 'ea', 'unit_price' => 1250, 'keywords' => 'ev,charger,tesla,level2'],
            ['sku' => 'LED-REC', 'name' => 'LED recessed lighting kit', 'category' => 'materials', 'unit' => 'ea', 'unit_price' => 38, 'keywords' => 'lighting,led,recessed'],
            ['sku' => 'PERM', 'name' => 'Electrical permit filing', 'category' => 'fees', 'unit' => 'ea', 'unit_price' => 175, 'keywords' => 'permit,inspection'],
            ['sku' => 'TRIP', 'name' => 'Service call / diagnostic visit', 'category' => 'fees', 'unit' => 'visit', 'unit_price' => 129, 'keywords' => 'service,troubleshoot,diagnostic'],
        ];

        foreach ($catalog as $row) {
            CatalogItem::query()->updateOrCreate(['sku' => $row['sku']], array_merge($row, ['is_active' => true]));
        }

        $customers = [
            [
                'name' => 'Jordan Rivera', 'email' => 'jordan@homesample.test', 'phone' => '555-2001',
                'address' => '418 Maple Ave', 'city' => 'Austin', 'state' => 'TX', 'zip' => '78702',
                'customer_type' => 'residential', 'messaging_consent' => true,
            ],
            [
                'name' => 'BrightSide Bakery', 'email' => 'ops@brightsidebakery.test', 'phone' => '555-2002', 'company' => 'BrightSide Bakery LLC',
                'address' => '90 Commerce Blvd', 'city' => 'Round Rock', 'state' => 'TX', 'zip' => '78664',
                'customer_type' => 'commercial', 'messaging_consent' => true,
            ],
            [
                'name' => 'Morgan Lee', 'email' => 'morgan@homesample.test', 'phone' => '555-2003',
                'address' => '12 Cedar Trail', 'city' => 'Cedar Park', 'state' => 'TX', 'zip' => '78613',
                'customer_type' => 'residential', 'messaging_consent' => false,
            ],
        ];

        $customerModels = [];
        foreach ($customers as $c) {
            $customerModels[] = Customer::query()->updateOrCreate(['email' => $c['email']], $c);
        }

        foreach ($customerModels as $c) {
            if ($c->messaging_consent) {
                ConsentRecord::query()->updateOrCreate(
                    ['customer_id' => $c->id, 'channel' => 'sms'],
                    ['consented' => true, 'source' => 'web_form', 'captured_at' => now()->subDays(3)]
                );
            }
        }

        $sr1 = ServiceRequest::query()->updateOrCreate(
            ['request_number' => 'SR-DEMO-001'],
            [
                'customer_id' => $customerModels[0]->id,
                'assigned_technician_id' => $tech->id,
                'intake_by' => $staff->id,
                'title' => '200A panel upgrade + EV charger',
                'description' => 'Homeowner needs panel upgrade to 200A and a Level 2 EV charger circuit in the garage. Include permit.',
                'job_type' => 'panel_upgrade',
                'priority' => 'high',
                'status' => 'intake',
                'site_address' => '418 Maple Ave, Austin TX',
                'preferred_date' => now()->addDays(5)->toDateString(),
                'estimated_hours' => 10,
                'outlet_count' => 2,
                'panel_amps' => 200,
                'source' => 'web',
                'raw_intake' => ['channel' => 'website', 'notes' => 'Tesla Wall Connector'],
            ]
        );

        $sr2 = ServiceRequest::query()->updateOrCreate(
            ['request_number' => 'SR-DEMO-002'],
            [
                'customer_id' => $customerModels[1]->id,
                'assigned_technician_id' => $tech->id,
                'intake_by' => $staff->id,
                'title' => 'Bakery kitchen GFCI outlets + LED lighting',
                'description' => 'Commercial kitchen needs GFCI outlet replacements and LED recessed lighting in front of house.',
                'job_type' => 'outlet_install',
                'priority' => 'normal',
                'status' => 'intake',
                'site_address' => '90 Commerce Blvd, Round Rock TX',
                'preferred_date' => now()->addDays(8)->toDateString(),
                'estimated_hours' => 6,
                'outlet_count' => 8,
                'source' => 'phone',
            ]
        );

        ServiceRequest::query()->updateOrCreate(
            ['request_number' => 'SR-DEMO-003'],
            [
                'customer_id' => $customerModels[2]->id,
                'intake_by' => $staff->id,
                'title' => 'Intermittent breaker trip troubleshooting',
                'description' => 'Service call to troubleshoot living room breaker that trips under load.',
                'job_type' => 'troubleshooting',
                'priority' => 'normal',
                'status' => 'intake',
                'site_address' => '12 Cedar Trail, Cedar Park TX',
                'preferred_date' => now()->addDays(2)->toDateString(),
                'estimated_hours' => 2,
                'source' => 'phone',
            ]
        );

        $drafter = app(AiQuoteDrafter::class);
        $quote1 = $drafter->draftFromRequest($sr1->fresh(['customer']), $staff->id);
        $quote1->update(['status' => 'pending_approval']);
        AuditLog::record('quote.submitted_approval', \App\Models\Quote::class, $quote1->id, $staff->id);

        $quote2 = $drafter->draftFromRequest($sr2->fresh(['customer']), $staff->id);
        $quote2->approve($owner);

        JobTicket::query()->updateOrCreate(
            ['ticket_number' => 'JT-DEMO-001'],
            [
                'service_request_id' => $sr2->id,
                'quote_id' => $quote2->id,
                'technician_id' => $tech->id,
                'title' => 'Install GFCI + LED - BrightSide Bakery',
                'status' => 'scheduled',
                'scheduled_for' => now()->addDays(4),
                'notes' => 'Created from approved demo quote',
            ]
        );

        AttendanceRecord::query()->updateOrCreate(
            ['technician_id' => $tech->id, 'clock_in' => now()->startOfDay()->addHours(7)],
            ['clock_out' => now()->startOfDay()->addHours(16), 'source' => 'manual', 'notes' => 'Demo attendance']
        );

        foreach ([
            ['provider' => 'jobber', 'label' => 'Jobber', 'notes' => 'Push approved jobs'],
            ['provider' => 'servicetitan', 'label' => 'ServiceTitan', 'notes' => 'CRM / job sync'],
            ['provider' => 'quickbooks', 'label' => 'QuickBooks', 'notes' => 'Invoice after acceptance'],
            ['provider' => 'google_calendar', 'label' => 'Google Calendar', 'notes' => 'Site visit scheduling'],
        ] as $integration) {
            IntegrationSetting::query()->updateOrCreate(
                ['provider' => $integration['provider']],
                ['label' => $integration['label'], 'is_enabled' => false, 'notes' => $integration['notes']]
            );
        }

        AuditLog::record('demo.seeded', null, null, $admin->id, ['app' => 'ElectricalQuoteCraft']);
    }
}
