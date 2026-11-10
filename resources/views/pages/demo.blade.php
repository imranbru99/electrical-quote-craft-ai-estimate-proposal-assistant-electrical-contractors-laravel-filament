@extends('layouts.marketing')
@section('title', 'Demo Users — ElectricalQuoteCraft')
@section('content')
<section class="wrap section fade-up">
    <h1>Demo access</h1>
    <p class="lead">Use these seeded accounts to explore the Filament admin at <a href="/admin"><strong>/admin</strong></a>. Password for all: <code>password</code></p>
    <div class="grid-2" style="margin-top:1.5rem">
        <div class="demo-box"><strong>Admin</strong><br>admin@electricalquotecraft.test<br>Full module control</div>
        <div class="demo-box"><strong>Owner</strong><br>owner@electricalquotecraft.test<br>Approvals & revenue ops</div>
        <div class="demo-box"><strong>Staff</strong><br>staff@electricalquotecraft.test<br>Intake & drafting</div>
        <div class="demo-box"><strong>Technician</strong><br>tech@electricalquotecraft.test<br>Field tickets & profile</div>
        <div class="demo-box"><strong>Customer (portal demo)</strong><br>customer@electricalquotecraft.test<br>No admin panel access</div>
    </div>
    <div class="cta-row" style="margin-top:1.5rem">
        <a class="btn btn-primary" href="/admin/login">Login to Admin</a>
    </div>
</section>
@endsection