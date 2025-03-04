<?php

namespace App\Http\Controllers\API;

use App\Models\MovableAsset;
use App\Repository\TaxedSQLiteRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AssetController extends Controller
{
    private $repository;

    public function __construct(TaxedSQLiteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Post(
     *     path="/api/assets",
     *     summary="Fügt ein neues bewegliches Gut hinzu",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","price"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="price", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Bewegliches Gut erfolgreich hinzugefügt"
     *     )
     * )
     */
    public function add(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'categoryId' => 'required|numeric'
        ]);

        $asset = $this->repository->addMovableAsset($data['name'], (float) $data['price'], (int) $data['categoryId']);
        $locationUrl = route('asset.get', ['id' => $asset->id]);

        return response()->json([
            'asset' => $asset
        ], 201)->header('Location', $locationUrl);
    }

    /**
     * @OA\Get(
     *     path="/api/assets/{id}",
     *     summary="Lädt ein bewegliches Gut anhand seiner Id",
     *       @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID des abzurufenden beweglichen Guts",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bewegliches Gut erfolgreich geladen"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bewegliches Gut nicht gefunden"
     *     )
     * )
     */
    public function get(int $id)
    {
        $asset = MovableAsset::find($id);

        if (!$asset) {
            return response()->json(['message' => 'Asset not found'], 404);
        }

        return response()->json($asset);
    }

    /**
     * @OA\Get(
     *     path="/api/assets",
     *     summary="Lädt alle beweglichen Güter",
     *     @OA\Response(
     *         response=200,
     *         description="Bewegliche Güter erfolgreich geladen"
     *     )
     * )
     */
    public function getAll()
    {
        $assets = MovableAsset::all();
        return response()->json($assets);
    }
}
