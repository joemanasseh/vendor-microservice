<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Vendor;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_product()
    {
        $vendor = Vendor::factory()->create();
        $category = Category::factory()->create();

        $response = $this->post('/api/products', [
            'vendor_id' => $vendor->id,
            'category_id' => $category->id,
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 100,
            'stock' => 10,
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => 'Test Product',
                     'description' => 'This is a test product.',
                     'price' => 100,
                     'stock' => 10,
                 ]);
    }

    /** @test */
    public function it_can_list_products()
    {
        Product::factory()->count(3)->create();

        $response = $this->get('/api/products');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function it_can_show_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->get('/api/products/' . $product->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $product->id,
                     'name' => $product->name,
                     'description' => $product->description,
                     'price' => $product->price,
                     'stock' => $product->stock,
                 ]);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->put('/api/products/' . $product->id, [
            'name' => 'Updated Product',
            'description' => 'This is an updated test product.',
            'price' => 150,
            'stock' => 5,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $product->id,
                     'name' => 'Updated Product',
                     'description' => 'This is an updated test product.',
                     'price' => 150,
                     'stock' => 5,
                 ]);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->delete('/api/products/' . $product->id);

        $response->assertStatus(204);
    }
}
