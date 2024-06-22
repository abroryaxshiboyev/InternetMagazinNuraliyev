<?php

namespace App\Http\Controllers;

use App\Models\DeliveryMethod;
use App\Models\Order;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\LazyCollection;

class StatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function ordersCount(Request $request)
    {
        $from = Carbon::now()->subMonth();
        $to = Carbon::now();

        if ($request->has(['from', 'to'])) {
            $from = $request->from;
            $to = $request->to;
        }
        return $this->response(
            Order::query()
                ->whereBetween('created_at', [$from, Carbon::parse($to)->endOfDay()])
                ->whereRelation('status', 'code', '=', 'closed')
                ->count()
        );
    }

    public function ordersSalesSum(Request $request)
    {
        $from = Carbon::now()->subMonth();
        $to = Carbon::now();

        if ($request->has(['from', 'to'])) {
            $from = $request->from;
            $to = $request->to;
        }
        return $this->response(
            Order::query()
                ->whereBetween('created_at', [$from, Carbon::parse($to)->endOfDay()])
                ->whereRelation('status', 'code', '=', 'closed')
                ->sum('sum')
        );
    }

    public function deliveryMethodsRatio(Request $request)
    {
        // if(Cache::has('deliveryMethodsRatio')){
        //     return Cache::get('deliveryMethodsRatio');
        // }
        $from = Carbon::now()->subMonth();
        $to = Carbon::now();

        if ($request->has(['from', 'to'])) {
            $from = $request->from;
            $to = $request->to;
        }

        $response = [];

        $allOrders = Order::query()
            ->whereBetween('created_at', [$from, Carbon::parse($to)->endOfDay()])
            ->whereRelation('status', 'code', '=', 'closed')
            ->count();

        foreach (DeliveryMethod::all() as $deliveryMethod) {
            $deliveryMethodOrders = $deliveryMethod->orders()
                ->whereBetween('created_at', [$from, Carbon::parse($to)->endOfDay()])
                ->whereRelation('status', 'code', '=', 'closed')
                ->count();

            $response[] = [
                'name' => $deliveryMethod->getTranslations('name'),
                'percentage' => round($deliveryMethodOrders * 100 / $allOrders,1),
                'amount' => $deliveryMethodOrders
            ];
        }

        // Cache::put('deliveryMethodsRatio',$this->response($response),Carbon::now()->addDay());
        return $this->response($response);
    }

    public function ordersCountByDays(Request $request)
    {
        $from = Carbon::now()->subMonth();
        $to = Carbon::now();

        if ($request->has(['from', 'to'])) {
            $from = $request->from;
            $to = $request->to;
        }

        $days=CarbonPeriod::create($from, $to);
        $response=new Collection();

        LazyCollection::make($days->toArray())->each(function ($day) use ($response){
            // dd($day->startOfDay(),$day->endOfDay());
           $count=Order::query()
            ->whereBetween('created_at', [$day->startOfDay()->format('Y-m-d H:i:s'),$day->endOfDay()->format('Y-m-d H:i:s')])
            ->whereRelation('status', 'code', '=', 'closed')
            ->count();
            $response[] = [
                'date'=>$day->format('Y-m-d'),
                'orders_count'=>$count
            ];

        });
        

        return $this->response($response);

    }
}
