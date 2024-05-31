<?php

namespace Tests\Feature;

use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VendorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_vendor()
    {
        $response = $this->post('/api/vendors', [
            'name' => 'Test Vendor',
            'email' => 'vendor@example.com',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => 'Test Vendor',
                     'email' => 'vendor@example.com',
                 ]);
    }

    /** @test */
    public function it_can_list_vendors()
    {
        Vendor::factory()->count(3)->create();

        $response = $this->get('/api/vendors');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function it_can_show_a_vendor()
    {
        $vendor = Vendor::factory()->create();

        $response = $this->get('/api/vendors/' . $vendor->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $vendor->id,
                     'name' => $vendor->name,
                     'email' => $vendor->email,
                 ]);
    }

    /** @test */
    public function it_can_update_a_vendor()
    {
        $vendor = Vendor::factory()->create();

        $response = $this->put('/api/vendors/' . $vendor->id, [
            'name' => 'Updated Vendor',
            'email' => 'updated@example.com',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $vendor->id,
                     'name' => 'Updated Vendor',
                     'email' => 'updated@example.com',
                 ]);
    }

    /** @test */
    public function it_can_delete_a_vendor()
    {
        $vendor = Vendor::factory()->create();

        $response = $this->delete('/api/vendors/' . $vendor->id);

        $response->assertStatus(204);
    }
}
