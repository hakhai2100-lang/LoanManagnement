@extends('layouts.app')

@section('main')
<div class="content-wrapper p-4">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">
                    <i class="bi bi-hourglass-split text-primary me-2"></i>Pending Loans
                </h3>
                <p class="text-muted small mb-0">Review, approve, and manage customer loan applications efficiently.</p>
            </div>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('dashboard.overdue') }}" class="btn btn-outline-danger btn-sm shadow-sm">
                <i class="bi bi-exclamation-triangle me-1"></i> View Overdue Loans
            </a>
            @endif
        </div>

        <!-- Alert Notifications -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm border-0 border-start border-success border-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm border-0 border-start border-danger border-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Main Card Section -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
                <h6 class="m-0 fw-bold text-secondary">
                    <i class="bi bi-list-ul me-1 text-primary"></i> Applications to Review
                </h6>
                <span class="badge bg-light text-primary border px-3 py-2 rounded-pill fw-semibold">
                    Total: {{ is_countable($loans) ? count($loans) : $loans->count() }} records
                </span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-light text-uppercase fs-7 text-secondary tracking-wider">
                            <tr>
                                <th class="py-3 ps-4 text-start">Loan ID</th>
                                <th class="py-3 text-start">Customer Name</th>
                                <th class="py-3 text-end">Amount ($)</th>
                                <th class="py-3">Interest (%)</th>
                                <th class="py-3">Term</th>
                                <th class="py-3">Status</th>
                                <th class="py-3 pe-4 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $loan)
                            <tr class="transition-hover">
                                <td class="ps-4 text-start fw-semibold text-primary">LN-{{ str_pad($loan->loan_id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="text-start fw-medium text-dark">{{ $loan->customer->name ?? 'N/A' }}</td>
                                <td class="text-end fw-bold text-dark">${{ number_format($loan->principal_amount, 2) }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $loan->interest_rate }}%</span> /mo</td>
                                <td>{{ $loan->term_months }} mos</td>
                                <td>
                                    @if($loan->status === 'Pending')
                                        <span class="badge bg-warning-subtle text-warning-emphasis px-2.5 py-1 rounded-pill fw-semibold">Pending</span>
                                    @elseif($loan->status === 'Approved')
                                        <span class="badge bg-info-subtle text-info-emphasis px-2.5 py-1 rounded-pill fw-semibold">Approved</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary-emphasis px-2.5 py-1 rounded-pill fw-semibold">{{ $loan->status }}</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-1 justify-content-end">
                                        @can('approve', $loan)
                                        <form action="{{ route('loans.approve', $loan->loan_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success px-2 py-1 shadow-sm" title="Approve Loan" onclick="return confirm('Are you sure you want to approve this loan?')">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        @endcan

                                        @can('disburse', $loan)
                                        <form action="{{ route('loans.disburse', $loan->loan_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary px-2 py-1 shadow-sm" title="Disburse Loan" onclick="return confirm('Are you sure you want to disburse this loan?')">
                                                <i class="bi bi-cash-stack"></i>
                                            </button>
                                        </form>
                                        @endcan

                                        <a href="{{ route('loans.show', $loan->loan_id) }}" class="btn btn-sm btn-light border px-2 py-1 text-secondary shadow-sm" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-5 text-center text-muted">
                                    <div class="my-3">
                                        <i class="bi bi-inbox display-6 text-muted opacity-50"></i>
                                        <p class="mt-2 mb-0">No pending loans found.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if(method_exists($loans, 'hasPages') && $loans->hasPages())
            <div class="card-footer bg-white py-3 px-4 d-flex justify-content-end border-top">
                {{ $loans->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Embedded Professional Styling enhancements -->
<style>
    .fs-7 { font-size: 0.85rem; }
    .tracking-wider { letter-spacing: 0.05em; }
    .table > :not(caption) > * > * { padding: 0.85rem 0.5rem; }
    .transition-hover { transition: background-color 0.15s ease-in-out; }
    .card { box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.03) !important; }
</style>
@endsection