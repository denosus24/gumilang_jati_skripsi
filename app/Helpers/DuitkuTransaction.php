<?php

namespace App\Helpers;

use App\Models\Transaction;
use Exception;

class DuitkuTransaction
{
    public function createInvoice(Transaction $transaction)
    {
        $duitkuConfig = new \Duitku\Config(env('DUITKU_API_KEY'), env('DUITKU_MERCHANT_KEY'));
        $duitkuConfig->setSandboxMode(true);
        $duitkuConfig->setSanitizedMode(false);
        $duitkuConfig->setDuitkuLogs(false);
        //API key dan merchant key dari environment, atur mode sandbox, sanitized mode


        $customerDetail = [//variabel detail costumer
            'firstName'     => $transaction->user->name,
            'email'         => $transaction->user->email,
            'phone_number'  => $transaction->phone_number,
        ];

        $orderDetails   = [];
        foreach ($transaction->orders as $order) {
            $orderDetails[] = [
                'name'      => $order->package->service->name . ' / ' . $order->package->name,
                'price'     => $order->quantity * $order->amount,
                'quantity'  => $order->quantity,
            ];
        }

        $params = [ //parameter membuat invoice
            'paymentAmount'         => $transaction->amount,
            'merchantOrderId'       => $transaction->invoice_number . '_' . time(),
            'productDetails'        => 'Pembayaran ' . $transaction->invoice_number,
            'customerVaName'        => $transaction->user->name,
            'customerDetail'        => $customerDetail,
            'itemDetails'           => $orderDetails,
            'email'                 => $transaction->user->email,
            'phoneNumber'           => $transaction->phone_number,
            'expiryPeriod'          => 24 * 60 * 60,
            'returnUrl'             => route('frontpage.thankyou'),
            'callbackUrl'           => route('frontpage.duitku.callback'),
        ];

        try {
            $duitkuPop = \Duitku\Pop::createInvoice($params, $duitkuConfig);

            $duitkuResponse = json_decode($duitkuPop, true);

            $transaction->duitku_reference  = $duitkuResponse['reference'];
            $transaction->payment_url       = $duitkuResponse['paymentUrl'];
            $transaction->save();

            return $duitkuResponse;
        } catch (Exception $e) {
            dd($e->getMessage());

            return false;
        }
    }

    public function callback()
    {
        $duitkuConfig = new \Duitku\Config(env('DUITKU_API_KEY'), env('DUITKU_MERCHANT_KEY'));
        $duitkuConfig->setSandboxMode(true);
        $duitkuConfig->setSanitizedMode(false);
        $duitkuConfig->setDuitkuLogs(false);

        try {
            $callback = \Duitku\Pop::callback($duitkuConfig);

            header('Content-Type: application/json');
            $callbackResult = json_decode((string) $callback);

            if ($callbackResult->resultCode == "00") {
                $invoiceNumber = explode('_', $callbackResult['merchantOrderId'])[0];

                Transaction::where('invoice_number', $invoiceNumber)->update(['status' => 'paid']);
            } else if ($callbackResult->resultCode == "01") {
                //
            }
        } catch (Exception $e) {
            http_response_code(400);

            dd($e->getMessage());
        }
    }
}
