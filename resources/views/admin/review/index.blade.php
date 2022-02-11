@inject('request', 'Illuminate\Http\Request')
@extends('layouts/contentLayoutMaster')
@section('title', 'Reviews')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/extensions/jquery.rateyo.min.css')}}">
  <link rel="stylesheet" href="{{ asset('vendors/css/extensions/swiper.min.css') }}">
@endsection

@section('page-style')
  <link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-swiper.css') }}">
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
                    <option value="0" selected>Pending</option>
                    <option value="1">Approved</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <select class="form-control select2 selectFilter" id="game">
                    <option value="all">All Games</option>
                    @foreach($games as $game)
                        <option value="{{ $game->id }}">{{ $game->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-3">
                  <select class="form-control select2 selectFilter" id="rating">
                    <option value="all">All Stars</option>
                    <option value="1}">1 Star</option>
                    <option value="2}">2 Star</option>
                    <option value="3}">3 Star</option>
                    <option value="4}">4 Star</option>
                    <option value="5}">5 Star</option>
                  </select>
                </div>
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
        <table class="datatables-basic table" id="review_table">
          <thead>
            <tr>
              <th>Id</th>
              <th>Game</th>
              <th>Subject</th>
              <th>Rating</th>
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
  <script src="{{ asset('vendors/js/extensions/jquery.rateyo.min.js') }}"></script>
  <script src="{{ asset('vendors/js/extensions/swiper.min.js') }}"></script>
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script type="text/javascript">
    var table_id = 'review_table'
    var table_title = 'Review List';
    var table_route = {
          url: '{{ route('review.index') }}',
          data: function (data) {
                data.status = $("#status").val();
                data.game = $("#game").val();
                data.rating = $("#rating").val();
            }
        };
      var columnns = [
            { data: 'id', name: 'id'},
            { data: 'game', name: 'game.name'},
            { data: 'subject', name: 'subject'},
            { data: 'ratingFormatted', name: 'rating'},
            { data: 'action', name: 'action', 'orderable' : false}
        ];
      var drawCallback = function( settings ) {
        $('[data-bs-toggle="tooltip"]').tooltip();
        feather.replace({
          width: 14,height: 14
        });
        $('.review-detail-rating').rateYo({
          starWidth: "14px",
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
  <script src="{{ asset('js/scripts/forms-validation/form-confirmation.js') }}"></script>
@endsection
