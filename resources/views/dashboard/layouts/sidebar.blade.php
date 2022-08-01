     
     <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky">
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
            <span>Administrator</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
              <span data-feather="plus-circle" class="align-text-bottom"></span>
            </a>
          </h6>

          <ul class="nav flex-column">
   @php
     $usrRoleId = auth()->user()->dashboard_role_id;
    $q = DB::select("select b.nama, b.url, b.icon, b.slugmenu, b.is_submenu from dashboard_role_accesses as a join dashboard_menus as b on a.menu_id = b.id join dashboard_roles as c on a.dashboard_role_id = c.id where a.dashboard_role_id = $usrRoleId");

  
   @endphp
   @foreach ( $q as $q )
   @php
     $str = substr($q->url, 1); 
   @endphp
@if ($q->is_submenu == true)
@php
  $sub = \App\Models\DashboardSubmenu::where('slugmenu', $q->slugmenu)->get();
  // DB::table('dashboard_submenus')->where('slugmenu', $q->slugmenu)->get();
  $fulluri = Request::fullUrl();
  $qsd = strtolower($q->nama);
  $uri = strpos($fulluri, $qsd);
@endphp
<div class="btn-group dropend">
  <a class="nav-link {{ $uri == true ? 'active' : ''}} dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" href="#">
    <span data-feather="{{ $q->icon }}" class="align-text-bottom"></span>
  {{ $q->nama }}
  </a>
  <ul class="dropdown-menu">
    @foreach ($sub as $sub )
    <li><a class="dropdown-item" href="{{ $sub->urlsubmenu }}">{{ $sub->namasubmenu }}</a></li>
    @endforeach
  </ul>
</div>
@else
<li class="nav-item">
  <a class="nav-link {{ $str = Request::is($str) ? 'active' : ''}}" href="{{ $q->url }}">
    <span data-feather="{{ $q->icon }}" class="align-text-bottom"></span>
    {{ $q->nama }}
  </a>
</li>
@endif
@endforeach
            <li class="nav-item">
              
            </li>
           {{--  <li class="nav-item">
              <a class="nav-link {{ Request::is('dashboard/menu*') ? 'active' : ''}}" href="/dashboard/menu">
                <span data-feather="menu" class="align-text-bottom"></span>
                Menu
              </a>
            </li> --}}

            
            {{-- <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="shopping-cart" class="align-text-bottom"></span>
                Products
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="users" class="align-text-bottom"></span>
                Customers
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                Reports
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="layers" class="align-text-bottom"></span>
                Integrations
              </a>
            </li>
          </ul>
  
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
            <span>Saved reports</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
              <span data-feather="plus-circle" class="align-text-bottom"></span>
            </a>
          </h6>
          <ul class="nav flex-column mb-2">
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="file-text" class="align-text-bottom"></span>
                Current month
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="file-text" class="align-text-bottom"></span>
                Last quarter
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="file-text" class="align-text-bottom"></span>
                Social engagement
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="file-text" class="align-text-bottom"></span>
                Year-end sale
              </a>
            </li> --}}
          </ul>
        </div>
      </nav>

      