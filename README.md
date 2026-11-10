# ElectricalQuoteCraft — AI Estimate & Proposal Assistant for Electrical Contractors

**ElectricalQuoteCraft** is a modular Laravel + Filament SaaS that helps electrical contractor owners and operations leads **draft itemized quotes and proposals from intake details**, route **human approval**, open **field job tickets**, and keep a complete **audit log**.

> Rank #3 opportunity · Business category: Electrical Contractors · Sector: Home & Field Services · Workflow: Estimate & Proposal Assistant · Function: Revenue operations

## SEO Keywords

electrical contractor software, AI estimate software, electrical proposal assistant, itemized electrical quotes, panel upgrade estimate, EV charger quote, field service quoting, service request intake, job ticket software, technician dispatch, proposal approval workflow, audit log compliance, messaging consent electrical, electrician license tracking, Jobber integration, ServiceTitan quoting, QuickBooks electrical invoice handoff, Google Calendar site visits, Laravel Filament SaaS, modular feature toggles, AI business automation, home & field services revenue operations, electrical contractor CRM ops, residential commercial electrical estimating, price catalog labor materials, Unicode PDF proposals, multi-role contractor admin

## Problem solved

For electrical contractors: draft itemized quotes or proposals from intake details for approval; operate on service requests, field technicians and job tickets.

**MVP flow:** 1 intake trigger → AI draft/action → human approval → audit log

## Features & modules

All modules are toggleable (Admin → **Feature Modules** or `config/modules.php` / env flags). Core workflow modules ship ON.

| Module | Default | Purpose |
|--------|---------|---------|
| Quote Intake | ON | Capture service requests that feed quoting |
| AI Quote Drafting | ON | Draft itemized estimates from intake + catalog |
| Proposal Approval | ON | Human-in-the-loop approval gate |
| Audit Log | ON | Immutable activity trail |
| Service Requests | ON | Residential/commercial request tracking |
| Job Tickets | ON | Convert approved quotes to field work |
| Field Technicians | ON | Profiles, licenses, availability |
| Price Catalog | ON | Materials/labor price book for AI matching |
| PDF Proposals | ON | Branded HTML/Unicode proposal output |
| Messaging Consent | ON | SMS/email consent records |
| Licensing & Safety | ON | License expiry + safety flags |
| Customer Portal | OFF | Optional customer-facing proposal view |
| Integrations Hub | OFF | Jobber / ServiceTitan / QuickBooks / Google Calendar |
| Calendar Scheduling | OFF | Site-visit scheduling hooks |
| Attendance Hub | OFF | Crew time clock (attendance machine ready) |
| Follow-Up Autopilot | OFF | Pending proposal reminder sequences |
| AI Catalog Enrichment | OFF | Online catalog enrichment hooks |
| Universal Slug Engine | ON | Multi-language proposal slugs |

### Package notes

Packagist packages `imrandevbd/drutogoti`, `laravel-admin-panel`, `laravel-ai-catalog`, `laravel-ai-hub`, `laravel-attendance-hub`, `laravel-unicode-pdf`, and `laravel-universal-slug` were not installable as stable public releases at build time. Equivalent capabilities are implemented in-app (`AiQuoteDrafter`, `ProposalPdfGenerator`, `SlugService`, attendance records, Filament admin, module toggles).

## Multi-type users

| Role | Demo email | Password | Access |
|------|------------|----------|--------|
| Admin | `admin@electricalquotecraft.test` | `password` | Full admin + modules |
| Owner | `owner@electricalquotecraft.test` | `password` | Approvals & revenue ops |
| Staff | `staff@electricalquotecraft.test` | `password` | Intake & AI drafting |
| Technician | `tech@electricalquotecraft.test` | `password` | Field tickets / profile |
| Customer | `customer@electricalquotecraft.test` | `password` | No Filament admin (portal demo) |

## Local run with Docker

```bash
cd pipeline/apps/ElectricalQuoteCraft
docker compose up -d --build
```

- App: http://localhost:8103
- Admin: http://localhost:8103/admin
- MySQL host port: `33063`
- Redis host port: `63793`

First boot runs migrations + demo seed automatically.

## Public pages

- `/` — Marketing home with live stats
- `/features` — Every feature & module
- `/modules` — ON/OFF module matrix
- `/workflow` — Intake → draft → approve → ticket
- `/pricing` — Pilot $299–$1,499/mo
- `/demo` — Demo credentials
- `/proposals/{slug}` — HTML proposal preview
- `/admin` — Filament operations console

## Tech stack

- PHP 8.4 · Laravel 13 · Filament 4 · Livewire
- MySQL 8.4 · Redis 7
- Docker Compose
- Modular feature flags · AI drafting service · Audit logging

## Screenshots

See `docs/screenshots/` for home, features, admin dashboard, and quote workflow captures.

## Integrations (hooks)

Jobber · ServiceTitan · QuickBooks · Google Calendar — toggle via Integrations Hub module.

## Risk / compliance

MED — messaging consent, licensing and safety. Consent records and technician license fields are included.

## Contact / Hire

- Developer: Imran Ahmed (IMRAN Dev BD)
- Website: https://imrandev.bd/contact
- Email: me@imrandev.bd
- GitHub: https://github.com/imranbru99
