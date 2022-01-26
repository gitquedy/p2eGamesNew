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
            <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
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
        <li class="nav-item dropdown" data-menu=dropdown>
          <a href="javascript:void(0)" class="nav-link d-flex align-items-center dropdown-toggle" target="_self" data-bs-toggle=dropdown>
            <i data-feather="figma"></i>
            <span>Games</span>
          </a>
            <ul class="dropdown-menu" data-bs-popper="none">
              <li class="{{ $request->segment(1) == 'game' && $request->segment(2) == '' ? 'active' : '' }}">
                <a href="{{ route('game.index') }}" class="dropdown-item d-flex align-items-center" target="_self">
                  <i data-feather="list"></i>
                  <span>All Games</span>
                </a>
              </li>
              <li class="{{ $request->segment(1) == 'game' && $request->segment(2) == 'recent' ? 'active' : '' }}">
                <a href="{{ route('game.recent') }}" class="dropdown-item d-flex align-items-center" target="_self">
                  <i data-feather="plus"></i>
                  <span>Recently Added</span>
                </a>
              </li>
              <li class="{{ $request->segment(1) == 'game' && $request->segment(2) == 'top' ? 'active' : '' }}">
                <a href="{{ route('game.top') }}" class="dropdown-item d-flex align-items-center" target="_self">
                  <i data-feather="star"></i>
                  <span>Top Games</span>
                </a>
              </li>
              <li class="{{ $request->segment(1) == 'game' && $request->segment(2) == 'gainer' ? 'active' : '' }}">
                <a href="{{ route('game.gainer') }}" class="dropdown-item d-flex align-items-center" target="_self">
                  <i data-feather="arrow-up"></i>
                  <span>Top Gainer</span>
                </a>
              </li>
              <li class="{{ $request->segment(1) == 'game' && $request->segment(2) == 'loser' ? 'active' : '' }}">
                <a href="{{ route('game.loser') }}" class="dropdown-item d-flex align-items-center" target="_self">
                  <i data-feather="arrow-down"></i>
                  <span>Top Loser</span>
                </a>
              </li>
              <li class="{{ $request->segment(1) == 'game' && $request->segment(2) == 'redflag' ? 'active' : '' }}">
                <a href="{{ route('game.redflag') }}" class="dropdown-item d-flex align-items-center" target="_self">
                  <i data-feather="thumbs-down"></i>
                  <span>Red Flag</span>
                </a>
              </li>
              <li class="{{ $request->segment(1) == 'game' && $request->segment(2) == 'rugpull' ? 'active' : '' }}">
                <a href="{{ route('game.rugpull') }}" class="dropdown-item d-flex align-items-center" target="_self">
                  <i data-feather="trending-down"></i>
                  <span>Rug Pull</span>
                </a>
              </li>
              @if (Auth::check())
              <li class="{{ $request->segment(1) == 'game' && $request->segment(2) == 'create' ? 'active' : '' }}">
                <a href="{{ route('game.create') }}" class="dropdown-item d-flex align-items-center" target="_self">
                  <i data-feather="plus-circle"></i>
                  <span>Add Game</span>
                </a>
              </li>
                @if($request->user()->isAdmin() == true)
                  <li class="{{ $request->segment(1) == 'genre' && $request->segment(2) == '' ? 'active' : '' }}">
                    <a href="{{ route('genre.index') }}" class="dropdown-item d-flex align-items-center" target="_self">
                      <i data-feather="tag"></i>
                      <span>Genre</span>
                    </a>
                  </li>
                  <li class="{{ $request->segment(1) == 'blockchain' && $request->segment(2) == '' ? 'active' : '' }}">
                    <a href="{{ route('blockchain.index') }}" class="dropdown-item d-flex align-items-center" target="_self">
                      <i data-feather="code"></i>
                      <span>BlockChain</span>
                    </a>
                  </li>
                @endif
              @endif
            </ul>
        </li>

      </ul>

    </div>
  </div>
</div>
