@extends('layouts/contentLayoutMaster')

@section('title', 'Gainers')

@section('content')
@if($banner1)
<div class="row">
  <div class="col-md-12">
    <div class="card align-items-center">
        <a href="{{ $banner1->link }}">
          <picture>
            <source media="(max-width: 767px)" srcset="{{ $banner1->imageUrl($banner1->mobile) }}">
             <source media="(min-width: 768px) and (max-width: 1399px)" srcset="{{ $banner1->imageUrl($banner1->tablet) }}">
            <source media="(min-width: 1400px)" srcset="{{ $banner1->imageUrl($banner1->full) }}">
            <img src="{{ $banner1->imageUrl($banner1->full) }}" alt="Banner Advertise">
          </picture>
        </a>
    </div>
  </div>
</div>
@endif

<div class="row">
  <div class="col-xs-12 col-lg-6 ">
    <div class="card">
      <div class="table-responsive">
        <table class="table">
          <tbody>
            <tr class="bg-success text-white">
              <td class="f-tr"><i data-feather="trending-up"></i></td>
              <td class="text-start">Gainers</td>
              <td class="text-end" > % (24)</td>
            </tr>
            @foreach($gainers as $gainer)
              <tr>
                <td class="f-tr">{{ $loop->iteration }}</td>
                <td class="text-start">
                  <a href="{{ route('game.show', $gainer) }}">
                    <div class="d-flex justify-content-left align-items-center">
                      <div class="bg-light-red me-1">
                        <img src="{{ $gainer->imageUrl() }}" alt="{{ $gainer->name }}" width="30" height="30">
                      </div>
                      <div class="d-flex flex-column">
                        <span class="emp_name text-truncate fw-bold">{{ $gainer->name }}</span>
                      </div>
                    </div>
                  </a>
                </td>
                <td class="text-end"><span class="text-success">{{ $gainer->governance_price_change_percentage_24h }}%</span></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-xs-12 col-lg-6 ">
    <div class="card">
      <table class="table">
        <tbody>
          <tr class="bg-danger text-white">
            <td class="f-tr"><i data-feather="trending-down"></i></td>
            <td class="text-start">Losers</td>
            <td class="text-end" > % (24)</td>
          </tr>
          @foreach($losers as $loser)
            <tr>
              <td class="f-tr">{{ $loop->iteration }}</td>
              <td class="text-start">
                <a href="{{ route('game.show', $loser) }}">
                  <div class="d-flex justify-content-left align-items-center">
                    <div class="bg-light-red me-1">
                      <img src="{{ $loser->imageUrl() }}" alt="{{ $loser->name }}" width="30" height="30">
                    </div>
                    <div class="d-flex flex-column" >
                      <span class="emp_name text-truncate fw-bold">{{ $loser->name }}</span>
                    </div>
                  </div>
                </a>
              </td>
              <td class="text-end"><span class="text-danger">{{ $loser->governance_price_change_percentage_24h }}%</span></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
