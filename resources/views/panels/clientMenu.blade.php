@inject('request', 'Illuminate\Http\Request')
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
      @endif
    </ul>
</li>

<li class="nav-item {{ $request->segment(1) == 'exchange' && $request->segment(2) == '' ? 'active' : '' }}">
  <a href="{{ route('exchange.index') }}" class="nav-link d-flex align-items-center">
    <i data-feather="shopping-cart"></i>
    <span>Exchange</span>
  </a>
</li>

@if($request->user())
<li class="nav-item {{ $request->segment(1) == 'order' ? 'active' : '' }}">
  <a href="{{ route('order.index') }}" class="nav-link d-flex align-items-center">
    <i data-feather="shopping-bag"></i>
    <span>My Orders</span>
  </a>
</li>
<li class="nav-item {{ $request->segment(1) == 'pte' ? 'active' : '' }}">
  <a href="{{ route('privateSale.add') }}" class="nav-link d-flex align-items-center">
    <i data-feather="briefcase"></i>
    <span>PTE Private Sale</span>
  </a>
</li>

@endif
