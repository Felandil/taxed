<?php

namespace App\Usecase\AddMovableAsset;

use App\Usecase\AddMovableAsset\AddMovableAssetRequest;
use App\Usecase\UsecaseResponse;
use App\Repository\ITaxedRepository;
use App\Usecase\Exceptions\UsecaseException;

class AddMovableAssetInteractor
{
  private $repository;

  public function __construct(ITaxedRepository $repository)
  {
    $this->repository = $repository;
  }

  public function execute(AddMovableAssetRequest $request): AddMovableAssetResponse
  {
    try 
    {
      $this->validateRequest($request);

      $asset = $this->repository->addMovableAsset($request->name, $request->price, $request->assetCategoryId);

      return new AddMovableAssetResponse(UsecaseResponse::$CodeSuccess, $asset);
    }
    catch (UsecaseException $e)
    {
      return new AddMovableAssetResponse($e->getCode());
    }
    catch (\Exception $e)
    {
      // TODO: add logging
      echo($e->getMessage());

      return new AddMovableAssetResponse(UsecaseResponse::$CodeUnknownError);
    }
  }

  private function validateRequest(AddMovableAssetRequest $request)
  {
    if (empty($request->name)) {
      throw new UsecaseException(UsecaseResponse::$CodeInvalidAssetName);
    }

    if ($request->price <= 0) {
      throw new UsecaseException(UsecaseResponse::$CodeInvalidAssetPrice);
    }

    if ($request->assetCategoryId <= 0) {
      throw new UsecaseException(UsecaseResponse::$CodeInvalidAssetCategory);
    }

    $category = $this->repository->getMovableAssetCategoryById($request->assetCategoryId);
    if ($category == null) {
      throw new UsecaseException(UsecaseResponse::$CodeInvalidAssetCategory);
    }
  }
}
