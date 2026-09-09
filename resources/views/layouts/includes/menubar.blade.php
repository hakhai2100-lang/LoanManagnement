<nav class="app-header navbar navbar-expand bg-body">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a
          class="nav-link"
          data-lte-toggle="sidebar"
          href="#"
          role="button"
          aria-label="Toggle sidebar"
        >
          <i class="bi bi-list"></i>
        </a>
      </li>
    </ul>
    <ul class="navbar-nav ms-auto align-items-center">
      @auth
        @if(in_array(auth()->user()->role, ['admin', 'loan_officer', 'cashier']))
          <li class="nav-item me-2">
            <form action="{{ route('loans.index') }}" method="GET" class="d-flex align-items-center" role="search">
              <div class="input-group">
                <input
                  class="form-control form-control-sm form-control-navbar"
                  type="text"
                  name="search"
                  placeholder="ស្វែងរក ID ឬឈ្មោះ..."
                  aria-label="Search"
                  value="{{ request('search') }}"
                />
                <button class="btn btn-sm btn-navbar btn-outline-secondary" type="submit">
                  <i class="bi bi-search"></i>
                </button>
                @if(request('search'))
                  <a href="{{ route('loans.index') }}" class="btn btn-sm btn-outline-danger" title="លុបការស្វែងរក">
                    <i class="bi bi-x-lg"></i>
                  </a>
                @endif
              </div>
            </form>
          </li>
        @endif
      @endauth
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <img
            src="{{ asset('assets/images/user2-160x160.jpg') }}"
            class="user-image rounded-circle shadow"
            alt="User Image"
          />
          <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'BBU' }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <li class="user-header text-bg-primary">
            <img
              src="{{ asset('assets/images/user2-160x160.jpg') }}"
              class="rounded-circle shadow"
              alt="User Image"
            />
            <p>
              {{ Auth::user()->name ?? 'User' }}
              <small>{{ Auth::user()->email ?? '' }}</small>
            </p>
          </li>
          <li class="user-footer">
            <a href="#" class="btn btn-outline-secondary">Profile</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline float-end">
              @csrf
              <button type="submit" class="btn btn-outline-danger">
                Sign out
              </button>
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>