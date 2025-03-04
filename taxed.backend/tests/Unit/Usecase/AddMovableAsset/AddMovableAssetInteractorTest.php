<?php

namespace Tests\Unit\Usecase\AddMovableAsset;

use Illuminate\Database\Connection;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Database\Query\Processors\Processor;

use PHPUnit\Framework\TestCase;
use App\Usecase\AddMovableAsset\AddMovableAssetInteractor;
use App\Usecase\AddMovableAsset\AddMovableAssetRequest;
use App\Usecase\UsecaseResponse;

use App\Models\AssetCategory;
use App\Models\MovableAsset;

use Mockery;

use Tests\Unit\Repository\InMemoryTaxedRepository;
use Tests\Unit\Repository\DummyConnectionResolver;

class AddMovableAssetInteractorTest extends TestCase
{
  protected function setUp(): void
  {
    parent::setUp();

    $dummyGrammar = Mockery::mock(Grammar::class);
    $dummyGrammar->shouldReceive('getDateFormat')->andReturn('Y-m-d H:i:s');

    $dummyConnection = Mockery::mock(Connection::class);
    $dummyConnection->shouldReceive('getQueryGrammar')
      ->andReturn($dummyGrammar);
    $dummyConnection->shouldReceive('getPostProcessor')
      ->andReturn(Mockery::mock(Processor::class));
    $dummyConnection->shouldReceive('getPostProcessor')
      ->andReturn(Mockery::mock(Processor::class));

    $dummyResolver = new DummyConnectionResolver($dummyConnection);

    AssetCategory::setConnectionResolver($dummyResolver);
    MovableAsset::setConnectionResolver($dummyResolver);
  }

  protected function tearDown(): void
  {
    parent::tearDown();

    Mockery::close();
  }

  public function testCategoryIdSmallerOrEqualZeroShouldReturnErrorCodeInvalidAssetCategory()
  {
    $interactor = new AddMovableAssetInteractor(new InMemoryTaxedRepository([]));

    $response = $interactor->execute(new AddMovableAssetRequest('AssetName', 1000, 0));
    $this->assertEquals(UsecaseResponse::$CodeInvalidAssetCategory, $response->code);

    $response = $interactor->execute(new AddMovableAssetRequest('AssetName', 1000, -1));
    $this->assertEquals(UsecaseResponse::$CodeInvalidAssetCategory, $response->code);
  }

  public function testEmptyNameShouldReturnErrorCodeInvalidAssetName()
  {
    $interactor = new AddMovableAssetInteractor(new InMemoryTaxedRepository([]));

    $response = $interactor->execute(new AddMovableAssetRequest('', 1000, 1));
    $this->assertEquals(UsecaseResponse::$CodeInvalidAssetName, $response->code);
  }

  public function testPriceSmallerOrEqualZeroShouldReturnErrorCodeInvalidAssetPrice()
  {
    $interactor = new AddMovableAssetInteractor(new InMemoryTaxedRepository([]));

    $response = $interactor->execute(new AddMovableAssetRequest('AssetName', 0, 1));
    $this->assertEquals(UsecaseResponse::$CodeInvalidAssetPrice, $response->code);

    $response = $interactor->execute(new AddMovableAssetRequest('AssetName', -1, 1));
    $this->assertEquals(UsecaseResponse::$CodeInvalidAssetPrice, $response->code);
  }

  public function testAssetCategoryDoesNotExistShouldReturnErrorCodeInvalidAssetCategory()
  {
    $interactor = new AddMovableAssetInteractor(new InMemoryTaxedRepository([]));

    $response = $interactor->execute(new AddMovableAssetRequest('AssetName', 1000, 100));
    $this->assertEquals(UsecaseResponse::$CodeInvalidAssetCategory, $response->code);
  }

  public function testExceptionIsThrownShouldReturnErrorCodeUnknown()
  {
    $repository = new InMemoryTaxedRepository([]);
    $repository->throwException = true;

    $interactor = new AddMovableAssetInteractor($repository);

    $response = $interactor->execute(new AddMovableAssetRequest('AssetName', 1000, 1));
    $this->assertEquals(UsecaseResponse::$CodeUnknownError, $response->code);
  }

  public function testValidRequestShouldReturnSuccessAndCreatedAsset()
  {
    $assetCategory = new AssetCategory();
    $assetCategory->id = 1;
    $assetCategory->exists = true;

    $repository = new InMemoryTaxedRepository([$assetCategory]);
    $interactor = new AddMovableAssetInteractor($repository);

    $response = $interactor->execute(new AddMovableAssetRequest('AssetName', 1000, 1));

    $this->assertEquals(UsecaseResponse::$CodeSuccess, $response->code);
    $this->assertEquals('AssetName', $response->asset->name);
    $this->assertEquals(1000, $response->asset->price);
    $this->assertEquals(1, $response->asset->assetCategoryId);
  }
}
