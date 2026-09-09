@extends('layouts.app')

@section('main')
<div class="content-wrapper p-4">
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">
                    <i class="bi bi-people-fill text-primary me-2"></i>បញ្ជីអតិថិជន (Customer List)
                </h3>
                <span class="text-muted small">គ្រប់គ្រងព័ត៌មាន និងស្ថានភាពរបស់អតិថិជនទាំងអស់</span>
            </div>
            <a href="{{ route('customers.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Create Customer
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Dashboard Widgets -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white border-0 shadow-sm rounded-3">
                    <div class="card-body p-3 text-center">
                        <span class="d-block mb-1">Total Customers</span>
                        <h3 class="fw-bold mb-0">{{ $totalCustomers }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white border-0 shadow-sm rounded-3">
                    <div class="card-body p-3 text-center">
                        <span class="d-block mb-1">Active Customers</span>
                        <h3 class="fw-bold mb-0">{{ $activeCustomers }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white border-0 shadow-sm rounded-3">
                    <div class="card-body p-3 text-center">
                        <span class="d-block mb-1">Inactive Customers</span>
                        <h3 class="fw-bold mb-0">{{ $inactiveCustomers }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers By City -->
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold text-dark mb-0">
                    <i class="bi bi-geo-alt-fill text-danger me-2"></i>Customers by City
                </h6>
            </div>
            <div class="card-body p-3">
                <div class="d-flex flex-wrap gap-2">
                    @forelse($customersByCity as $city)
                        <span class="badge bg-light text-dark border px-3 py-2">
                            {{ $city->city }}: <strong class="text-primary">{{ $city->total }}</strong>
                        </span>
                    @empty
                        <span class="text-muted small">No city data available.</span>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Search Filter -->
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-body p-3">
                <form action="{{ route('customers.index') }}" method="GET">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-2">
                            <input
                                type="text"
                                name="customer_code"
                                class="form-control form-control-sm"
                                placeholder="Customer Code"
                                value="{{ request('customer_code') }}">
                        </div>
                        <div class="col-md-2">
                            <input
                                type="text"
                                name="first_name"
                                class="form-control form-control-sm"
                                placeholder="First Name"
                                value="{{ request('first_name') }}">
                        </div>
                        <div class="col-md-2">
                            <input
                                type="text"
                                name="phone"
                                class="form-control form-control-sm"
                                placeholder="Phone"
                                value="{{ request('phone') }}">
                        </div>
                        <div class="col-md-2">
                            <input
                                type="text"
                                name="email"
                                class="form-control form-control-sm"
                                placeholder="Email"
                                value="{{ request('email') }}">
                        </div>
                        <div class="col-md-1">
                            <select name="gender" class="form-select form-select-sm">
                                <option value="">Gender</option>
                                <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <select name="city" class="form-select form-select-sm">
                                <option value="">City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->city }}" {{ request('city') == $city->city ? 'selected' : '' }}>
                                        {{ $city->city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <select name="status" class="form-select form-select-sm">
                                <option value="">Status</option>
                                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-1 d-flex gap-1">
                            <button type="submit" class="btn btn-primary btn-sm w-50" title="Search">
                                <i class="bi bi-search"></i>
                            </button>
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm w-50" title="Reset">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0 text-center">
                        <thead class="table-dark">
                            <tr class="small text-uppercase">
                                <th style="width: 80px;">ID</th>
                                <th>Customer Code</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Gender</th>
                                <th>DOB</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Status</th>
                                <th style="width: 180px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                                <tr>
                                    <td class="fw-bold text-dark">#{{ $customer->id }}</td>
                                    <td>{{ $customer->customer_code }}</td>
                                    <td>{{ $customer->first_name }}</td>
                                    <td>{{ $customer->last_name }}</td>
                                    <td>{{ $customer->gender }}</td>
                                    <td>{{ $customer->date_of_birth }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->city }}</td>
                                    <td>
                                        @if($customer->status == 'Active')
                                            <span class="badge bg-success px-2 py-1">Active</span>
                                        @else
                                            <span class="badge bg-danger px-2 py-1">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info btn-sm text-white" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this customer?')" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-5 text-muted">
                                        <i class="bi bi-people fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                        No customers found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($customers->hasPages())
                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-end">
                    {{ $customers->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection