<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ShortLink;

class ShortLinkApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_short_link()
    {
        $shortLink = ShortLink::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/short_links', $shortLink
        );

        $this->assertApiResponse($shortLink);
    }

    /**
     * @test
     */
    public function test_read_short_link()
    {
        $shortLink = ShortLink::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/short_links/'.$shortLink->id
        );

        $this->assertApiResponse($shortLink->toArray());
    }

    /**
     * @test
     */
    public function test_update_short_link()
    {
        $shortLink = ShortLink::factory()->create();
        $editedShortLink = ShortLink::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/short_links/'.$shortLink->id,
            $editedShortLink
        );

        $this->assertApiResponse($editedShortLink);
    }

    /**
     * @test
     */
    public function test_delete_short_link()
    {
        $shortLink = ShortLink::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/short_links/'.$shortLink->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/short_links/'.$shortLink->id
        );

        $this->response->assertStatus(404);
    }
}
