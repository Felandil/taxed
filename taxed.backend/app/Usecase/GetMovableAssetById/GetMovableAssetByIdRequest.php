<?php

namespace App\Usecase\GetMovableAssetById;

class GetMovableAssetByIdRequest
{
  public $id;

  /**
   * @param int $id
   */
  public function __construct(int $id)
  {
    $this->id = $id;
  }
}