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
            <div>
                <h3 class="fw-bold text-dark mb-1 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-15 p-2 rounded-3 me-3 text-primary d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    Pending Loans
                </h3>
            </div>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('dashboard.overdue') }}" class="btn btn-outline-danger btn-sm px-3 py-2 shadow-sm rounded-pill fw-semibold">
                <i class="bi bi-exclamation-triangle me-1"></i> View Overdue Loans
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
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-secondary">
                    <i class="bi bi-list-ul me-1"></i> Applications to Review
                </h6>
                <span class="badge bg-primary px-3 py-2 rounded-pill fw-semibold">
                    Total: {{ is_countable($loans) ? count($loans) : $loans->count() }} records
                </span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0 text-center">
                        <thead class="modern-table-header">
                            <tr class="text-uppercase">
                                <th style="width: 110px;" class="ps-3">Loan ID</th>
                                <th class="text-start" style="width: auto;">Customer Name</th>
                                <th style="width: 140px;">Amount ($)</th>
                                <th style="width: 120px;">Interest (%)</th>
                                <th style="width: 100px;">Term</th>
                                <th style="width: 110px;">Status</th>
                                <th style="width: 1%; white-space: nowrap;" class="pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $loan)
                            <tr class="custom-table-row border-bottom">
                                <td class="ps-3 py-3 fw-bold text-dark">
                                    <span class="badge bg-light text-dark border px-2 py-1">LN-{{ str_pad($loan->loan_id, 4, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="text-start py-3 fw-semibold text-dark">{{ $loan->customer->name ?? 'N/A' }}</td>
                                <td class="py-3 fw-bold text-success">${{ number_format($loan->principal_amount, 2) }}</td>
                                <td class="py-3 text-secondary fw-medium">{{ $loan->interest_rate }}% <span class="small text-muted">/mo</span></td>
                                <td class="py-3"><span class="badge bg-light text-secondary border fw-normal px-2 py-1">{{ $loan->term_months }} mos</span></td>
                                <td class="py-3">
                                    @if($loan->status === 'Pending')
                                        <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold border border-warning">Pending</span>
                                    @elseif($loan->status === 'Approved')
                                        <span class="badge bg-info text-dark px-3 py-1.5 rounded-pill fw-bold border border-info">Approved</span>
                                    @else
                                        <span class="badge bg-secondary text-white px-3 py-1.5 rounded-pill fw-bold">{{ $loan->status }}</span>
                                    @endif
                                </td>
                                <td class="pe-3 py-3 text-nowrap" style="width: 1%;">
                                    <div class="d-inline-flex justify-content-center align-items-center gap-1">
                                    
                                        @can('approve', $loan)
                                        <form action="{{ route('loans.approve', $loan->loan_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success text-nowrap shadow-sm px-3" style="min-width: 115px;" onclick="return confirm('Are you sure you want to approve this loan?')">
                                                <i class="bi bi-check-lg me-1"></i> Approve
                                            </button>
                                        </form>
                                        @endcan

                                        @can('disburse', $loan)
                                        <form action="{{ route('loans.disburse', $loan->loan_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary text-nowrap shadow-sm px-3" style="min-width: 115px;" onclick="return confirm('Are you sure you want to disburse this loan?')">
                                                <i class="bi bi-cash-stack me-1"></i> Disburse
                                            </button>
                                        </form>
                                        @endcan

                                        <a href="{{ route('loans.show', $loan->loan_id) }}" class="btn btn-sm btn-light border text-secondary text-nowrap shadow-sm px-3" style="min-width: 70px;" title="View Details">
                                            <i class="bi bi-eye me-1"></i> View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-5 text-center">
                                    <div class="py-4">
                                        <i class="bi bi-inbox text-secondary opacity-25 d-block mb-2" style="font-size: 3.5rem;"></i>
                                        <h5 class="fw-bold mt-2 text-secondary">No pending loans found</h5>
                                        <p class="text-muted small mb-0">All loan applications have been approved or disbursed.</p>
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