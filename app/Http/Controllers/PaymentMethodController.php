<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodStoreRequest;
use App\Http\Requests\PaymentMethodUpdateRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        $paymentMethods = PaymentMethod::simplePaginate(8);

        return view('payment-methods.index', compact('paymentMethods'));
    }

    public function create(Request $request): Response
    {
        return view('payment-methods.create');
    }

    public function store(PaymentMethodStoreRequest $request): Response
    {
        $paymentMethod = PaymentMethod::create($request->validated());

        return redirect()->route('payment-methods.index');
    }

    public function show(Request $request, PaymentMethod $paymentMethod): Response
    {
        return view('payment-methods.show', compact('paymentMethod'));
    }

    public function edit(Request $request, PaymentMethod $paymentMethod): Response
    {
        return view('payment-methods.edit', compact('paymentMethod'));
    }

    public function update(PaymentMethodUpdateRequest $request, PaymentMethod $paymentMethod): Response
    {
        $paymentMethod->update($request->validated());

        return redirect()->route('payment-methods.index');
    }

    public function destroy(Request $request, PaymentMethod $paymentMethod): Response
    {
        $paymentMethod->delete();

        return redirect()->route('payment-methods.index');
    }
}
