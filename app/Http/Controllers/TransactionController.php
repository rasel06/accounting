<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function store(TransactionStoreRequest $request): Response
    {
        $transaction = Transaction::create($request->validated());

        $request->session()->flash('transaction.id', $transaction->id);

        return redirect()->route('post.index');
    }

    public function show(Request $request, Transaction $transaction): Response
    {
        return view('transaction.show', compact('transaction'));
    }
}
