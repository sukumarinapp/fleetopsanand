<?php
namespace App;
use Slydepay\Order\Order;
use Slydepay\Order\OrderItem;
use Slydepay\Order\OrderItems;

class SlydepayFleetops
{

    public static function pay()
    {
        $slydepay = new Slydepay("fleetops.vantage@gmail.com", "877819");
        die;
		$orderItems = new OrderItems([
		    new OrderItem("1234", "Test Product", 10, 2),
		    new OrderItem("1284", "Test Product2", 20, 2),
		]);
		$shippingCost = 0; 
		$tax = 0;
		$order = Order::createWithId(
		    $orderItems,
		    "order_id_1", 
		    $shippingCost,
		    $tax,
		    "description",
		    "no comment"
		);
		try {
		    $response = $slydepay->processPaymentOrder($order);
		    echo $response->redirectUrl();
		} catch (Slydepay\Exception\ProcessPayment $e) {
		    echo $e->getMessage();
		}
		return view('index');
    }
}