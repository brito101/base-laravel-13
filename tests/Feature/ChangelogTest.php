<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

it('renders the changelog with every configured release', function () {
    $user = User::factory()->create(['first_access' => 0]);
    $user->assignRole('Usuário');

    $response = $this->actingAs($user)->get(route('admin.changelog'))->assertOk();

    foreach (config('changelog.releases') as $release) {
        $response->assertSee('v'.$release['version']);

        foreach ($release['changes'] ?? array_merge(...array_values($release['groups'] ?? [])) as $change) {
            $response->assertSee($change);
        }
    }
});
