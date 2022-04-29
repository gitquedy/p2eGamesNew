{{-- <div class="col-12"> --}}
  {{-- <div class="card"> --}}
    <div class="row">
      <div class="col-md-6 text-center text-md-start">
        <h4 class="card-title mb-25">{!! $game->getCoinDisplay($coin) !!} {{ $coin['name'] }} ({{ strtoupper($coin['symbol']) }}) </h4>
      </div>
      <div class="col-md-6 text-center text-md-end">
        {{-- d-flex align-items-center flex-wrap mt-sm-0 mt-1 --}}
        <h3 class="fw-bolder mb-0 me-1">₱ {{ rtrim(sprintf('%f',floatval($coin['market_data']['current_price']['php'])),'0') }}</h3>
        <span class="badge badge-light-secondary">
          <i class="text-{{ $coin['market_data']['price_change_percentage_24h'] < 0 ? 'danger' : 'success'}} font-small-3" data-feather="arrow-{{ $coin['market_data']['price_change_percentage_24h'] < 0 ? 'down' : 'up'}}"></i>
          <span class="align-middle">{{ number_format($coin['market_data']['price_change_percentage_24h'], 2) }}%</span>
        </span>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 text-center text-md-start col-md-6">
        <div class="btn-group pt-1 py-0" role="group">
          <input type="radio" class="btn-check" name="filterChartType_{{ $chart_name }}" value="prices" id="prices_{{ $chart_name }}" autocomplete="off" checked/>
          <label class="btn btn-xs btn-outline-primary" for="prices_{{ $chart_name }}">Prices</label>

          <input type="radio" class="btn-check" name="filterChartType_{{ $chart_name }}" value="market_caps" id="market_caps_{{ $chart_name }}" autocomplete="off"/>
          <label class="btn btn-xs btn-outline-primary" for="market_caps_{{ $chart_name }}">Market Cap</label>

          <input type="radio" class="btn-check" name="filterChartType_{{ $chart_name }}" value="total_volumes" id="total_volumes_{{ $chart_name }}" autocomplete="off"/>
          <label class="btn btn-xs btn-outline-primary" for="total_volumes_{{ $chart_name }}">Volume</label>
        </div>
      </div>
      <div class="col-sm-12 text-center text-md-end col-md-6">
        <div class="btn-group pt-1 py-0" role="group">
            <input type="radio" class="btn-check" name="filterChart_{{ $chart_name }}" data-chart="{{ $chart_name }}" value="1" id="24h_{{ $chart_name }}" autocomplete="off" checked/>
            <label class="btn btn-xs btn-outline-primary" for="24h_{{ $chart_name }}">24h</label>
            <input type="radio" class="btn-check" name="filterChart_{{ $chart_name }}" data-chart="{{ $chart_name }}" value="7" id="7d_{{ $chart_name }}" autocomplete="off"/>
            <label class="btn btn-xs btn-outline-primary" for="7d_{{ $chart_name }}">7d</label>
            <input type="radio" class="btn-check" name="filterChart_{{ $chart_name }}" data-chart="{{ $chart_name }}" value="14" id="14d_{{ $chart_name }}" autocomplete="off"/>
            <label class="btn btn-xs btn-outline-primary" for="14d_{{ $chart_name }}">14d</label>
            <input type="radio" class="btn-check" name="filterChart_{{ $chart_name }}" data-chart="{{ $chart_name }}" value="30" id="30d_{{ $chart_name }}" autocomplete="off"/>
            <label class="btn btn-xs btn-outline-primary" for="30d_{{ $chart_name }}">30d</label>
            <input type="radio" class="btn-check" name="filterChart_{{ $chart_name }}" data-chart="{{ $chart_name }}" value="90" id="90d_{{ $chart_name }}" autocomplete="off"/>
            <label class="btn btn-xs btn-outline-primary d-none d-sm-block" for="90d_{{ $chart_name }}">90d</label>
            <input type="radio" class="btn-check" name="filterChart_{{ $chart_name }}" data-chart="{{ $chart_name }}" value="100" id="180d_{{ $chart_name }}" autocomplete="off"/>
            <label class="btn btn-xs btn-outline-primary d-none d-sm-block" for="180d_{{ $chart_name }}">180d</label>
            <input type="radio" class="btn-check" name="filterChart_{{ $chart_name }}" data-chart="{{ $chart_name }}" value="365" id="1y_{{ $chart_name }}" autocomplete="off"/>
            <label class="btn btn-xs btn-outline-primary rounded-end d-sm-none" for="1y_{{ $chart_name }}">1y</label>
            <label class="btn btn-xs btn-outline-primary d-none d-sm-block" for="1y_{{ $chart_name }}">1y</label>
            <input type="radio" class="btn-check" name="filterChart_{{ $chart_name }}" data-chart="{{ $chart_name }}" value="max" id="max_{{ $chart_name }}" autocomplete="off"/>
            <label class="btn btn-xs btn-outline-primary d-none d-sm-block" for="max_{{ $chart_name }}">Max</label>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="text-center pt-1 py-0">
          <button class="btn btn-xs btn-outline-primary" data-toggle="tooltip" title="{{ $coin['contract_address'] }}">
            <a href="{{ $coin['links']['blockchain_site'][0] }}" target="_blank">View CA</a>
          </button>
          <button class="btn btn-xs btn-outline-success" id="btn-copy" onclick="copyToClipboard('{{ $coin['contract_address'] }}', '#btn-copy')">Copy CA <i class="ficon" data-feather="copy"></i></button>
          @if($coin['asset_platform_id'] == 'binance-smart-chain')
            <button class="btn btn-xs btn-outline-dark" data-toggle="tooltip" title="{{ $coin['contract_address'] }}">
            <a href="https://poocoin.app/tokens/{{ $coin['contract_address'] }}" target="_blank" data-toggle="tooltip" title="https://poocoin.app/tokens/{{ $coin['contract_address'] }}">PooCoin </a>
          </button>
          @endif
        </div>
      </div>
    </div>






    <div class="card-header pb-0 pt-1 d-flex flex-sm-row flex-column justify-content-sm-between align-items-center align-items-sm-start  justify-content-center justify-content-sm-start ">
      
    </div>

      <div class="d-flex d-sm-block flex-sm-row flex-column justify-content-sm-between align-items-center align-items-sm-start  justify-content-center justify-content-sm-start">
        
      </div>
    <div class="card-header py-0 px-2 d-flex flex-sm-row flex-column align-items-sm-start align-items-center justify-content-between">
      
      
    </div>
    {{-- <div class="card-header d-flex flex-sm-row flex-column align-items-end justify-content-end py-0">
    </div> --}}
    <div class="card-body">
      <div id="{{$chart_name}}"></div>
      @include('content.game.partials.coin-change-percentage', ['coin' => $coin])
    </div>
  {{-- </div> --}}
{{-- </div> --}}




