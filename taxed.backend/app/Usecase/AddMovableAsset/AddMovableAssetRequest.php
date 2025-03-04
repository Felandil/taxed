<?php

namespace App\Usecase\AddMovableAsset;

class AddMovableAssetRequest
{
    public string $name;
    public float $price;
    public int $assetCategoryId;

    public function __construct(string $name, float $price, int $assetCategoryId)
    {
        $this->name = $name;
        $this->price = $price;
        $this->assetCategoryId = $assetCategoryId;
    }
}