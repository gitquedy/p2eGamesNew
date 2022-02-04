@inject('request', 'Illuminate\Http\Request')
@extends('layouts/contentLayoutMaster')
@section('title', 'Coins')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
<!-- Basic table -->

<section id="card-actions">
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Edit System Settings</h4>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li>
                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form action="{{ route('systemSetting.update', $systemSetting) }}" method="POST" class="form" enctype="multipart/form-data">
              @csrf
              @method('put')
              <div class="form-body">
                <div class="row mb-2">
                  <div class="col-4">
                      <div class="form-group">
                          <label for="name">Exchange Transaction Fee</label>
                          <input type="text" class="form-control" name="exchange_transaction_fee" placeholder="exchange_transaction_fee" value="{{ $systemSetting->exchange_transaction_fee }}">
                      </div>
                  </div>

                  <div class="col-4">
                      <div class="form-group">
                          <label for="name">Exchange Fix Price</label>
                          <input type="text" class="form-control" name="exchange_fix_price" placeholder="exchange_fix_price" value="{{ $systemSetting->exchange_fix_price }}">
                      </div>
                  </div>
                </div>
                  <div class="row">
                    <div class="col-6">
                     <div class="col-12">
                          <input type="submit" name="save" class="btn btn-primary mr-1 mb-1 btn_save" value="Save">
                          <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset </button>
                      </div>
                    </div>
                  </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('vendor-script')
  {{-- vendor files --}}
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset('js/scripts/forms-validation/form-normal.js') }}"></script>
@endsection
