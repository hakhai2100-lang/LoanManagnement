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
        <!-- Header Section -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-15 p-2 rounded-3 me-3 text-primary d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="bi bi-card-list fs-4"></i>
                    </div>
                    All Loans
                </h3>
            </div>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('dashboard.overdue') }}" class="btn btn-outline-danger btn-sm px-3 py-2 shadow-sm rounded-pill fw-semibold">
                <i class="bi bi-calendar-x me-1"></i> View Overdue Loans
            </a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4 rounded-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0 text-center">
                        <thead class="modern-table-header">
                            <tr class="text-uppercase">
                                <th style="width: 110px;" class="ps-3">Loan ID</th>
                                <th class="text-start" style="width: auto;">Customer Name</th>
                                <th style="width: 145px;">Principal ($)</th>
                                <th style="width: 120px;">Interest (%)</th>
                                <th style="width: 110px;">Term</th>
                                <th style="width: 120px;">Status</th>
                                <th style="width: 1%; white-space: nowrap;" class="pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $loan)
                            <tr class="custom-table-row border-bottom">
                                <td class="ps-3 py-3 fw-bold text-dark">
                                    <span class="badge bg-light text-dark border px-2 py-1">LN-{{ str_pad($loan->loan_id, 4, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="text-start py-3 fw-semibold text-dark">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-initial rounded-circle bg-secondary bg-opacity-10 text-secondary d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                            {{ substr($loan->customer->name ?? 'N', 0, 1) }}
                                        </div>
                                        {{ $loan->customer->name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="py-3 fw-bold text-success">${{ number_format($loan->principal_amount, 2) }}</td>
                                <td class="py-3 text-secondary fw-medium">{{ $loan->interest_rate }}% <span class="small text-muted">/mo</span></td>
                                <td class="py-3"><span class="badge bg-light text-secondary border fw-normal px-2 py-1">{{ $loan->term_months }} mos</span></td>
                                <td class="py-3">
                                @if($loan->status === 'Pending')
                                    <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold border border-warning">Pending</span>
                                @elseif($loan->status === 'Approved')
                                    <span class="badge bg-info text-dark px-3 py-1.5 rounded-pill fw-bold border border-info">Approved</span>
                                @elseif($loan->status === 'Disbursed')
                                    <span class="badge bg-success text-white px-3 py-1.5 rounded-pill fw-bold">Disbursed</span>
                                @elseif($loan->status === 'Rejected')
                                    <span class="badge bg-danger text-white px-3 py-1.5 rounded-pill fw-bold">Rejected</span>
                                @else
                                    <span class="badge bg-secondary text-white px-3 py-1.5 rounded-pill fw-bold">{{ $loan->status }}</span>
                                @endif
                                </td>
                                <td class="pe-3 py-3 text-nowrap" style="width: 1%;">
                                    <div class="d-inline-flex justify-content-center align-items-center gap-1">
                                        @if($loan->status === 'Disbursed')
                                            <a href="{{ route('loans.schedule', $loan->loan_id) }}" class="btn btn-sm btn-light border text-primary shadow-sm px-2 text-nowrap" title="Repayment Schedule">
                                                <i class="bi bi-calendar3 me-1"></i> Schedule
                                            </a>
                                            @if(in_array(auth()->user()->role, ['admin', 'cashier']))
                                            <a href="{{ route('loans.repay', $loan->loan_id) }}" class="btn btn-sm btn-light border text-success shadow-sm px-2 text-nowrap" title="Repay Loan">
                                                <i class="bi bi-cash me-1"></i> Repay
                                            </a>
                                            @endif
                                        @else
                                            <button class="btn btn-sm btn-light border text-muted px-2 text-nowrap" disabled style="opacity: 0.45; cursor: not-allowed;">
                                                <i class="bi bi-calendar3 me-1"></i> Schedule
                                            </button>
                                            @if(in_array(auth()->user()->role, ['admin', 'cashier']))
                                            <button class="btn btn-sm btn-light border text-muted px-2 text-nowrap" disabled style="opacity: 0.45; cursor: not-allowed;">
                                                <i class="bi bi-cash me-1"></i> Repay
                                            </button>
                                            @endif
                                        @endif

                                        <a href="{{ route('loans.show', $loan->loan_id) }}" class="btn btn-sm btn-light border text-info shadow-sm px-2 text-nowrap" title="View Details">
                                            <i class="bi bi-eye-fill me-1"></i> Details
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <div class="py-4">
                                        <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-25"></i>
                                        <span class="text-secondary fw-medium">No loan records available in the system yet.</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if(method_exists($loans, 'hasPages') && $loans->hasPages())
            <div class="card-footer bg-white border-0 py-3 d-flex justify-content-end">
                {{ $loans->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection