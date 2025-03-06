<?php

namespace App\Usecase\GetMovableAssetById;

use App\Entity\MovableAsset;
use App\Usecase\UsecaseResponse;

class GetMovableAssetByIdResponse extends UsecaseResponse
{
  public ?MovableAsset $asset;

  /**
   * @param int $code
   * @param ?MovableAsset $asset
   */
  public function __construct(int $code, ?MovableAsset $asset = null)
  {
    parent::__construct($code);

    $this->asset = $asset;
  }
}