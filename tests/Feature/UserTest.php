<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Product;
use App\Wallet;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // welcome page
    public function test_that_a_user_can_see_welcome_page()
    {
        $response = $this->get('/');

        $response->assertSee("Elvis Onobo");
        $response->assertSee("Visit Shop");
    }

    // listings
    public function test_that_user_can_see_public_listings(){
        $response = $this->get('/listing');

        $products = factory(Product::class)->create();

        $response->assertOk();
    }

    // home
    public function test_that_a_logged_in_user_can_see_the_links_and_stats_and_products(){

        $user = factory(User::class)->create();
        $products = factory(Product::class)->create();

        $response = $this->actingAs($user)->get('home');
        $response->assertSee("Nothing");
        $response->assertSee("Chai!");
        $response->assertSeeInOrder(['Purchase History', 'Wallet', 'Logout']);
        $response->assertSee("Buy");
    }

    // buy
    public function test_that_a_user_is_sent_to_the_buy_page_onclick_buy_button(){
        // $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $products = factory(Product::class)->create();

        $productData = Product::first();

        $response = $this->actingAs($user)->get(
            route('buy', [
                'id'=>$productData->id,
                'slug'=>$productData->slug
            ]));
        $response->assertViewIs('pages.buy');
        $response->assertSeeInOrder(['Pay With Card', 'Pay From Wallet']);
    }

    // purchase history
    public function test_that_user_can_see_purchase_history(){
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('purchase-history'));
        $response->assertOk();
    }

    // user can see wallet balance
    public function test_that_user_can_see_wallet_balance_and_buttons(){

        $user = factory(User::class)->create();
        $amount = 100000;
        $wallet = Wallet::create([
            'user_id' => $user,
            'balance' => -$amount,
            'reference' => 'Nil',
            'authorization' => 'Nil',
            'nature_of_tranx' => 'Gift to '.$user->name
        ]);

        $response = $this->actingAs($user)->get(route('wallet'));
        $response->assertSeeInOrder(['Fund Wallet', 'Gift Funds', 'History']);
        $this->assertDatabaseHas('wallets', ['balance' => Wallet::first()->balance]);
    }
}