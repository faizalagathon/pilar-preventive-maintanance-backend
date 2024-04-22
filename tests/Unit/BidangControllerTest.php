<?php

namespace Tests\Unit;

use App\Models\Bidang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BidangControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_method_returns_correct_response()
    {
        $response = $this->get('/api/bidang');

        $response->assertStatus(200);
        $response->assertJson(['status' => true]);
    }

    public function test_index_method_returns_incorrect_bidang()
    {
        $response = $this->get('/api/bidang/' . 'data_yang_tidak_ada');

        $response->assertStatus(404);
    }

    // public function test_store_method_creates_new_bidang()
    // {
    //     $bidang = Bidang::factory()->make();

    //     $response = $this->post('/api/bidang', $bidang->toArray());

    //     $response->assertStatus(200);
    //     $this->assertDatabaseHas('bidang', $bidang->toArray());
    // }

    public function test_show_method_returns_correct_bidang()
    {
        $bidang = Bidang::factory()->create();

        $response = $this->get('/api/bidang/' . $bidang->id);

        $response->assertStatus(200);
        $response->assertJson(['status' => true, 'data' => $bidang->toArray()]);
    }


    public function test_show_method_returns_incorrect_bidang()
    {
        $response = $this->get('/api/bidang/' . 'data_yang_tidak_ada');

        $response->assertStatus(404);
    }

    // public function test_update_method_updates_bidang()
    // {
    //     $bidang = Bidang::factory()->create();
    //     $newBidang = Bidang::factory()->make();

    //     $response = $this->put('/api/bidang/' . $bidang->id, $newBidang->toArray());

    //     $response->assertStatus(200);
    //     $this->assertDatabaseHas('bidang', $newBidang->toArray());
    // }

    // public function test_destroy_method_deletes_bidang()
    // {
    //     $bidang = Bidang::factory()->create();

    //     $response = $this->delete('/api/bidang/' . $bidang->id);

    //     $response->assertStatus(200);
    //     $this->assertDatabaseMissing('bidang', $bidang->toArray());
    // }
}
