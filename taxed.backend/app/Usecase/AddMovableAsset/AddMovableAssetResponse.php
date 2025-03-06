<?php

namespace App\Usecase\AddMovableAsset;

use App\Usecase\UsecaseResponse;
use App\Repository\Models\MovableAsset;

class AddMovableAssetResponse extends UsecaseResponse
{
  public ?MovableAsset $asset;

  /**
   * @param int $code
   * @param mixed $asset
   */
  public function __construct(int $code, ?MovableAsset $asset = null)
  {
    parent::__construct($code);

    $this->asset = $asset;
  }
}