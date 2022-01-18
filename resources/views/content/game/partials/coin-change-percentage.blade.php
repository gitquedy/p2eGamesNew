<div class="row">
  <div class="col-12 text-center">
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <th>24h</th>
          <th>7d</th>
          <th>14d</th>
          <th>30d</th>
          <th>60d</th>
          <th>200d</th>
          <th>1y</th>
        </thead>
        <tbody>
          <tr>
            <td>
              <span class="badge badge-light-{{ $coin['market_data']['price_change_percentage_24h'] < 0 ? 'danger' : 'success'}}">
              <i class="text-{{ $coin['market_data']['price_change_percentage_24h'] < 0 ? 'danger' : 'success'}} font-small-3" data-feather="arrow-{{ $coin['market_data']['price_change_percentage_24h'] < 0 ? 'down' : 'up'}}"></i>
              <span class="align-middle">{{ number_format($coin['market_data']['price_change_percentage_24h'], 2) }}%</span>
              </span>
            </td>
            <td>
              <span class="badge badge-light-{{ $coin['market_data']['price_change_percentage_7d'] < 0 ? 'danger' : 'success'}}">
              <i class="text-{{ $coin['market_data']['price_change_percentage_7d'] < 0 ? 'danger' : 'success'}} font-small-3" data-feather="arrow-{{ $coin['market_data']['price_change_percentage_7d'] < 0 ? 'down' : 'up'}}"></i>
              <span class="align-middle">{{ number_format($coin['market_data']['price_change_percentage_7d'], 2) }}%</span>
              </span>
            </td>
            <td>
              <span class="badge badge-light-{{ $coin['market_data']['price_change_percentage_14d'] < 0 ? 'danger' : 'success'}}">
              <i class="text-{{ $coin['market_data']['price_change_percentage_14d'] < 0 ? 'danger' : 'success'}} font-small-3" data-feather="arrow-{{ $coin['market_data']['price_change_percentage_14d'] < 0 ? 'down' : 'up'}}"></i>
              <span class="align-middle">{{ number_format($coin['market_data']['price_change_percentage_14d'], 2) }}%</span>
              </span>
            </td>
            <td>
              <span class="badge badge-light-{{ $coin['market_data']['price_change_percentage_30d'] < 0 ? 'danger' : 'success'}}">
              <i class="text-{{ $coin['market_data']['price_change_percentage_30d'] < 0 ? 'danger' : 'success'}} font-small-3" data-feather="arrow-{{ $coin['market_data']['price_change_percentage_30d'] < 0 ? 'down' : 'up'}}"></i>
              <span class="align-middle">{{ number_format($coin['market_data']['price_change_percentage_30d'], 2) }}%</span>
              </span>
            </td>
            <td>
              <span class="badge badge-light-{{ $coin['market_data']['price_change_percentage_60d'] < 0 ? 'danger' : 'success'}}">
              <i class="text-{{ $coin['market_data']['price_change_percentage_60d'] < 0 ? 'danger' : 'success'}} font-small-3" data-feather="arrow-{{ $coin['market_data']['price_change_percentage_60d'] < 0 ? 'down' : 'up'}}"></i>
              <span class="align-middle">{{ number_format($coin['market_data']['price_change_percentage_60d'], 2) }}%</span>
              </span>
            </td>
            <td>
              <span class="badge badge-light-{{ $coin['market_data']['price_change_percentage_1y'] < 0 ? 'danger' : 'success'}}">
              <i class="text-{{ $coin['market_data']['price_change_percentage_1y'] < 0 ? 'danger' : 'success'}} font-small-3" data-feather="arrow-{{ $coin['market_data']['price_change_percentage_1y'] < 0 ? 'down' : 'up'}}"></i>
              <span class="align-middle">{{ number_format($coin['market_data']['price_change_percentage_1y'], 2) }}%</span>
              </span>
            </td>
            <td>
              <span class="badge badge-light-{{ $coin['market_data']['price_change_percentage_1y'] < 0 ? 'danger' : 'success'}}">
              <i class="text-{{ $coin['market_data']['price_change_percentage_1y'] < 0 ? 'danger' : 'success'}} font-small-3" data-feather="arrow-{{ $coin['market_data']['price_change_percentage_1y'] < 0 ? 'down' : 'up'}}"></i>
              <span class="align-middle">{{ number_format($coin['market_data']['price_change_percentage_1y'], 2) }}%</span>
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
 </div>

