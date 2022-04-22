@extends('layouts/contentLayoutMaster')

@section('title', 'Home')

@section('page-style')
    <style>
      .f-tr {
        min-width: 0!important;
        width: 0!important;
      }

      .auto-banner {
        min-width: 100%;
        min-height: 100%;
        object-fit: cover;
      }

      .mw-0 {
        max-width: 0!important;
      }
    </style>
@endsection

@section('content')
@if($banner1)
<div class="row">
  <div class="col-md-12">
    <div class="card align-items-center pb-2 pt-2">
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
  <div class="col-xs-12 col-lg-4 ">
    <div class="card">
      <div class="table-responsive">
        <table class="table">
          <tbody>
            <tr>
              <td class="f-tr px-1 d-none d-sm-table-cell"><i data-feather="trending-up"></i></td>
              <td class="text-start ps-1 pe-0 px-sm-0">Gainers</td>
              <td class="text-end p-1" > <a href="{{ route('game.gainer') }}">More <i data-feather="chevron-right"></i></a></td>
            </tr>
            @foreach($gainers as $gainer)
              <tr>
                <td class="f-tr text-center px-1 d-none d-sm-table-cell">{{ $loop->iteration }}</td>
                <td class="text-start ps-1 pe-0 px-sm-0 text-truncate w-100 mw-0">
                  <a href="{{ route('game.show', $gainer) }}">
                        <img src="{{ $gainer->imageUrl() }}" alt="{{ $gainer->name }}" width="30" height="30">
                        <span class="ms-0 ms-sm-1 emp_name fw-bold">{{ $gainer->name }}</span>
                    {{-- <div class="d-flex justify-content-left align-items-center">
                      <div class="bg-light-red me-1">
                      </div>
                      <div class="d-flex flex-column">
                      </div>
                    </div> --}}
                  </a>
                </td>
                <td class="text-end ps-1"><span class="text-success">{{ $gainer->governance_price_change_percentage_24h }}%</span></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-xs-12 col-lg-4 ">
    <div class="card">
      <div class="table-responsive">
        <table class="table">
          <tbody>
            <tr>
              <td class="f-tr px-1 d-none d-sm-table-cell"><i data-feather="trending-down"></i></td>
              <td class="text-start ps-1 pe-0 px-sm-0">Losers</td>
              <td class="text-end p-1" > <a href="{{ route('game.loser') }}">More <i data-feather="chevron-right"></i></a></td>
            </tr>
            @foreach($losers as $loser)
              <tr>
                <td class="f-tr text-center px-1 d-none d-sm-table-cell">{{ $loop->iteration }}</td>
                <td class="text-start ps-1 pe-0 px-sm-0 text-truncate w-100 mw-0">
                  <a href="{{ route('game.show', $loser) }}">
                      <img src="{{ $loser->imageUrl() }}" alt="{{ $loser->name }}" width="30" height="30">
                      <span class="ms-0 ms-sm-1 emp_name text-truncate fw-bold">{{ $loser->name }}</span>
                    {{-- <div class="d-flex justify-content-left align-items-center">
                      <div class="bg-light-red me-1">
                      </div>
                      <div class="d-flex flex-column" >
                      </div>
                    </div> --}}
                  </a>
                </td>
                <td class="text-end ps-1"><span class="text-danger">{{ $loser->governance_price_change_percentage_24h }}%</span></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@if($banner2)
  <div class="col-xs-12 col-lg-4">
    <a href="{{ $banner2->link }}" target="_blank">
      <div class="card">
        <img src="{{ $banner2->imageUrl($banner2->full) }}" class="img-fluid d-none d-lg-block" style="height:193.85px">
        <img src="{{ $banner2->imageUrl($banner2->mobile) }}" class="img-fluid auto-banner d-lg-none h-100" style="height:293.85px">
        {{-- <img src="{{ $banner2->imageUrl($banner2->mobile) }}" class="img-fluid auto-banner d-md-none" style="height:193.85px"> --}}
      </div>
    </a>
  </div>
</div>
@endif

@include('content.game.table')
@endsection
