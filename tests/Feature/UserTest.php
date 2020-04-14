<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Product;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_a_user_can_see_welcome_page()
    {
        $response = $this->get('/');

        $response->assertSee("Elvis Onobo");
    }

    public function test_that_a_logged_in_user_can_see_the_links_and_stats_and_products(){

        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $response = $this->actingAs($user)->get('home');
        $response->assertSee("Nothing");
        $response->assertSee("Chai!");
        $response->assertSeeInOrder(['Purchase History', 'Wallet', 'Logout']);
        $response->assertSee("Buy");
    }

    public function test_that_a_user_is_sent_to_the_buy_page_onclick_buy_button(){
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $productData = Product::first();

        $response = $this->actingAs($user)->get(
            route('buy', [
                'id'=>$productData->id,
                'slug'=>$productData->slug
            ]));
        $response->assertViewIs('pages.buy');
        $response->assertSeeInOrder(['Pay With Card', 'Pay From Wallet']);
        // $response->assertViewHas('price');
    }


}
