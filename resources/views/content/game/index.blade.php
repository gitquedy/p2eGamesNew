@inject('request', 'Illuminate\Http\Request')
@extends('layouts/contentLayoutMaster')
@section('title', 'Game')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/extensions/jquery.rateyo.min.css')}}">
@endsection

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body mt-2">
          <div class="row g-1 mb-md-1">
            <div class="col-md-2">
              <select class="form-control select2 selectFilter" id="genre">
                <option value="all">All Genre</option>
                @foreach($genres as $genre)
                  <option value="{{ $genre->id }}">{{ $genre ->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <select class="form-control select2 selectFilter" id="blockchain">
                <option value="all">All Blockchains</option>
                @foreach($blockchains as $blockchain)
                  <option value="{{ $blockchain->id }}">{{ $blockchain ->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <select class="form-control select2 selectFilter" id="device">
                <option value="all">All Devices</option>
                <option value="Web">Web</option>
                <option value="Android">Android</option>
                <option value="IOS">IOS</option>
                <option value="Windows">Windows</option>
                <option value="Linux">Linux</option>
                <option value="Playstation">Playstation</option>
                <option value="XBOX">XBOX</option>
                <option value="Nintendo">Nintendo</option>
              </select>
            </div>

            <div class="col-md-2">
              <select class="form-control select2 selectFilter" id="status">
                <option value="all">All Status</option>
                <option value="Live">Live</option>
                <option value="Presale">Presale</option>
                <option value="Alpha">Alpha</option>
                <option value="Beta">Beta</option>
                <option value="Development">Development</option>
                <option value="Cancelled">Cancelled</option>
              </select>
            </div>

            <div class="col-md-2">
              <select class="form-control select2 selectFilter" id="nft">
                <option value="all">All NFT</option>
                <option value="1">NFT Support</option>
                <option value="0">No NFT Support</option>
              </select>
            </div>
            <div class="col-md-2">
              <select class="form-control select2 selectFilter" id="f2p">
                <option value="all">All F2P</option>
                <option value="Free-To-Play">Free-To-Play</option>
                <option value="NFT Required">NFT Required</option>
                <option value="Crypto Required">Crypto Required</option>
                <option value="Game Required">Game Required</option>
              </select>
            </div>
            @if(Auth::check())
                @if($request->user()->isAdmin())
                <div class="col-md-2">
                  <select class="form-control select2 selectFilter" id="is_approved">
                    <option value="all">All Game</option>
                    <option value="1">Approved</option>
                    <option value="0">For Approval</option>
                  </select>
                </div>
              @endif
            @endif
          </div>
        </div>
        <hr class="my-0" />
        <table class="datatables-basic table" id="game_table">
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Genre</th>
              <th>Blockchains</th>
              <th>Devices</th>
              <th>Status</th>
              <!-- <th>NFT</th> -->
              <th>F2P</th>
              <th>Minimum Investment</th>
              <th>Rating</th>
              @if(Auth::check())
                @if($request->user()->isAdmin())
                  <th>Action</th>
                @endif
              @endif
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
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script type="text/javascript">
    var table_id = 'game_table'
    var table_title = 'Game List';
    var table_route = {
            url: '{{ route('game.index') }}',
            data: function (data) {
                  data.genre = $("#genre").val();
                  data.blockchain = $("#blockchain").val();
                  data.device = $("#device").val();
                  data.status = $("#status").val();
                  data.nft = $("#nft").val();
                  data.f2p = $("#f2p").val();
              }
          };
    @if(Auth::check())
      @if($request->user()->isAdmin())
      var table_route = {
            url: '{{ route('game.index') }}',
            data: function (data) {
                  data.genre = $("#genre").val();
                  data.blockchain = $("#blockchain").val();
                  data.device = $("#device").val();
                  data.status = $("#status").val();
                  data.nft = $("#nft").val();
                  data.f2p = $("#f2p").val();
                  data.is_approved = $("#is_approved").val();
              }
          };
      @endif
    @endif
    var columnns = [
              { data: 'id', name: 'id', 'orderable' : false},
              { data: 'nameAndImgDisplay', name: 'name', 'orderable' : false},
              { data: 'genres', name: 'genres', 'orderable' : false},
              { data: 'blockchains', name: 'blockchains', 'orderable' : false},
              { data: 'devices', name: 'devices', 'orderable' : false},
              { data: 'status', name: 'status', 'orderable' : false},
              // { data: 'nft', name: 'nft', 'orderable' : false},
              { data: 'f2p', name: 'f2p', 'orderable' : false},
              { data: 'minimum_investment', name: 'minimum_investment'},
              { data: 'ratings', name: 'ratings', 'orderable' : false},
          ];
    @if(Auth::check())
      @if($request->user()->isAdmin())
        var columnns = [
              { data: 'id', name: 'id', 'orderable' : false},
              { data: 'nameAndImgDisplay', name: 'name', 'orderable' : false},
              { data: 'genres', name: 'genres', 'orderable' : false},
              { data: 'blockchains', name: 'blockchains', 'orderable' : false},
              { data: 'devices', name: 'devices', 'orderable' : false},
              { data: 'status', name: 'status', 'orderable' : false},
              // { data: 'nft', name: 'nft', 'orderable' : false},
              { data: 'f2p', name: 'f2p', 'orderable' : false},
              { data: 'minimum_investment_formatted', name: 'minimum_investment', 'orderable' : false},
              { data: 'ratings', name: 'ratings', 'orderable' : false},
              { data: 'action', name: 'action', 'orderable' : false}
          ];
      @endif
    @endif
      var buttons = [{
          text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Add New Game',
          className: 'create-new btn btn-primary',
          attr: {
            'onclick': 'location.href="' + '{{ route("game.create") }}' + '"',
          }
        }];
        var displayLength = 10;
        var lengthMenu = [10, 50, 100];

      var drawCallback = function( settings ) {
        $('[data-bs-toggle="tooltip"]').tooltip();
        feather.replace({
          width: 14,height: 14
        });
        $('.rating').rateYo({
          starWidth: "20px",
        });
      };
      $(".select2").select2({
        width: '100%',
      });
  </script>
  <script src="{{ asset('js/scripts/tables/table-datatables-basic.js') }}"></script>
  <script src="{{ asset('js/scripts/forms-validation/form-normal.js') }}"></script>
@endsection
