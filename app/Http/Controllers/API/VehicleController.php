<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Vehicles\VehicleResource;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use Illuminate\Http\JsonResponse;

class VehicleController extends Controller
{
    /**
     * The vehicle repository instance.
     *
     * @var VehicleRepositoryInterface
     */
    protected $vehicleRepository;

    /**
     * Create a new VehicleController instance.
     *
     * @param  VehicleRepositoryInterface  $vehicleRepository
     * @return void
     */
    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * Show a specific vehicle.
     *
     * @param  string  $id  The ID of the vehicle.
     * @return JsonResponse|VehicleResource  The JSON response or vehicle resource.
     */
    public function show(string $id): JsonResponse | VehicleResource
    {
        try {
            $result = $this->vehicleRepository->findById($id);

            return new VehicleResource($result);
        } catch (Exception $e) {
            return $this->generateResponse(
                'failed',
                'Vehicle not found',
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
