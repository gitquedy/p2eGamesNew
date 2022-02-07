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
          <h4 class="card-title">Add Coin</h4>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li>
                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-content collapse">
          <div class="card-body">
            <form action="{{ route('coin.store') }}" method="POST" class="form" enctype="multipart/form-data">
              @csrf
              <div class="form-body">
                <div class="row mb-2">
                  <div class="col-4">
                      <div class="form-group">
                          <label for="name">Coin Name</label>
                          <input type="text" class="form-control" name="name" placeholder="Coin Name">
                      </div>
                  </div>

                  <div class="col-4">
                      <div class="form-group">
                          <label for="name">Short Name</label>
                          <input type="text" class="form-control" name="short_name" placeholder="Short Name">
                      </div>
                  </div>

                  <div class="col-4">
                      <div class="form-group">
                          <label for="name">Icon</label>
                          <input type="file" class="form-control" name="icon" placeholder="icon">
                      </div>
                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-4">
                      <div class="form-group">
                          <label for="name">Coingecko ID</label>
                          <input type="text" class="form-control" name="coingecko_id" placeholder="Coingecko id">
                      </div>
                  </div>

                  <div class="col-4">
                      <div class="form-group">
                          <label for="name">Minimum Price</label>
                          <input type="text" class="form-control" name="minimum_price" placeholder="Minimum Price">
                      </div>
                  </div>

                  <div class="col-4">
                      <div class="form-group">
                          <label for="name">Markup Price (%)</label>
                          <input type="text" class="form-control" name="markup_price" placeholder="Markup Price (%)">
                      </div>
                  </div>
                </div>
                <div class="row mb-2">
                    <div class="col-4">
                      <div class="form-group">
                          <label for="Active">Active</label>
                          <select class="form-control" name="isActive">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                          </select>
                      </div>
                    </div>
                  <div class="col-4">
                      <div class="form-group">
                          <label for="name">Default Qty</label>
                          <input type="nubmber" class="form-control" name="default" placeholder="1">
                      </div>
                  </div>
                  <div class="col-4">
                      <div class="form-group">
                          <label for="name">Step</label>
                          <input type="nubmber" class="form-control" name="step" placeholder="Step e.g. 0.01 or 0.1">
                      </div>
                  </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                     <div class="col-12">
                          <input type="submit" name="save_with_reload_table" class="btn btn-primary mr-1 mb-1 btn_save" value="Save">
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
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <table class="datatables-basic table" id="coin_table">
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Short Name</th>
              <th>Coingecko ID</th>
              <th>Minimum Price</th>
              <th>Markup Price</th>
              <th>Active</th>
              <th>Default</th>
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
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script type="text/javascript">
    var table_id = 'coin_table'
    var table_title = 'Coin List';
    var table_route = {
          url: '{{ route('coin.index') }}',
          data: function (data) {
                // data.field = $("#field").val();
            }
        };
      var columnns = [
            { data: 'id', name: 'id'},
            { data: 'nameAndIcon', name: 'name'},
            { data: 'short_name', name: 'short_name'},
            { data: 'coingecko_id', name: 'coingecko_id'},
            { data: 'minimum_price', name: 'minimum_price'},
            { data: 'markup_price', name: 'markup_price'},
            { data: 'isActive', name: 'isActive'},
            { data: 'isDefault', name: 'isDefault'},
            { data: 'action', name: 'action', 'orderable' : false}
        ];

      var drawCallback = function( settings ) {
        $('[data-bs-toggle="tooltip"]').tooltip();
        feather.replace({
          width: 14,height: 14
        });
      };
  </script>
  <script src="{{ asset('js/scripts/tables/table-datatables-basic.js') }}"></script>
  <script src="{{ asset('js/scripts/forms-validation/form-normal.js') }}"></script>
  <script src="{{ asset('js/scripts/forms-validation/form-confirmation.js') }}"></script>
@endsection
