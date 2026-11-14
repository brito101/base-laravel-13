<?php

use App\Models\User;
use App\Models\Visit;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

uses(DatabaseTransactions::class);

function dashboardUser(string $role): User
{
    $user = User::factory()->create(['first_access' => 0]);
    $user->assignRole($role);

    return $user;
}

function ajaxHeaders(): array
{
    return ['X-Requested-With' => 'XMLHttpRequest', 'Accept' => 'application/json'];
}

it('forbids the visits table to users without an audit role', function () {
    $this->actingAs(dashboardUser('Usuário'))
        ->get(route('admin.home'), ajaxHeaders())
        ->assertForbidden();
});

it('forbids the access statistics to users without an audit role', function () {
    $this->actingAs(dashboardUser('Usuário'))
        ->get(route('admin.home.chart'))
        ->assertForbidden();
});

it('still renders the dashboard page to users without an audit role', function () {
    $this->actingAs(dashboardUser('Usuário'))
        ->get(route('admin.home'))
        ->assertOk();
});

it('lists visits to administrators without exposing request data or url secrets', function () {
    $visit = Visit::create([
        'method' => 'POST',
        'url' => url('/reset-password/abc123?api_key=xyz789&page=2'),
        'request' => ['name' => 'Fulano', 'password' => 'Segredo123!'],
        'headers' => ['cookie' => ['laravel_session=s3cr3t']],
    ]);

    $raw = DB::table(config('visitor.table_name'))->where('id', $visit->id)->first();
    expect($raw->request)->not->toContain('Segredo123!')
        ->and($raw->headers)->not->toContain('s3cr3t');

    $response = $this->actingAs(dashboardUser('Administrador'))
        ->get(route('admin.home').'?draw=1&start=0&length=100&order[0][column]=0&order[0][dir]=desc'
            .'&columns[0][data]=time&columns[0][name]=time&columns[0][orderable]=true', ajaxHeaders())
        ->assertOk();

    $row = collect($response->json('data'))->firstWhere('id', $visit->id);

    expect($row)->not->toBeNull()
        ->and($row)->not->toHaveKey('request')
        ->and($row)->not->toHaveKey('headers')
        ->and($row['url'])->not->toContain('abc123')
        ->and($row['url'])->not->toContain('xyz789')
        ->and($row['url'])->toContain('page=2');
});

it('returns access statistics to administrators', function () {
    $this->actingAs(dashboardUser('Administrador'))
        ->get(route('admin.home.chart'))
        ->assertOk()
        ->assertJsonStructure(['onlineUsers', 'access', 'percent', 'chart' => ['labels', 'dataset']]);
});
