<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayController extends Controller
{
    public function pay(Request $request)
    {
        // Индификатор терминала.
        $TerminalKey = '1684504766185DEMO';
        
        // Сумма в рублях.
        $sum = $request->input('sum');
        
        // Номер заказа.
        $order_id = 0;
        
        $data = array(
            "TerminalKey" => $TerminalKey,
            "Amount" => $sum * 100,
            "OrderId" => $order_id,
            "SuccessURL" => "https://pornhub.com",
            "PayType" => 'O',
        );
                                
        $ch = curl_init('https://securepay.tinkoff.ru/v2/Init');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE)); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        
        $res = json_decode($res, true);

        if (!empty($res['PaymentURL'])) {
            // Редирект в платёжную систему.
            return redirect($res['PaymentURL']);
        } else {
            // Обработка ошибки
            return back()->withErrors(['payment' => 'Ошибка инициализации платежа']);
        }
    }
}