<?php

namespace App\Usecase\AddMovableAsset;

use App\Usecase\AddMovableAsset\AddMovableAssetResponse;
use App\Usecase\UsecaseResponse;

use Illuminate\Http\JsonResponse;

class AddMovableAssetPresenter
{
  public static function present(AddMovableAssetResponse $response): JsonResponse
  {
    if ($response->code !== UsecaseResponse::CODE_SUCCESS) {
      return response()->json(['code' => $response->code, 'message' => $response->getMessageForCode()], 400);
    }

    $locationUrl = route('asset.get', ['id' => $response->asset->id]);

    return response()->json([
      'code' => $response->code,
      'message' => $response->getMessageForCode(),
      'asset' => $response->asset
    ], 201)->header('Location', $locationUrl);
  }
}