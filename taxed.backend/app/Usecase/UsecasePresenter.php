<?php

namespace App\Usecase;

use App\Usecase\UsecaseResponse;

use Illuminate\Http\JsonResponse;

abstract class UsecasePresenter
{
  /**
   * @param UsecaseResponse $response
   * 
   * @return JsonResponse|mixed
   */
  public function present(UsecaseResponse $response): JsonResponse
  {
    if ($response->code !== UsecaseResponse::CODE_SUCCESS) {
      $httpResponseCode = match ($response->code) {
        UsecaseResponse::CODE_ASSET_NOT_FOUND => 404,
        default => 400,
      };

      return response()->json(['code' => $response->code, 'message' => $response->getMessageForCode()], $httpResponseCode);
    }

    return $this->presentSuccess($response);
  }

  /**
   * @param UsecaseResponse $response
   * 
   * @return void
   */
  abstract protected function presentSuccess(UsecaseResponse $response): JsonResponse;
}