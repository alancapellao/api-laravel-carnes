<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarneRequest;
use App\Services\Interfaces\CarneService;
use App\Http\Resources\Carne\CarneIndexResource;
use App\Http\Resources\Carne\CarneStoreResource;
use App\Http\Resources\Carne\CarneShowResource;
use Illuminate\Http\JsonResponse;

class CarnesController extends Controller
{
    private CarneService $carneService;

    public function __construct(CarneService $carneService)
    {
        $this->carneService = $carneService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $carnes = $this->carneService->getAllCarnes();
            return response()->json(CarneIndexResource::collection($carnes), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarneRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $carne = $this->carneService->createCarne($data);
            return response()->json(new CarneStoreResource($carne), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $carne = $this->carneService->getCarneById($id);

            if (!$carne) {
                return response()->json(['message' => 'Carnê não encontrado'], 404);
            }

            return response()->json(new CarneShowResource($carne), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
