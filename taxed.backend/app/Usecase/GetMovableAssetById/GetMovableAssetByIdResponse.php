<?php

namespace App\Usecase\GetMovableAssetById;

use App\Repository\Models\MovableAssetSQLiteModel;
use App\Usecase\UsecaseResponse;

class GetMovableAssetByIdResponse extends UsecaseResponse
{
  public ?MovableAssetSQLiteModel$asset;

  /**
   * @param int $code
   * @param ?MovableAssetSQLiteModel $asset
   */
  public function __construct(int $code, ?MovableAssetSQLiteModel $asset = null)
  {
    parent::__construct($code);

    $this->asset = $asset;
  }
}