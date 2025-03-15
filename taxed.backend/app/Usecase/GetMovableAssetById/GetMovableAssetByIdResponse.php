<?php

namespace App\Usecase\GetMovableAssetById;

use App\Entity\MovableAsset;
use App\Entity\DepreciationPeriod;
use App\Usecase\UsecaseResponse;

class GetMovableAssetByIdResponse extends UsecaseResponse
{
  /**
   * @var ?MovableAsset
   */
  public ?MovableAsset $asset;

  /**
   * @var ?DepreciationPeriod[]
   */
  public ?array $depreciation;

  /**
   * @param int $code
   * @param ?MovableAsset $asset
   * @param ?DepreciationPeriod[]
   */
  public function __construct(int $code, ?MovableAsset $asset = null, ?array $depreciation = null)
  {
    parent::__construct($code);

    $this->asset = $asset;
    $this->depreciation = $depreciation;
  }
}