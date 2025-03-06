<?php

namespace App\Usecase\AddMovableAsset;

use App\Usecase\AddMovableAsset\AddMovableAssetResponse;
use App\Usecase\UsecasePresenter;
use App\Usecase\UsecaseResponse;

use Illuminate\Http\JsonResponse;

class AddMovableAssetPresenter extends UsecasePresenter
{
  /**
   * @param AddMovableAssetResponse $response
   * 
   * @return JsonResponse|mixed
   */
  protected function presentSuccess(UsecaseResponse $response): JsonResponse
  {
    $locationUrl = route('asset.get', ['id' => $response->asset->id]);

    return response()->json([
      'code' => $response->code,
      'message' => $response->getMessageForCode(),
      'asset' => $response->asset
    ], 201)->header('Location', $locationUrl);
  }
}