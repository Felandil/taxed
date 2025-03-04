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
   *     summary="Lädt alle Anlagegüter",
   *     @OA\Response(
   *         response=200,
   *         description="Anlagegüter erfolgreich geladen"
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
   *     summary="Lädt ein Anlagegut anhand seiner Id",
   *       @OA\Parameter(
   *         name="id",
   *         in="path",
   *         description="ID des abzurufenden Anlageguts",
   *         required=true,
   *         @OA\Schema(
   *             type="integer",
   *             example=1
   *         )
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Anlagegut erfolgreich geladen"
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="Anlagegut nicht gefunden"
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
