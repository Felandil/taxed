<?php

namespace Tests\Unit\Usecase\AddMovableAsset;

use App\Entity\AssetCategory;
use App\Usecase\AddMovableAsset\AddMovableAssetInteractor;
use App\Usecase\AddMovableAsset\AddMovableAssetRequest;
use App\Usecase\UsecaseResponse;

use PHPUnit\Framework\TestCase;
use Tests\Unit\Repository\InMemoryTaxedRepository;

class AddMovableAssetInteractorTest extends TestCase
{
  public function testCategoryIdSmallerOrEqualZeroShouldReturnErrorCodeInvalidAssetCategory()
  {
    $interactor = new AddMovableAssetInteractor(new InMemoryTaxedRepository([], []));

    $response = $interactor->execute(new AddMovableAssetRequest('AssetName', 1000, 0));
    $this->assertEquals(UsecaseResponse::CODE_INVALID_ASSET_CATEGORY, $response->code);

    $response = $interactor->execute(new AddMovableAssetRequest('AssetName', 1000, -1));
    $this->assertEquals(UsecaseResponse::CODE_INVALID_ASSET_CATEGORY, $response->code);
  }

  public function testEmptyNameShouldReturnErrorCodeInvalidAssetName()
  {
    $interactor = new AddMovableAssetInteractor(new InMemoryTaxedRepository([], []));

    $response = $interactor->execute(new AddMovableAssetRequest('', 1000, 1));
    $this->assertEquals(UsecaseResponse::CODE_INVALID_ASSET_NAME, $response->code);
  }

  public function testNameTooShortShouldReturnErrorCodeInvalidAssetName()
  {
    $interactor = new AddMovableAssetInteractor(new InMemoryTaxedRepository([], []));

    $response = $interactor->execute(new AddMovableAssetRequest('Te', 1000, 1));
    $this->assertEquals(UsecaseResponse::CODE_INVALID_ASSET_NAME, $response->code);
  }

  public function testPriceSmallerOrEqualZeroShouldReturnErrorCodeInvalidAssetPrice()
  {
    $interactor = new AddMovableAssetInteractor(new InMemoryTaxedRepository([], []));

    $response = $interactor->execute(new AddMovableAssetRequest('AssetName', 0, 1));
    $this->assertEquals(UsecaseResponse::CODE_INVALID_ASSET_PRICE, $response->code);

    $response = $interactor->execute(new AddMovableAssetRequest('AssetName', -1, 1));
    $this->assertEquals(UsecaseResponse::CODE_INVALID_ASSET_PRICE, $response->code);
  }

  public function testAssetCategoryDoesNotExistShouldReturnErrorCodeInvalidAssetCategory()
  {
    $interactor = new AddMovableAssetInteractor(new InMemoryTaxedRepository([], []));

    $response = $interactor->execute(new AddMovableAssetRequest('AssetName', 1000, 100));
    $this->assertEquals(UsecaseResponse::CODE_INVALID_ASSET_CATEGORY, $response->code);
  }

  public function testExceptionIsThrownShouldReturnErrorCodeUnknown()
  {
    $repository = new InMemoryTaxedRepository([], []);
    $repository->throwException = true;

    $interactor = new AddMovableAssetInteractor($repository);

    $response = $interactor->execute(new AddMovableAssetRequest('AssetName', 1000, 1));
    $this->assertEquals(UsecaseResponse::CODE_UNKNOWN_ERROR, $response->code);
  }

  public function testValidRequestShouldReturnSuccessAndCreatedAsset()
  {
    $assetCategory = new AssetCategory(1, "", 3, 3);
    $repository = new InMemoryTaxedRepository([$assetCategory], []);
    $interactor = new AddMovableAssetInteractor($repository);

    $response = $interactor->execute(new AddMovableAssetRequest('AssetName', 1000, 1));

    $this->assertEquals(UsecaseResponse::CODE_SUCCESS, $response->code);
    $this->assertEquals('AssetName', $response->asset->getName());
    $this->assertEquals(1000, $response->asset->getPrice());
    $this->assertEquals(1, $response->asset->getCategory()->getId());
  }
}
