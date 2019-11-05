<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\Order;

class IndexController extends Controller
{
    function getIndex()
    {
        $year=Carbon::now()->format('Y');
        $month=Carbon::now()->format('m');
        for($i=1; $i<= $month; $i++)
        {
            $dl['Tháng'.$i]=Order::where('state',1)->whereMonth('updated_at',$i)->whereYear('updated_at',$year)->sum('total');
        }
        $data['dl']=$dl;
        $data['month']=$month;
        $data['order']=Order::where('state',1)->whereMonth('updated_at',$month)->whereYear('updated_at',$year);
        return view('backend.index',$data);
    }

    function Logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
