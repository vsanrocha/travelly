<?php

use App\Models\User;
use App\Models\TravelRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Artisan;

uses(WithFaker::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@travelly.com'
    ]);
});

test('user can get their own travel requests', function () {
    Sanctum::actingAs($this->user);
    $travelRequests = TravelRequest::factory()->count(3)->create([
        'user_id' => $this->user->id
    ]);

    $otherUser = User::factory()->create();
    TravelRequest::factory()->count(2)->create([
        'user_id' => $otherUser->id
    ]);

    $response = $this->getJson('/api/travel-requests');

    $response->assertStatus(200)
        ->assertJsonCount(3);
});

test('user can filter travel requests by status', function () {
    Sanctum::actingAs($this->user);
    TravelRequest::factory()->count(2)->create([
        'user_id' => $this->user->id,
        'status' => 'requested'
    ]);
    TravelRequest::factory()->count(1)->create([
        'user_id' => $this->user->id,
        'status' => 'approved'
    ]);

    $response = $this->getJson('/api/travel-requests?status=approved');

    $response->assertStatus(200)
        ->assertJsonCount(1);
});

test('user can filter travel requests by date range', function () {
    Sanctum::actingAs($this->user);

    TravelRequest::factory()->create([
        'user_id' => $this->user->id,
        'departure_date' => '2025-01-01',
    ]);

    TravelRequest::factory()->create([
        'user_id' => $this->user->id,
        'departure_date' => '2025-02-15',
    ]);

    TravelRequest::factory()->create([
        'user_id' => $this->user->id,
        'departure_date' => '2025-03-30',
    ]);

    $response = $this->getJson('/api/travel-requests?start_date=2025-02-01&end_date=2025-03-01');

    $response->assertStatus(200)
        ->assertJsonCount(1);
});

test('user can filter travel requests by destination', function () {
    Sanctum::actingAs($this->user);

    TravelRequest::factory()->create([
        'user_id' => $this->user->id,
        'destination' => 'Paris, France'
    ]);

    TravelRequest::factory()->create([
        'user_id' => $this->user->id,
        'destination' => 'Tokyo, Japan'
    ]);

    $response = $this->getJson('/api/travel-requests?destination=paris');

    $response->assertStatus(200)
        ->assertJsonCount(1)
        ->assertJsonFragment(['destination' => 'Paris, France']);
});

test('user can create a new travel request', function () {
    Sanctum::actingAs($this->user);

    $travelRequestData = [
        'destination' => 'Berlin, Germany',
        'departure_date' => now()->addDays(10)->toDateString(),
        'return_date' => now()->addDays(20)->toDateString(),
    ];

    $response = $this->postJson('/api/travel-requests', $travelRequestData);

    $response->assertCreated();

    $this->assertDatabaseHas('travel_requests', [
        'user_id' => $this->user->id,
        'requester_name' => $this->user->name,
        'destination' => 'Berlin, Germany',
        'status' => 'requested'
    ]);
});

test('user cannot create a travel request with invalid data', function () {
    Sanctum::actingAs($this->user);

    $invalidData = [
        'destination' => '',
        'departure_date' => now()->subDays(1)->toDateString(), // Past date
        'return_date' => now()->subDays(2)->toDateString(), // Before departure
    ];

    $response = $this->postJson('/api/travel-requests', $invalidData);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['destination', 'departure_date', 'return_date']);
});

test('user can view their own travel request', function () {
    Sanctum::actingAs($this->user);

    $travelRequest = TravelRequest::factory()->create([
        'user_id' => $this->user->id,
        'destination' => 'Rome, Italy'
    ]);

    $response = $this->getJson('/api/travel-requests/' . $travelRequest->id);

    $response->assertStatus(200)
        ->assertJson([
            'destination' => 'Rome, Italy',
            'user_id' => $this->user->id
        ]);
});

test('user cannot view another users travel request', function () {
    Sanctum::actingAs($this->user);

    $otherUser = User::factory()->create();
    $travelRequest = TravelRequest::factory()->create([
        'user_id' => $otherUser->id
    ]);

    $response = $this->getJson('/api/travel-requests/' . $travelRequest->id);

    $response->assertStatus(403);
});

test('user can update status of their own travel request', function () {
    Sanctum::actingAs($this->user);

    $travelRequest = TravelRequest::factory()->create([
        'user_id' => $this->user->id,
        'status' => 'requested'
    ]);

    $response = $this->patchJson('/api/travel-requests/' . $travelRequest->id . '/status', [
        'status' => 'approved'
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'approved'
        ]);

    $this->assertDatabaseHas('travel_requests', [
        'id' => $travelRequest->id,
        'status' => 'approved'
    ]);
});

test('user cannot update status with invalid value', function () {
    Sanctum::actingAs($this->user);

    $travelRequest = TravelRequest::factory()->create([
        'user_id' => $this->user->id,
        'status' => 'requested'
    ]);

    $response = $this->patchJson('/api/travel-requests/' . $travelRequest->id . '/status', [
        'status' => 'invalid-status'
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['status']);
});

test('user cannot cancel already cancelled request', function () {
    Sanctum::actingAs($this->user);

    $travelRequest = TravelRequest::factory()->create([
        'user_id' => $this->user->id,
        'status' => 'cancelled'
    ]);

    $response = $this->patchJson('/api/travel-requests/' . $travelRequest->id . '/status', [
        'status' => 'cancelled'
    ]);

    $response->assertStatus(400)
        ->assertJson([
            'error' => 'Pedido já cancelado'
        ]);
});

test('user cannot cancel request after departure date', function () {
    Sanctum::actingAs($this->user);

    $travelRequest = TravelRequest::factory()->create([
        'user_id' => $this->user->id,
        'status' => 'approved',
        'departure_date' => now()->subDays(1)->toDateString() // Yesterday
    ]);

    $response = $this->patchJson('/api/travel-requests/' . $travelRequest->id . '/status', [
        'status' => 'cancelled'
    ]);

    $response->assertStatus(400)
        ->assertJson([
            'error' => 'Não é possível cancelar após a data de ida'
        ]);
});

test('unauthenticated user cannot access travel requests', function () {
    $response = $this->getJson('/api/travel-requests');

    $response->assertStatus(401);
});
