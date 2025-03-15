<?php

namespace App\Usecase\GetMovableAssetById;

use App\Repository\ITaxedRepository;
use App\Services\IDepreciationCalculator;
use App\Usecase\GetMovableAssetById\GetMovableAssetByIdRequest;
use App\Usecase\GetMovableAssetById\GetMovableAssetByIdResponse;
use App\Usecase\UsecaseResponse;
use Exception;

class GetMovableAssetByIdInteractor
{
  /**
   * @var ITaxedRepository
   */
  private $repository;

  /**
   * @var IDepreciationCalculator
   */
  private $depreciationCalculator;

  /**
   * @param ITaxedRepository $repository
   */
  public function __construct(ITaxedRepository $repository, IDepreciationCalculator $depreciationCalculator)
  {
    $this->repository = $repository;
    $this->depreciationCalculator = $depreciationCalculator;
  }

  public function execute(GetMovableAssetByIdRequest $request): GetMovableAssetByIdResponse
  {
    try {
      $asset = $this->repository->getMovableAssetById($request->id);
      if (!$asset) {
        return new GetMovableAssetByIdResponse(UsecaseResponse::CODE_ASSET_NOT_FOUND);
      }

      $depreciation = $this->depreciationCalculator->calculateDepreciation($asset);

      return new GetMovableAssetByIdResponse(UsecaseResponse::CODE_SUCCESS, $asset, $depreciation);
    } catch (Exception $e) {
      return new GetMovableAssetByIdResponse(UsecaseResponse::CODE_UNKNOWN_ERROR);
    }
  }
}