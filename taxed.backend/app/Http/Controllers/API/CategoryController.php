<?php

namespace App\Http\Controllers\API;

use Illuminate\Routing\Controller;
use App\Models\AssetCategory;
use App\Http\DTO\AssetCategoryResponse;

class CategoryController extends Controller
{
  /**
   * @OA\Get(
   *     path="/api/categories",
   *     summary="Loads all asset categories",
   *     @OA\Response(
   *         response=200,
   *         description="Asset categories loaded successfully"
   *     )
   * )
   */
  public function getAll()
  {
    $categories = AssetCategory::with('categories')
      ->whereNull('parent_id')
      ->get();

    $mapped = $categories->map(function ($cat) {
      return AssetCategoryResponse::fromModel($cat);
    });

    return response()->json($mapped);
  }

  /**
   * @OA\Get(
   *     path="/api/categories/{id}",
   *     summary="Loads an asset category by its ID",
   *       @OA\Parameter(
   *         name="id",
   *         in="path",
   *         description="ID of the category to load",
   *         required=true,
   *         @OA\Schema(
   *             type="integer",
   *             example=1
   *         )
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Asset category successfully loaded"
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="Asset category not found"
   *     )
   * )
   */
  public function get($id)
  {
    $category = AssetCategory::find($id);

    if (!$category) {
      return response()->json(['error' => 'Kategorie nicht gefunden'], 404);
    }

    return response()->json(AssetCategoryResponse::fromModel($category));
  }
}
