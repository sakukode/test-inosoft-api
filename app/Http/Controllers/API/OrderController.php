<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Exceptions\OutOfStockException;
use App\Http\Requests\Orders\StoreOrderRequest;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * The order repository instance.
     *
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * Create a new OrderController instance.
     *
     * @param  OrderRepositoryInterface  $orderRepository
     * @return void
     */
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $this->orderRepository->create($validated);

            return $this->generateResponse(
                'success',
                'Order placed successfully',
                Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            $statusCode = Response::HTTP_BAD_REQUEST;

            if ($e instanceof OutOfStockException || $e instanceof RecordsNotFoundException) {
                $statusCode = Response::HTTP_NOT_FOUND;
            }

            return $this->generateResponse(
                'failed',
                $e->getMessage(),
                $statusCode
            );
        }
    }
}
