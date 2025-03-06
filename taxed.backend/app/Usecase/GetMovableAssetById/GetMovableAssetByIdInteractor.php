<?php

namespace App\Usecase\GetMovableAssetById;

use App\Repository\ITaxedRepository;
use App\Usecase\GetMovableAssetById\GetMovableAssetByIdRequest;
use App\Usecase\GetMovableAssetById\GetMovableAssetByIdResponse;
use App\Usecase\UsecaseResponse;
use Exception;

class GetMovableAssetByIdInteractor
{
  private $repository;

  /**
   * @param \App\Repository\ITaxedRepository $repository
   */
  public function __construct(ITaxedRepository $repository)
  {
    $this->repository = $repository;
  }

  public function execute(GetMovableAssetByIdRequest $request): GetMovableAssetByIdResponse
  {
    try {
      $asset = $this->repository->getMovableAssetById($request->id);
      if (!$asset) {
        return new GetMovableAssetByIdResponse(UsecaseResponse::CODE_ASSET_NOT_FOUND);
      }

      return new GetMovableAssetByIdResponse(UsecaseResponse::CODE_SUCCESS, $asset);
    } catch (Exception $e) {
      echo $e;
      return new GetMovableAssetByIdResponse(UsecaseResponse::CODE_UNKNOWN_ERROR);
    }
  }
}