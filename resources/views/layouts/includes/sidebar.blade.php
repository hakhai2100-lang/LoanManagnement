@php
    $userRole = auth()->user()->role ?? '';
@endphp


<style>
  .app-sidebar.custom-styled-sidebar {
      background-color: #002449 !important;
  }

  .app-sidebar.custom-styled-sidebar .brand-text {
      color: #ffffff;
      font-weight: 600;
  }

  .app-sidebar.custom-styled-sidebar .nav-link {
      color: #c2c7d0;
  }
  .app-sidebar.custom-styled-sidebar .nav-link:hover {
      color: #ffffff;
      background-color: rgba(255, 255, 255, 0.1);
  }


  .app-sidebar.custom-styled-sidebar .nav-link.active {
      background-color: #0d6efd !important; 
      color: #ffffff !important;
  }

  .app-sidebar.custom-styled-sidebar .nav-header {
      color: #6c757d;
      font-size: 0.75rem;
      letter-spacing: 0.5px;
  }
</style>

<aside class="app-sidebar custom-styled-sidebar shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="{{ url('/') }}" class="brand-link">
      <span class="brand-text fw-light">Build Bright University</span>
    </a>
  </div>
  
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="menu"
        data-accordion="false"
      >
        {{-- @if($userRole === 'admin')
        <li class="nav-header">MAIN MANAGEMENT</li>
        <li class="nav-item">
          <a href="{{ url('/customers') }}" class="nav-link {{ request()->is('customers*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-people-fill"></i>
            <p>Customers</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/employees') }}" class="nav-link {{ request()->is('employees*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-person-badge-fill"></i>
            <p>Employees</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/posts') }}" class="nav-link {{ request()->is('posts*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-file-earmark-text-fill"></i>
            <p>Posts</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/categories') }}" class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-tags-fill"></i>
            <p>Categories</p>
          </a>
        </li>
        @endif --}}

        <li class="nav-header">LOAN MANAGEMENT</li>
        @if($userRole === 'customer')
        <li class="nav-item">
          <a href="{{ route('loans.my') }}" class="nav-link {{ request()->routeIs('loans.my') ? 'active' : '' }}">
            <i class="nav-icon bi bi-wallet-fill text-info"></i>
            <p>(My Loans)</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('loans.apply') }}" class="nav-link {{ request()->routeIs('loans.apply') ? 'active' : '' }}">
            <i class="nav-icon bi bi-file-earmark-plus-fill text-primary"></i>
            <p>(Apply Loan)</p>
          </a>
        </li>
        @endif
        @if(in_array($userRole, ['admin', 'cashier']))
        <li class="nav-item">
          <a href="{{ route('loans.index') }}" class="nav-link {{ request()->routeIs('loans.index') ? 'active' : '' }}">
            <i class="nav-icon bi bi-cash-coin text-success"></i>
            <p>(All Loans)</p>
          </a>
        </li>
        @endif

        @if(in_array($userRole, ['admin', 'loan_officer']))
        <li class="nav-item">
          <a href="{{ route('loans.pending') }}" class="nav-link {{ request()->routeIs('loans.pending') ? 'active' : '' }}">
            <i class="nav-icon bi bi-hourglass-split text-warning"></i>
            <p>(Pending)</p>
          </a>
        </li>
        @endif

        @if($userRole === 'admin')
        <li class="nav-item">
          <a href="{{ route('dashboard.overdue') }}" class="nav-link {{ request()->routeIs('dashboard.overdue') ? 'active' : '' }}">
            <i class="nav-icon bi bi-calendar-x-fill text-danger"></i>
            <p>(Overdue)</p>
          </a>
        </li>
        @endif

        <li class="nav-item mt-3 px-3">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-light w-100 btn-sm text-start">
              <i class="bi bi-lock-fill me-2"></i> Logout
            </button>
          </form>
        </li>
      </ul>
    </nav>
  </div>
</aside>