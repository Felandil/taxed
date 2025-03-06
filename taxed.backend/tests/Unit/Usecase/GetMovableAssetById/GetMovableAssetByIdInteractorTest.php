<?php

namespace Tests\Unit\Usecase\GetMovableAssetById;

use App\Entity\AssetCategory;
use App\Entity\MovableAsset;
use App\Usecase\GetMovableAssetById\GetMovableAssetByIdInteractor;
use App\Usecase\GetMovableAssetById\GetMovableAssetByIdRequest;
use App\Usecase\UsecaseResponse;

use DateTime;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Repository\InMemoryTaxedRepository;

class GetMovableAssetByIdInteractorTest extends TestCase
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
    $category = new AssetCategory(1, "", 3, 3);
    $asset = new MovableAsset(1, "SomeAsset", 100, new DateTime(), $category);

    $interactor = new GetMovableAssetByIdInteractor(new InMemoryTaxedRepository([], [$asset]));
    $response = $interactor->execute(new GetMovableAssetByIdRequest(1));

    $this->assertEquals(UsecaseResponse::CODE_SUCCESS, $response->code);
    $this->assertEquals($asset->getName(), $response->asset->getName());
    $this->assertEquals($asset->getPrice(), $response->asset->getPrice());
  }
}