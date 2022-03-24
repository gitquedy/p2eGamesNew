@inject('request', 'Illuminate\Http\Request')
@php
$configData = Helper::applClasses();
@endphp
{{-- Horizontal Menu --}}
<div class="horizontal-menu-wrapper">
  <div class="header-navbar navbar-expand-sm navbar navbar-horizontal
  {{$configData['horizontalMenuClass']}}
  {{($configData['theme'] === 'dark') ? 'navbar-dark' : 'navbar-light' }}
  navbar-shadow menu-border
  {{ ($configData['layoutWidth'] === 'boxed' && $configData['horizontalMenuType']  === 'navbar-floating') ? 'container-xxl' : '' }}"
  role="navigation"
  data-menu="menu-wrapper"
  data-menu-type="floating-nav">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
        <li class="nav-item me-auto">
          <a class="navbar-brand" href="{{url('/')}}">
            <span class="brand-logo">
              <img src="{{ asset('images/logo/logo.png') }}" class="img-fluid" alt="Brand logo">
            </span>
          </a>
        </li>
        <li class="nav-item nav-toggle">
          <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
            <i class="d-block d-xl-none text-white toggle-icon font-medium-4" data-feather="x"></i>
          </a>
        </li>
      </ul>
    </div>
    <div class="shadow-bottom"></div>
    <!-- Horizontal menu content-->
    <div class="navbar-container main-menu-content" data-menu="menu-container">
      <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="nav-item {{ $request->segment(1) == '' && $request->segment(2) == '' ? 'active' : '' }}">
          <a href="/" class="nav-link d-flex align-items-center">
            <i data-feather="home"></i>
            <span>Home</span>
          </a>
        </li>
        {{-- {{Auth::user()->isAdmin()}} --}}
        @if(Auth::check())
          @if(Auth::user()->isAdmin())
            @include('panels.adminMenu')
          @else
            @include('panels.clientMenu')
          @endif
        @else
          @include('panels.clientMenu')
        @endif
      </ul>

    </div>
  </div>
</div>
