<?php

namespace App\Http\DTO;

class AssetCategoryResponse
{
    public int $id;
    public ?string $code;
    public string $name;
    public ?int $useful_life;
    public ?float $depreciation_rate;

    /** @var AssetCategoryResponse[] */
    public ?array $categories = [];

    public function __construct(
        int $id,
        ?string $code,
        string $name,
        ?int $useful_life = null,
        ?float $depreciation_rate = null,
        array $categories = []
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;

        if ($useful_life !== null) {
          $this->useful_life = $useful_life;
        }

        if ($depreciation_rate !== null) {
            $this->depreciation_rate = $depreciation_rate;
        }

        if (count($categories) > 0) {
          $this->categories = $categories;
        }
    }

    /**
     * Erzeugt ein DTO aus einem AssetCategory-Model.
     */
    public static function fromModel($model): self
    {
        $children = [];
        if ($model->relationLoaded('categories')) {
            foreach ($model->categories as $child) {
                $children[] = self::fromModel($child);
            }
        }
        return new self(
            $model->id,
            $model->code,
            $model->name,
            $model->useful_life,
            $model->depreciation_rate,
            $children
        );
    }
}
