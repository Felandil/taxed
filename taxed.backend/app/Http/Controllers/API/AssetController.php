<?php

namespace App\Http\Controllers\API;

use App\Models\MovableAsset;
use App\Repository\TaxedSQLiteRepository;

use App\Usecase\AddMovableAsset\AddMovableAssetInteractor;
use App\Usecase\AddMovableAsset\AddMovableAssetRequest;
use App\Usecase\AddMovableAsset\AddMovableAssetPresenter;

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
     *     summary="Adds a new movable asset",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","price"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="price", type="number", format="float"),
     *             @OA\Property(property="categoryId", type="number", format="int")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Movables asset created successfully"
     *     ),
     *    @OA\Response(
     *         response=400,
     *         description="Movables asset could not be created, see response body for details"
     *     )
     * )
     */
    public function add(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'categoryId' => 'required|numeric'
            ]);

            $interactor = new AddMovableAssetInteractor($this->repository);
            $response = $interactor->execute(new AddMovableAssetRequest($data['name'], (float) $data['price'], (int) $data['categoryId']));

            return AddMovableAssetPresenter::present($response);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/assets/{id}",
     *     summary="Loads a movable asset by its ID",
     *       @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the asset to load",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movable asset successfully loaded"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Movable asset not found"
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
     *     summary="Loads all movable assets",
     *     @OA\Response(
     *         response=200,
     *         description="Movables assets successfully loaded"
     *     )
     * )
     */
    public function getAll()
    {
        $assets = MovableAsset::all();
        return response()->json($assets);
    }
}
