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
                    <div class="bg-danger bg-opacity-15 p-2 rounded-3 me-3 text-danger d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="bi bi-exclamation-octagon fs-4"></i>
                    </div>
                    Overdue Loans
                </h3>
                <span class="text-muted small">List of repayment schedules that have passed their due date</span>
            </div>
            <a href="{{ route('loans.pending') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 shadow-sm rounded-pill fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Pending Loans
            </a>
        </div>

        <div class="card">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-secondary">
                    <i class="bi bi-list-ul me-1"></i> Detailed Data Table
                </h6>
                <span class="badge bg-danger px-3 py-2 rounded-pill fw-semibold">
                    Total: {{ $overdueSchedules->total() }} records
                </span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0 text-center">
                        <thead class="modern-table-header">
                            <tr class="text-uppercase">
                                <th style="width: 110px;" class="ps-3">Loan ID</th>
                                <th class="text-start" style="width: auto;">Customer Name</th>
                                <th style="width: 140px;">Installment</th>
                                <th style="width: 130px;">Due Date</th>
                                <th style="width: 140px;">Amount ($)</th>
                                <th style="width: 120px;">Status</th>
                                <th style="width: 1%; white-space: nowrap;" class="pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($overdueSchedules as $sch)
                            <tr class="custom-table-row border-bottom">
                                <td class="ps-3 py-3 fw-bold text-dark">
                                    <span class="badge bg-light text-primary border px-2 py-1">#{{ $sch->loan_id }}</span>
                                </td>
                                <td class="text-start py-3 fw-semibold text-dark">{{ $sch->loan->customer->name ?? 'N/A' }}</td>
                                <td class="py-3">
                                    <span class="badge bg-light text-secondary border fw-normal px-2 py-1">
                                        Installment {{ $sch->installment_no }}
                                    </span>
                                </td>
                                <td class="py-3 text-danger fw-semibold">{{ $sch->due_date }}</td>
                                <td class="py-3 fw-bold text-danger">${{ number_format($sch->total_due, 2) }}</td>
                                <td class="py-3">
                                    <span class="badge bg-danger text-white px-3 py-1.5 rounded-pill fw-bold">Overdue</span>
                                </td>
                                <td class="pe-3 py-3 text-nowrap" style="width: 1%;">
                                    <a href="{{ route('loans.show', $sch->loan_id) }}" class="btn btn-sm btn-light border text-primary shadow-sm px-3 py-1 text-nowrap" title="View Loan">
                                        <i class="bi bi-eye-fill me-1"></i> View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-5 text-center text-muted">
                                    <div class="py-4">
                                        <i class="bi bi-shield-check text-success opacity-50 d-block mb-2" style="font-size: 3.5rem;"></i>
                                        <h5 class="fw-bold mt-2 text-secondary">No overdue loans found</h5>
                                        <p class="text-muted small mb-0">All schedules have been paid on time or are not yet due.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($overdueSchedules->hasPages())
            <div class="card-footer bg-white border-0 py-3 d-flex justify-content-end">
                {{ $overdueSchedules->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection