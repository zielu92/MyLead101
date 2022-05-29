<?php

namespace Tests\Feature;

use App\Models\Products;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic get product test
     *
     * @return void
     */
    public function test_getProducts()
    {
        $response = $this->get('/api/product');

        $response->assertStatus(200);
    }
    /**
     * A test of getting filtered content
     *
     * @return void
     */
    public function test_getProducts_with_parameters()
    {
        $response = $this->get('/api/product?name=a&user_id=2');

        $response->assertStatus(200);
    }
    /**
     * A test of getting continent for single product
     *
     * @return void
     */
    public function test_show_product()
    {
        Products::factory(10)->create();
        $response = $this->get('/api/product/9');
        $response->assertStatus(200);
    }
    /**
     * A test of adding new product
     *
     * @return void
     */
    public function test_add_product() {

        $headers['Authorization'] = 'Bearer '.$this->getTokenForAuthRequest();

        $response = $this->json('POST', '/api/product', [
            'name' => 'DecoMoreno',
            'description' => 'Bestseller book',
            'sku' => '5555',
            'price' => [
                ['name' => 'small', 'price'=>'5.55'],
                ['name' => 'big', 'price'=>'55.55'],
            ]
        ], $headers);

        $response->assertStatus(201);
    }

    public function test_update_product() {
        $headers['Authorization'] = 'Bearer '.$this->getTokenForAuthRequest();

        $response = $this->json('PUT', '/api/product/9', [
            'id' => '9',
            'name' => 'Updated record22.',
            'description' => 'Asperiores odit dicta quas aut natus pariatur consequatur quis laborum perferendis eligendi sed laboriosam adipisci laboriosam perferendis nihil dolorem.',
            'sku' => '58555359',
            'user_id' => 1,
            'created_at' => '2022-05-28T12:51:35.000000Z',
            'updated_at' => '2022-05-28T12:51:35.000000Z',
            'price' => [
                [
                    'id' => 6,
                    'products_id' => 9,
                    'name' => 'Saepe sequi iste.',
                    'price' => '5415.00',
                    'created_at' => '2022-05-28T12:51:35.000000Z',
                    'updated_at' => '2022-05-28T12:51:35.000000Z'
                ],
            ]
        ], $headers);

        $response->assertStatus(200);
    }

    public function test_delete_product() {
        $headers['Authorization'] = 'Bearer '.$this->getTokenForAuthRequest();
        $response = $this->json('DELETE','/api/product/9', [], $headers);
        $response->assertStatus(200);
    }

    public function getTokenForAuthRequest() {
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null, 'Test Personal Access Client', '/'
        );

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        $this->user = User::factory()->create();
        return $this->user->createToken('TestToken')->accessToken;
    }
}
