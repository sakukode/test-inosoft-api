<?php

namespace App\Http\Controllers\API;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Vehicles\OrderReportCollection;
use App\Repositories\Interfaces\VehicleRepositoryInterface;

class OrderReportController extends Controller
{
    /**
     * The order repository instance.
     *
     * @var VehicleRepositoryInterface
     */
    protected $vehicleRepository;

    /**
     * Create a new OrderReportController instance.
     *
     * @param  VehicleRepositoryInterface  $vehicleRepository
     * @return void
     */
    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * Get the order reports for a given vehicle ID.
     *
     * @param  string   $id       The vehicle ID.
     * @param  Request  $request  The request object.
     * @return JsonResponse|OrderReportCollection  The JSON response or collection of order reports.
     */
    public function index(string $id, Request $request): JsonResponse|OrderReportCollection
    {
        try {
            $startDate = $request->query('start_date', null);
            $endDate = $request->query('end_date', null);
            $result = $this->vehicleRepository->getOrderReportsById($id, $startDate, $endDate);

            return new OrderReportCollection($result);
        } catch (Exception $e) {

            return $this->generateResponse(
                'failed',
                $e->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
