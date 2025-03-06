<?php

namespace Tests\Unit\Usecase\GetMovableAssetById;

use App\Usecase\GetMovableAssetById\GetMovableAssetByIdInteractor;
use App\Usecase\GetMovableAssetById\GetMovableAssetByIdRequest;
use App\Usecase\UsecaseResponse;
use App\Repository\Models\MovableAssetSQLiteModel;

use Tests\Unit\Repository\InMemoryTaxedRepository;
use Tests\Unit\MovableAssetTestCase;

class GetMovableAssetByIdInteractorTest extends MovableAssetTestCase
{
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
    $asset = new MovableAssetSQLiteModel();
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