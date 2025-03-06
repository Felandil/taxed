<?php

namespace Tests\Unit\Usecase\GetMovableAssetById;

use Illuminate\Database\Connection;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Database\Query\Processors\Processor;

use App\Usecase\GetMovableAssetById\GetMovableAssetByIdInteractor;
use App\Usecase\GetMovableAssetById\GetMovableAssetByIdRequest;
use App\Usecase\UsecaseResponse;

use PHPUnit\Framework\TestCase;

use App\Models\AssetCategory;
use App\Models\MovableAsset;

use Tests\Unit\Repository\InMemoryTaxedRepository;
use Tests\Unit\Repository\DummyConnectionResolver;

use Mockery;

class GetMovableAssetByIdInteractorTest extends TestCase
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

  public function testAssetWithIdDoesNotExistShouldReturnErrorCodeAssetNotFound()
  {
    $interactor = new GetMovableAssetByIdInteractor(new InMemoryTaxedRepository([], []));
    $response = $interactor->execute(new GetMovableAssetByIdRequest(1));

    $this->assertEquals(UsecaseResponse::CODE_ASSET_NOT_FOUND, $response->code);
  }

  public function testRepositoryThrowsExceptionShouldReturnErrorCodeUnkownError()
  {
    $repository = new InMemoryTaxedRepository([], []);
    $repository->throwException = true;

    $interactor = new GetMovableAssetByIdInteractor($repository);
    $response = $interactor->execute(new GetMovableAssetByIdRequest(1));

    $this->assertEquals(UsecaseResponse::CODE_UNKNOWN_ERROR, $response->code);
  }

  public function testAssetExistsShouldReturnAssetAndCodeSuccess()
  {
    $asset = new MovableAsset();
    $asset->exists = true;
    $asset->id = 1;
    $asset->name = 'SomeAsset';
    $asset->price = 100;

    $interactor = new GetMovableAssetByIdInteractor(new InMemoryTaxedRepository([], [$asset]));
    $response = $interactor->execute(new GetMovableAssetByIdRequest(1));

    $this->assertEquals(UsecaseResponse::CODE_SUCCESS, $response->code);
    $this->assertEquals($asset->name, $response->asset->name);
    $this->assertEquals($asset->price, $response->asset->price);
  }
}