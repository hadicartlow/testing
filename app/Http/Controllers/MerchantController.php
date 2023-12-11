<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Affiliate;
use App\Models\User;
use App\Services\MerchantService;
use App\Services\OrderStateService;
use App\Services\AffiliateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\OrderStatsService;

class MerchantController extends Controller
{
    public function __construct(
        MerchantService $merchantService
    ) {}

    /**
     * Useful order statistics for the merchant API.
     * 
     * @param Request $request Will include a from and to date
     * @return JsonResponse Should be in the form {count: total number of orders in range, commission_owed: amount of unpaid commissions for orders with an affiliate, revenue: sum order subtotals}
     */
    public function orderStats(Request $request, Merchant $merchant, OrderStatsService $orderStatsService)
    {
        
        $orderStats = $orderStatsService->getOrderStats($request, $merchant);

        return $orderStats;
    }

    public function updateUser(Request $request, UserRegistrationService $userRegistrationService, User $user)
    {
        $userData = $request->all(); // Adjust this based on your actual request data

        $userRegistrationService->updateUser($userData, $user);

        return response()->json(['message' => 'User updated successfully']);
    }

    public function registerUserAndMerchant(Request $request, UserRegistrationService $userRegistrationService)
    {
        $userData = $request->all(); // Adjust this based on your actual request data

        $merchant = $userRegistrationService->registerUserAndMerchant($userData);

        return response()->json(['message' => 'User and merchant registered successfully', 'merchant' => $merchant]);
    }

    public function findMerchantByEmail(Request $request, UserRegistrationService $userRegistrationService)
    {
        $email = $request->input('email'); // Adjust this based on your actual request data

        $merchant = $userRegistrationService->findMerchantByEmail($email);

        if ($merchant) {
            return response()->json(['message' => 'Merchant found', 'merchant' => $merchant]);
        } else {
            return response()->json(['message' => 'Merchant not found'], 404);
        }
    }

    public function payoutAffiliateOrders(Affiliate $affiliate, MarchantService $marchantService)
    {
        $marchantService->payoutAffiliateOrders($affiliate);

        return response()->json(['message' => 'Payout initiated successfully']);
    }
    
     public function createAffiliate(Request $request, Merchant $merchant, AffiliateService $affiliateService)
    {
        $email = $request->input('email');
        $name = $request->input('name');
        $commissionRate = $request->input('commission_rate'); // Adjust this based on your request data

        $affiliate = $affiliateService->createAffiliate($merchant, $email, $name, $commissionRate);

        return response()->json(['message' => 'Affiliate created successfully', 'affiliate' => $affiliate]);
    }
}
