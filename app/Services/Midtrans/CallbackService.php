<?php
 
namespace App\Services\Midtrans;

use App\Models\Head;
use App\Models\Order;
use App\Services\Midtrans\Midtrans;
use Midtrans\Notification;
 
class CallbackService extends Midtrans
{
    protected $notification;
    protected $order;
    protected $serverKey;
 
    public function __construct()
    {
        parent::__construct();
 
        $this->serverKey = config('midtrans.server_key');
        $this->_handleNotification();
    }
 
    public function isSignatureKeyVerified()
    {
        return ($this->_createLocalSignatureKey() == $this->notification->signature_key);
    }
 
    public function isSuccess()
    {
        $statusCode = $this->notification->status_code;
        $transactionStatus = $this->notification->transaction_status;
        $fraudStatus = !empty($this->notification->fraud_status) ? ($this->notification->fraud_status == 'accept') : true;
 
        return ($statusCode == 200 && $fraudStatus && ($transactionStatus == 'capture' || $transactionStatus == 'settlement'));
    }
 
    public function isExpire()
    {
        return ($this->notification->transaction_status == 'expire');
    }
 
    public function isCancelled()
    {
        return ($this->notification->transaction_status == 'cancel');
    }
 
    public function getNotification()
    {
        return $this->notification;
    }
 
    public function getHead()
    {
        return $this->head;
    }
 
    protected function _createLocalSignatureKey()
    {
        return hash('sha512',
            $this->notification->order_id . $this->notification->status_code .
            $this->notification->gross_amount . $this->serverKey);
    }
 
    protected function _handleNotification()
    {
        $notification = new Notification();
 
        // $transactionId = $notification->transaction_id;
        $orderNumber = $notification->order_id;
        // $order = Order::where('number', $orderNumber)->get();
        // cari snap token
        // cari semua order yang memiliki snap token yang sama
        // masukan ke var orders
        // return $orders = Order::where('snap_token', $order->snap_token)->get();
        $head = Head::where('number', $orderNumber)->first();
 
        $this->notification = $notification;
        $this->head = $head;
    }
}