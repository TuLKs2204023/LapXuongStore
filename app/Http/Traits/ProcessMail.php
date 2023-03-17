<?php

namespace App\Http\Traits;

use App\Mail\OrderCancel;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use App\Models\Order;

trait ProcessMail 
{
    function completeOrder(Order $order)
    {
        $message = new OrderConfirmation($order);
        Mail::to($order->email)->send($message);
    }

    function cancelOrder(Order $order){
        $message = new OrderCancel($order);
        Mail::to($order->email)->send($message);
    }
}
