<?php

namespace App\Usecase\AddMovableAsset;

use App\Usecase\AddMovableAsset\AddMovableAssetRequest;
use App\Usecase\UsecaseResponse;
use App\Repository\ITaxedRepository;
use App\Usecase\Exceptions\UsecaseException;

/**
 * Adds a movable asset
 */
class AddMovableAssetInteractor
{
  private $repository;

  /**
   * @param \App\Repository\ITaxedRepository $repository
   */
  public function __construct(ITaxedRepository $repository)
  {
    $this->repository = $repository;
  }

  /**
   * @param \App\Usecase\AddMovableAsset\AddMovableAssetRequest $request
   * 
   * @return AddMovableAssetResponse
   */
  public function execute(AddMovableAssetRequest $request): AddMovableAssetResponse
  {
    try {
      $this->validateRequest($request);

      $asset = $this->repository->addMovableAsset($request->name, $request->price, $request->assetCategoryId);

      return new AddMovableAssetResponse(UsecaseResponse::CODE_SUCCESS, $asset);
    } catch (UsecaseException $e) {
      return new AddMovableAssetResponse($e->getCode());
    } catch (\Exception $e) {
      return new AddMovableAssetResponse(UsecaseResponse::CODE_UNKNOWN_ERROR);
    }
  }

  /**
   * @param \App\Usecase\AddMovableAsset\AddMovableAssetRequest $request
   * 
   * @throws \App\Usecase\Exceptions\UsecaseException
   * 
   * @return void
   */
  private function validateRequest(AddMovableAssetRequest $request)
  {
    if (empty($request->name) || strlen($request->name) < 3) {
      throw new UsecaseException(UsecaseResponse::CODE_INVALID_ASSET_NAME);
    }

    if ($request->price <= 0) {
      throw new UsecaseException(UsecaseResponse::CODE_INVALID_ASSET_PRICE);
    }

    if ($request->assetCategoryId <= 0) {
      throw new UsecaseException(UsecaseResponse::CODE_INVALID_ASSET_CATEGORY);
    }

    $category = $this->repository->getMovableAssetCategoryById($request->assetCategoryId);
    if ($category == null) {
      throw new UsecaseException(UsecaseResponse::CODE_INVALID_ASSET_CATEGORY);
    }
  }
}
