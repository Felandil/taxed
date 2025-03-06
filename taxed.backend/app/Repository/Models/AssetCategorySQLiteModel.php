<?php

namespace App\Repository\Models;

use Illuminate\Database\Eloquent\Model;

class AssetCategorySQLiteModel extends Model
{
    protected $table = 'asset_categories';

    protected $fillable = [
        'code',
        'name',
        'useful_life',
        'depreciation_rate',
        'parent_id'
    ];

    public function parent()
    {
        return $this->belongsTo(AssetCategorySQLiteModel::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(AssetCategorySQLiteModel::class, 'parent_id');
    }

    public function categories()
    {
        return $this->children()->with('categories');
    }
}
