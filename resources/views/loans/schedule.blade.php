@extends('layouts.app')

@section('main')
<div class="py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-dark mb-0">
            <i class="bi bi-calendar-check text-primary me-2"></i>Loan Repayment Schedule LN-{{ str_pad($loan->loan_id, 4, '0', STR_PAD_LEFT) }}
        </h3>
        <div>
            <a href="{{ route('loans.show', $loan->loan_id) }}" class="btn btn-secondary">
                <i class="bi bi-info-circle me-1"></i> Loan Details
            </a>
            @can('repay', $loan)
            <a href="{{ route('loans.repay', $loan->loan_id) }}" class="btn btn-success ms-1">
                <i class="bi bi-cash me-1"></i> Repay
            </a>
            @endcan
        </div>
    </div>

    <div class="card mb-3 p-3 bg-light border-0 shadow-sm rounded-3">
        <div class="row text-center text-md-start">
            <div class="col-md-3"><strong>Customer:</strong> {{ $loan->customer->name ?? 'N/A' }}</div>
            <div class="col-md-3"><strong>Principal:</strong> <span class="text-success fw-bold">${{ number_format($loan->principal_amount, 2) }}</span></div>
            <div class="col-md-3"><strong>Interest Rate:</strong> {{ $loan->interest_rate }}% /mo</div>
            <div class="col-md-3"><strong>Loan Term:</strong> {{ $loan->term_months }} mos</div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover align-middle mb-0 text-center">
                <thead class="table-dark">
                    <tr class="small text-uppercase">
                        <th>Installment No.</th>
                        <th>Due Date</th>
                        <th>Principal Due ($)</th>
                        <th>Interest Due ($)</th>
                        <th>Total Due ($)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loan->schedules as $sch)
                    @php
                        $st = strtolower(trim($sch->status ?? 'pending'));
                    @endphp
                    <tr class="{{ $st === 'paid' ? 'table-success' : ($st === 'overdue' ? 'table-danger' : '') }}">
                        <td class="fw-bold">Installment {{ $sch->installment_no }}</td>
                        <td>{{ $sch->due_date }}</td>
                        <td class="fw-bold">${{ number_format($sch->principal_due, 2) }}</td>
                        <td>${{ number_format($sch->interest_due, 2) }}</td>
                        <td class="fw-bold text-primary">${{ number_format($sch->total_due, 2) }}</td>
                        <td>
                            @if($st === 'paid')
                                <span class="badge bg-success">Paid</span>
                            @elseif($st === 'overdue')
                                <span class="badge bg-danger">Overdue</span>
                            @else
                                <span class="badge bg-secondary">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No repayment schedule available yet (Loan has not been disbursed)
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection