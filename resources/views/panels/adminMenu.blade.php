@inject('request', 'Illuminate\Http\Request')
<li class="nav-item dropdown" data-menu=dropdown>
  <a href="javascript:void(0)" class="nav-link d-flex align-items-center dropdown-toggle" target="_self" data-bs-toggle=dropdown>
    <i data-feather="figma"></i>
    <span>Games</span>
  </a>
    <ul class="dropdown-menu" data-bs-popper="none">
      <li class="{{ $request->segment(1) == 'game' && $request->segment(2) == 'create' ? 'active' : '' }}">
        <a href="{{ route('game.create') }}" class="dropdown-item d-flex align-items-center" target="_self">
          <i data-feather="plus-circle"></i>
          <span>Add Game</span>
        </a>
      </li>
      <li class="{{ $request->segment(1) == 'admin' && $request->segment(2) == 'genre' ? 'active' : '' }}">
        <a href="{{ route('genre.index') }}" class="dropdown-item d-flex align-items-center" target="_self">
          <i data-feather="tag"></i>
          <span>Genre</span>
        </a>
      </li>
      <li class="{{ $request->segment(1) == 'admin' && $request->segment(2) == 'blockchain' ? 'active' : '' }}">
        <a href="{{ route('blockchain.index') }}" class="dropdown-item d-flex align-items-center" target="_self">
          <i data-feather="code"></i>
          <span>BlockChain</span>
        </a>
      </li>

      <li class="{{ $request->segment(1) == 'admin' && $request->segment(2) == 'review' ? 'active' : '' }}">
        <a href="{{ route('review.index') }}" class="dropdown-item d-flex align-items-center" target="_self">
          <i data-feather="book-open"></i>
          <span>Reviews</span>
        </a>
      </li>
    </ul>
</li>

<li class="nav-item dropdown" data-menu=dropdown>
  <a href="javascript:void(0)" class="nav-link d-flex align-items-center dropdown-toggle" target="_self" data-bs-toggle=dropdown>
    <i data-feather="columns"></i>
    <span>Banner</span>
  </a>
    <ul class="dropdown-menu" data-bs-popper="none">
      <li class="{{ $request->segment(1) == 'admin' && $request->segment(2) == 'banner' ? 'active' : '' }}">
        <a href="{{ route('banner.index') }}" class="dropdown-item d-flex align-items-center" target="_self">
          <i data-feather="list"></i>
          <span>Banner List</span>
        </a>
      </li>
    </ul>
</li>

<li class="nav-item dropdown" data-menu=dropdown>
  <a href="javascript:void(0)" class="nav-link d-flex align-items-center dropdown-toggle" target="_self" data-bs-toggle=dropdown>
    <i data-feather="dollar-sign"></i>
    <span>Exchange</span>
  </a>
    <ul class="dropdown-menu" data-bs-popper="none">

      <li class="{{ $request->segment(1) == 'order' ? 'active' : '' }}">
        <a href="{{ route('order.index') }}" class="dropdown-item d-flex align-items-center" target="_self">
          <i data-feather="shopping-cart"></i>
          <span>Order List</span>
        </a>
      </li>

      <li class="{{ $request->segment(1) == 'admin' && $request->segment(2) == 'coin' ? 'active' : '' }}">
        <a href="{{ route('coin.index') }}" class="dropdown-item d-flex align-items-center" target="_self">
          <i data-feather="paperclip"></i>
          <span>Coin List</span>
        </a>
      </li>

      <li class="{{ $request->segment(1) == 'admin' && $request->segment(2) == 'paymentMethod' ? 'active' : '' }}">
        <a href="{{ route('paymentMethod.index') }}" class="dropdown-item d-flex align-items-center" target="_self">
          <i data-feather="credit-card"></i>
          <span>Payment Methods</span>
        </a>
      </li>

      <li class="{{ $request->segment(1) == 'admin' && $request->segment(2) == 'systemSetting' ? 'active' : '' }}">
        <a href="{{ route('systemSetting.edit', 1) }}" class="dropdown-item d-flex align-items-center" target="_self">
          <i data-feather="settings"></i>
          <span>System Settings</span>
        </a>
      </li>
    </ul>
</li>
