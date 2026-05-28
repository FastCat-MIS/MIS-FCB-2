<?php

namespace App\Http\Controllers\Teller;

use App\Actions\Teller\Payment\CreatePaymentAction;
use App\Actions\Teller\Payment\DeletePaymentAction;
use App\Actions\Teller\Payment\GetPaymentAction;
use App\Actions\Teller\Payment\GetPaymentsAction;
use App\Actions\Teller\Payment\UpdatePaymentAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request, GetPaymentsAction $action)
    {
        return $action->execute($request->all());
    }

    public function show($paymentId, GetPaymentAction $action)
    {
        return $action->execute((int) $paymentId);
    }

    public function store(Request $request, CreatePaymentAction $action)
    {
        return $action->execute($request->all());
    }

    public function update(Request $request, $paymentId, UpdatePaymentAction $action)
    {
        return $action->execute((int) $paymentId, $request->all());
    }

    public function destroy($paymentId, DeletePaymentAction $action)
    {
        return $action->execute((int) $paymentId);
    }
}

