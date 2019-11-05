<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    function getOrder()
    {
        $data['orders']=Order::where('state',0)->get();
        return view('backend.order.order',$data);
    }

    function getDetailOrder($id)
    {
        $data['order']=Order::find($id);
        return view('backend.order.detailorder',$data);
    }

    function getProcessedOrder()
    {
        $data['orders']=Order::where('state',1)->get();
        return view('backend.order.processed',$data);
    }
    function xuly($id)
    {
        $order = Order::find($id);
        $order->state=1;
        $order->save();

        return redirect('admin/order/processed');

    }
}
