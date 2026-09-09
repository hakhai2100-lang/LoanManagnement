@extends('layouts.app')

@section('main')
<div class="row justify-content-center py-4">
    <div class="col-md-6">
        <div class="card shadow-sm border border-success rounded-3">
            <div class="card-header bg-success text-white py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-cash-coin me-2"></i>Record Repayment - LN-{{ str_pad($loan->loan_id, 4, '0', STR_PAD_LEFT) }}
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="bg-light p-3 rounded-3 mb-3 border">
                    <p class="mb-1"><strong>Customer:</strong> {{ $loan->customer->name ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>Principal Amount:</strong> <span class="text-success fw-bold">${{ number_format($loan->principal_amount, 2) }}</span></p>
                    <p class="mb-0"><strong>Interest Rate:</strong> {{ $loan->interest_rate }}% /mo</p>
                </div>
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('loans.repay.store', $loan->loan_id) }}" method="POST">
                    @csrf

                    @php
                        $nextSchedule = $loan->schedules->whereIn('status', ['Pending', 'Unpaid', 'Overdue'])->first();
                        $defaultAmount = $nextSchedule ? $nextSchedule->total_due : 0;
                    @endphp

                    <div class="mb-3">
                        <label class="form-label fw-bold">Payment Amount ($)</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text bg-light">$</span>
                            <input 
                                type="number" 
                                step="0.01" 
                                name="amount_paid" 
                                class="form-control @error('amount_paid') is-invalid @enderror" 
                                value="{{ old('amount_paid', $defaultAmount > 0 ? $defaultAmount : '') }}" 
                                placeholder="0.00" 
                                required
                            >
                            @error('amount_paid')
                                <div class="invalid-feedback fw-semibold d-block mt-1">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        @if($nextSchedule && !$errors->has('amount_paid'))
                            <small class="text-muted d-block mt-1">
                                Amount due for installment #{{ $nextSchedule->installment_no }}: <span class="fw-bold text-primary">${{ number_format($nextSchedule->total_due, 2) }}</span>
                            </small>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Payment Method</label>
                        <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
                            <option value="Cash" {{ old('payment_method') === 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Bank Transfer" {{ old('payment_method') === 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer (KHQR)</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('loans.show', $loan->loan_id) }}" class="btn btn-secondary w-50">Back</a>
                        <button type="submit" class="btn btn-success w-50 fw-bold">Save Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection