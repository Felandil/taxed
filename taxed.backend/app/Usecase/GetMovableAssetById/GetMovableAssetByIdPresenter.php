<?php

namespace App\Usecase\GetMovableAssetById;

use App\Http\DTO\MovableAsset\MovableAssetDTO;
use App\Usecase\UsecasePresenter;
use App\Usecase\UsecaseResponse;
use App\Usecase\GetMovableAssetById\GetMovableAssetByIdResponse;
use Illuminate\Http\JsonResponse;

class GetMovableAssetByIdPresenter extends UsecasePresenter
{
  /**
   * @param GetMovableAssetByIdResponse $response
   * 
   * @return JsonResponse|mixed
   */
  public function presentSuccess(UsecaseResponse $response): JsonResponse
  {
    return response()->json([
      'code' => $response->code,
      'message' => $response->getMessageForCode(),
      'asset' => MovableAssetDTO::fromEntity($response->asset, $response->depreciation)
    ], 200);
  }
}