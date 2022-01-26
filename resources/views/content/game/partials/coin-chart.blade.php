<div class="col-12">
  <div class="card">
    <div class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
      <div>
        <h4 class="card-title mb-25">{!! $game->getCoinDisplay($coin) !!} {{ $coin['name'] }} ({{ strtoupper($coin['symbol']) }}) </h4>
        <span class="card-subtitle">
          <button class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="{{ $coin['contract_address'] }}">
            <a href="{{ $coin['links']['blockchain_site'][0] }}" target="_blank">View CA: {{ \Illuminate\Support\Str::limit($coin['contract_address'], 4, $end='..') }} </a>
          </button>
          <button class="btn btn-sm btn-outline-success" id="btn-copy" onclick="copyToClipboard('{{ $coin['contract_address'] }}', '#btn-copy')">Copy CA <i class="ficon" data-feather="copy"></i></button>
          @if($coin['asset_platform_id'] == 'binance-smart-chain')
            <button class="btn btn-sm btn-outline-dark" data-toggle="tooltip" title="{{ $coin['contract_address'] }}">
            <a href="https://poocoin.app/tokens/{{ $coin['contract_address'] }}" target="_blank" data-toggle="tooltip" title="https://poocoin.app/tokens/{{ $coin['contract_address'] }}">PooCoin </a>
          </button>
          @endif
        </span>
      </div>
      <div class="d-flex align-items-center flex-wrap mt-sm-0 mt-1">
        <h5 class="fw-bolder mb-0 me-1">₱ {{ $coin['market_data']['current_price']['php'] }}</h5>
        <span class="badge badge-light-secondary">
          <i class="text-{{ $coin['market_data']['price_change_percentage_24h'] < 0 ? 'danger' : 'success'}} font-small-3" data-feather="arrow-{{ $coin['market_data']['price_change_percentage_24h'] < 0 ? 'down' : 'up'}}"></i>
          <span class="align-middle">{{ number_format($coin['market_data']['price_change_percentage_24h'], 2) }}%</span>
        </span>
      </div>
    </div>
    <div class="card-body">
      <div id="{{$chart_name}}"></div>
      @include('content.game.partials.coin-change-percentage', ['coin' => $coin])
    </div>
  </div>
</div>




