<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriptionController extends Controller
{
    private array $allowedStatuses = ['active', 'inactive', 'trial', 'isolir', 'dismantle'];

    public function index(Request $request): JsonResponse
    {
        $status = $request->query("status");
        $customerId = $request->query("customer_id");
        
        $query = Subscription::query()->with(['customer', 'service']);

        if ($status !== null) {
            if (!in_array($status, $this->allowedStatuses, true)) {
                return response()->json([
                    "success" => false,
                    "message" => "Validation failed",
                    "errors" => [
                        "status" => ["The selected status is invalid."],
                    ],
                ], 422);
            }
            $query->where("status", $status);
        }

        if ($customerId !== null) {
            $query->where("customer_id", (int) $customerId);
        }

        $subscriptions = $query->latest()->get();

        return response()->json([
            "success" => true,
            "message" => "Subscriptions retrieved successfully",
            "data" => $subscriptions,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            "customer_id" => ["required", "integer", "exists:customers,id"],
            "service_id" => ["required", "integer", "exists:services,id"],
            "start_date" => ["nullable", "date"],
            "end_date" => ["nullable", "date", "after_or_equal:start_date"],
            "status" => ["required", "string", Rule::in($this->allowedStatuses)],
        ]);

        $subscription = Subscription::query()->create($data);
        
        $subscription->load(['customer', 'service']);

        return response()->json([
            "success" => true,
            "message" => "Subscription created successfully",
            "data" => $subscription,
        ], 201);
    }

    public function show(int $subscription): JsonResponse
    {
        $subscriptionObj = Subscription::query()->with(['customer', 'service'])->find($subscription);

        if (!$subscriptionObj) {
            return response()->json([
                "success" => false,
                "message" => "Subscription not found",
                "errors" => [],
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Subscription retrieved successfully",
            "data" => $subscriptionObj,
        ]);
    }

    public function update(Request $request, int $subscription): JsonResponse
    {
        $subscriptionObj = Subscription::query()->find($subscription);

        if (!$subscriptionObj) {
            return response()->json([
                "success" => false,
                "message" => "Subscription not found",
                "errors" => [],
            ], 404);
        }

        if ($subscriptionObj->status === 'dismantle') {
            return response()->json([
                "success" => false,
                "message" => "Validation failed",
                "errors" => [
                    "status" => ["Cannot update a subscription that has already been dismantled."],
                ],
            ], 422);
        }

        $data = $request->validate([
            "customer_id" => ["sometimes", "integer", "exists:customers,id"],
            "service_id" => ["sometimes", "integer", "exists:services,id"],
            "start_date" => ["nullable", "date"],
            "end_date" => ["nullable", "date", "after_or_equal:start_date"],
            "status" => ["sometimes", "string", Rule::in($this->allowedStatuses)],
        ]);

        $subscriptionObj->update($data);
        $subscriptionObj->load(['customer', 'service']);

        return response()->json([
            "success" => true,
            "message" => "Subscription updated successfully",
            "data" => $subscriptionObj,
        ]);
    }

    public function destroy(int $subscription): JsonResponse
    {
        $subscriptionObj = Subscription::query()->find($subscription);

        if (!$subscriptionObj) {
            return response()->json([
                "success" => false,
                "message" => "Subscription not found",
                "errors" => [],
            ], 404);
        }

        $subscriptionObj->delete();

        return response()->json([
            "success" => true,
            "message" => "Subscription deleted successfully",
            "data" => null,
        ]);
    }
}