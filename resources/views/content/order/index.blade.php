@inject('request', 'Illuminate\Http\Request')
@extends('layouts/contentLayoutMaster')
@section('title', 'Orders')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
@endsection

@section('content')
<section id="card-actions">
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Filters</h4>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li>
                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-content collapse">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                  <select class="form-control select2 selectFilter" id="status">
                    <option value="all">All Status</option>
                    <option value="1">Pending Payment</option>
                    <option value="2">Confirmation Receipt</option>
                    <option value="3">Transfer of Tokens</option>
                    <option value="4">Completed</option>
                    <option value="5">Cancelled</option>
                  </select>
                </div>

                @if($request->user()->isAdmin())
                <div class="col-md-3">
                  <select class="form-control select2 selectFilter" id="coin">
                    <option value="all">All Coins</option>
                    @foreach($coins as $coin)
                        <option value="{{ $coin->id }}" data-image="{{ $coin->imageUrl() }}">{{ $coin->name }}</option>
                    @endforeach
                  </select>
                </div>


                <div class="col-md-3">
                  <select class="form-control select2 selectFilter" id="paymentMethod">
                    <option value="all">All Payment Methods</option>
                    @foreach($paymentMethods as $paymentMethod)
                      <option value="{{ $paymentMethod->id }}" data-image="{{ $paymentMethod->imageUrl() }}"><span data-bs-toggle="tooltip" data-bs-placement="top" title="{{$paymentMethod->account_name .'('. $paymentMethod->account_number }})">{{$paymentMethod->provider }}</span></option>
                  @endforeach
                  </select>
                </div>
                @endif

            </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Basic table -->
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <table class="datatables-basic table" id="order_table">
          <thead>
            <tr>
              <th>Id</th>
              <th>Created At</th>
              <!-- <th>Customer</th> -->
              <th>Coin</th>
              <th>Transaction</th>
              <th>Qty</th>
              <th>Payment Method</th>
              <th>Total</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</section>
<!--/ Basic table -->
@endsection


@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset('vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/responsive.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/jszip.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
  <script src="{{ asset('vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}"></script>
  <script src="{{ asset('vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script type="text/javascript">
    var table_id = 'order_table'
    var table_title = 'Order List';
    var table_route = {
          url: '{{ route('order.index') }}',
          data: function (data) {
                data.status = $("#status").val();
                data.coin = $("#coin").val();
                data.paymentMethod = $("#paymentMethod").val();
            }
        };
      var columnns = [
            { data: 'idFormatted', name: 'id'},
            { data: 'createdAtFormatted', name: 'created_at'},
            // { data: 'name', name: 'name'},
            { data: 'coin', name: 'coin'},
            { data: 'transaction', name: 'transaction'},
            { data: 'qty', name: 'qty'},
            { data: 'paymentMethod', name: 'paymentMethod'},
            { data: 'totalFormatted', name: 'total'},
            { data: 'status', name: 'status'},
            { data: 'action', name: 'action', 'orderable' : false}
        ];
      var drawCallback = function( settings ) {
        $('[data-bs-toggle="tooltip"]').tooltip();
        feather.replace({
          width: 14,height: 14
        });
      };
      $(".select2").select2({
            templateResult: formatState,
            templateSelection: formatState,
            width: '100%',
        });

      function formatState (opt) {
          if (!opt.id) {
              return opt.text.toUpperCase();
          }

          var optimage = $(opt.element).attr('data-image');
          if(!optimage){
             return opt.text.toUpperCase();
          } else {
              var $opt = $(
                 '<span><img src="' + optimage + '" width="25px" /> ' + opt.text.toUpperCase() + '</span>'
              );
              return $opt;
          }
      }
  </script>
  <script src="{{ asset('js/scripts/tables/table-datatables-basic.js') }}"></script>
  <script src="{{ asset('js/scripts/forms-validation/form-normal.js') }}"></script>
@endsection
