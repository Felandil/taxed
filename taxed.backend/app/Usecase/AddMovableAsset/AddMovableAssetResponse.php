<?php

namespace App\Usecase\AddMovableAsset;

use App\Usecase\UsecaseResponse;
use App\Repository\Models\MovableAssetSQLiteModel;

class AddMovableAssetResponse extends UsecaseResponse
{
  public ?MovableAssetSQLiteModel $asset;

  /**
   * @param int $code
   * @param mixed $asset
   */
  public function __construct(int $code, ?MovableAssetSQLiteModel $asset = null)
  {
    parent::__construct($code);

    $this->asset = $asset;
  }
}