@extends('layouts.app')

@section('main')
<style>
    .modern-table-header {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;
        color: #ffffff !important;
        letter-spacing: 0.8px;
    }
    .modern-table-header th {
        font-weight: 700 !important;
        font-size: 0.95rem !important;
        border: none !important;
        padding: 16px 12px !important;
    }
    .custom-table-row {
        transition: all 0.2s ease-in-out;
    }
    .custom-table-row:hover {
        background-color: #f8fafc !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .card {
        border: none;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
        border-radius: 12px;
        overflow: hidden;
    }
</style>

<div class="content-wrapper p-4">
    <div class="container-fluid">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <h3 class="fw-bold text-dark mb-0 d-flex align-items-center">
                <div class="bg-primary bg-opacity-15 p-2 rounded-3 me-3 text-primary d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="bi bi-info-circle fs-4"></i>
                </div>
                Loan Details LN-{{ str_pad($loan->loan_id, 4, '0', STR_PAD_LEFT) }}
            </h3>
            <div class="d-flex gap-2">
                <a href="{{ route('loans.schedule', $loan->loan_id) }}" class="btn btn-outline-secondary px-3 py-2 shadow-sm rounded-pill fw-semibold">
                    <i class="bi bi-calendar3 me-1"></i> View Schedule
                </a>
                @can('repay', $loan)
                <a href="{{ route('loans.repay', $loan->loan_id) }}" class="btn btn-success px-3 py-2 shadow-sm rounded-pill fw-semibold">
                    <i class="bi bi-cash me-1"></i> Repay
                </a>
                @endcan
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <div class="card bg-white p-4 text-center rounded-3 border-start border-primary border-4 shadow-sm">
                    <h6 class="text-uppercase text-muted fw-semibold mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Total Payable</h6>
                    <h3 class="fw-bold text-primary mb-0">${{ number_format($totalPayable, 2) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-white p-4 text-center rounded-3 border-start border-success border-4 shadow-sm">
                    <h6 class="text-uppercase text-muted fw-semibold mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Total Paid</h6>
                    <h3 class="fw-bold text-success mb-0">${{ number_format($totalPaid, 2) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-white p-4 text-center rounded-3 border-start border-danger border-4 shadow-sm">
                    <h6 class="text-uppercase text-muted fw-semibold mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">Remaining Balance</h6>
                    <h3 class="fw-bold text-danger mb-0">${{ number_format($remainingBalance, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center mb-3">
            <h4 class="fw-bold text-dark mb-0 d-flex align-items-center">
                <i class="bi bi-clock-history text-secondary me-2"></i>Repayment History
            </h4>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0 text-center">
                        <thead class="modern-table-header">
                            <tr class="text-uppercase">
                                <th class="ps-3">Payment Date</th>
                                <th>Amount Paid ($)</th>
                                <th>Payment Method</th>
                                <th class="pe-3">Cashier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loan->repayments as $rp)
                            <tr class="custom-table-row border-bottom">
                                <td class="ps-3 py-3 fw-semibold text-dark">{{ $rp->payment_date }}</td>
                                <td class="py-3 fw-bold text-success">${{ number_format($rp->amount_paid, 2) }}</td>
                                <td class="py-3">
                                    <span class="badge bg-light text-secondary border fw-normal px-2 py-1">{{ $rp->payment_method }}</span>
                                </td>
                                <td class="pe-3 py-3 text-secondary">{{ $rp->cashier->name ?? 'N/A' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-5 text-center text-muted">
                                    <div class="py-4">
                                        <i class="bi bi-inbox text-secondary opacity-25 d-block mb-2" style="font-size: 3.5rem;"></i>
                                        <span class="text-secondary fw-medium">No repayment history recorded yet</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection