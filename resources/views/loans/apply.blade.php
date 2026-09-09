@extends('layouts.app')

@section('main')
<div class="content-wrapper p-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center">
                        <div class="bg-primary-subtle text-primary p-2 rounded-3 me-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-file-earmark-plus-fill fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">Loan Application</h5>
                            <span class="text-muted small">Please fill in the details of the loan amount and term</span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 border-start border-success border-4" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4 border-start border-danger border-4" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm mb-4 border-start border-danger border-4">
                                <ul class="mb-0 small ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('loans.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="principal_amount" class="form-label fw-semibold text-secondary fs-7">
                                    Principal Amount <span class="text-danger">*</span>
                                </label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light border-end-0 text-muted fw-semibold">$</span>
                                    <input 
                                        type="number" 
                                        step="0.01" 
                                        name="principal_amount" 
                                        id="principal_amount" 
                                        class="form-control border-start-0 ps-0" 
                                        placeholder="1000.00" 
                                        value="{{ old('principal_amount', 1000) }}" 
                                        required
                                    >
                                </div>
                                <span class="text-muted fs-8 mt-1 d-block">The principal amount you wish to apply for (minimum $50)</span>
                            </div>

                            <div class="mb-3">
                                <label for="interest_rate" class="form-label fw-semibold text-secondary fs-7">
                                    Monthly Interest Rate <span class="text-danger">*</span>
                                </label>
                                <div class="input-group shadow-sm">
                                    <input 
                                        type="number" 
                                        step="0.01" 
                                        name="interest_rate" 
                                        id="interest_rate" 
                                        class="form-control border-end-0" 
                                        placeholder="2.0" 
                                        value="{{ old('interest_rate', 2) }}" 
                                        required
                                    >
                                    <span class="input-group-text bg-light border-start-0 text-muted fw-semibold">% / Month</span>
                                </div>
                                <span class="text-muted fs-8 mt-1 d-block">Interest rate calculated as a percentage per month</span>
                            </div>

                            <div class="mb-4">
                                <label for="term_months" class="form-label fw-semibold text-secondary fs-7">
                                    Loan Term <span class="text-danger">*</span>
                                </label>
                                <div class="input-group shadow-sm">
                                    <input 
                                        type="number" 
                                        
                                        name="term_months" 
                                        id="term_months" 
                                        class="form-control border-end-0" 
                                        placeholder="6" 
                                        value="{{ old('term_months', 6) }}" 
                                        min="1"
                                        max="60"
                                        required
                                    >
                                    <span class="input-group-text bg-light border-start-0 text-muted fw-semibold">Months</span>
                                </div>
                                <span class="text-muted fs-8 mt-1 d-block">Number of months for repayment</span>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                <a href="{{ route('loans.my') }}" class="btn btn-outline-secondary px-4 shadow-sm">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                    <i class="bi bi-send-fill me-1"></i> Submit Application
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Professional Styling Enhancements -->
<style>
    .fs-7 { font-size: 0.9rem; }
    .fs-8 { font-size: 0.8rem; }
    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    .input-group-text {
        font-size: 0.9rem;
    }
</style>
@endsection