<?php namespace Tests\Repositories;

use App\Models\ShortLink;
use App\Repositories\ShortLinkRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ShortLinkRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ShortLinkRepository
     */
    protected $shortLinkRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->shortLinkRepo = \App::make(ShortLinkRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_short_link()
    {
        $shortLink = ShortLink::factory()->make()->toArray();

        $createdShortLink = $this->shortLinkRepo->create($shortLink);

        $createdShortLink = $createdShortLink->toArray();
        $this->assertArrayHasKey('id', $createdShortLink);
        $this->assertNotNull($createdShortLink['id'], 'Created ShortLink must have id specified');
        $this->assertNotNull(ShortLink::find($createdShortLink['id']), 'ShortLink with given id must be in DB');
        $this->assertModelData($shortLink, $createdShortLink);
    }

    /**
     * @test read
     */
    public function test_read_short_link()
    {
        $shortLink = ShortLink::factory()->create();

        $dbShortLink = $this->shortLinkRepo->find($shortLink->id);

        $dbShortLink = $dbShortLink->toArray();
        $this->assertModelData($shortLink->toArray(), $dbShortLink);
    }

    /**
     * @test update
     */
    public function test_update_short_link()
    {
        $shortLink = ShortLink::factory()->create();
        $fakeShortLink = ShortLink::factory()->make()->toArray();

        $updatedShortLink = $this->shortLinkRepo->update($fakeShortLink, $shortLink->id);

        $this->assertModelData($fakeShortLink, $updatedShortLink->toArray());
        $dbShortLink = $this->shortLinkRepo->find($shortLink->id);
        $this->assertModelData($fakeShortLink, $dbShortLink->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_short_link()
    {
        $shortLink = ShortLink::factory()->create();

        $resp = $this->shortLinkRepo->delete($shortLink->id);

        $this->assertTrue($resp);
        $this->assertNull(ShortLink::find($shortLink->id), 'ShortLink should not exist in DB');
    }
}
