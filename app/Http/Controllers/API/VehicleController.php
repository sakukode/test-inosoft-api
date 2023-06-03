<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Vehicles\VehicleResource;
use App\Repositories\Interfaces\VehicleRepositoryInterface;

class VehicleController extends Controller
{
    protected $vehicleRepository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        try {
            $result = $this->vehicleRepository->findById($id);

            return new VehicleResource($result);
        } catch(Exception $e) {
            return $this->generateResponse('failed', 
                'Vehicle not found', 
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
