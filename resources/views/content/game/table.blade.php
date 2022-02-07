@inject('request', 'Illuminate\Http\Request')

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
                <div class="col-md-2">
                  <select class="form-control select2 selectFilter" id="genre">
                    <option value="all">All Genre</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <select class="form-control select2 selectFilter" id="blockchain">
                    <option value="all">All Blockchain</option>
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
                  <select class="form-control select2 selectFilter" id="f2p">
                    <option value="all">All F2P</option>
                    <option value="Free-To-Play">Free-To-Play</option>
                    <option value="NFT Required">NFT Required</option>
                    <option value="Crypto Required">Crypto Required</option>
                    <option value="Game Required">Game Required</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <select class="form-control select2 selectFilter" id="minimum_investment">
                    <option value="all">All Min Investment</option>
                    <option value="0,500">less than 500</option>
                    <option value="501,1000">501-1000</option>
                    <option value="1001,5000">1001-5000</option>
                    <option value="5001,10000">5001-10,000</option>
                    <option value="10001,20000">10,001-20,000</option>
                    <option value="20001,50000">20,001-50,000</option>
                    <option value="50000">more than 50,000</option>
                  </select>
                </div>
              </div>
              @if(Auth::check())
                    @if($request->user()->isAdmin())
                    <div class="row mt-1">
                      <div class="col-md-2">
                        <select class="form-control select2 selectFilter" id="is_approved">
                          <option value="all">All Game</option>
                          <option value="1">Approved</option>
                          <option value="0">For Approval</option>
                        </select>
                      </div>
                    </div>
                  @endif
                @endif
            </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
        <table class="datatables-basic table" id="game_table">
          <thead>
            <tr>
              <th class="px-1">Rank</th>
              <th>Name</th>
              <th>Genre</th>
              <th>Blockchains</th>
              <th>Devices</th>
              <th>Status</th>
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
                  data.f2p = $("#f2p").val();
                  data.minimum_investment = $("#minimum_investment").val();
                  data.filter = $("#filter").val();
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
                  data.f2p = $("#f2p").val();
                  data.minimum_investment = $("#minimum_investment").val();
                  data.is_approved = $("#is_approved").val();
                  data.filter = $("#filter").val();
              }
          };
      @endif
    @endif
    var columnns = [
              { data: 'rank', name: 'rank', orderable: false, searchable: false },
              { data: 'nameAndImgDisplay', name: 'name', 'orderable' : false},
              { data: 'genres', name: 'genres', 'orderable' : false},
              { data: 'blockchains', name: 'blockchains', 'orderable' : false},
              { data: 'devices', name: 'devices', 'orderable' : false},
              { data: 'status', name: 'status', 'orderable' : false},
              { data: 'f2p', name: 'f2p', 'orderable' : false},
              { data: 'minimum_investment_formatted', name: 'minimum_investment'},
              { data: 'ratings', name: 'ratings', 'orderable' : false},
          ];
    @if(Auth::check())
      @if($request->user()->isAdmin())
        var columnns = [
              { data: 'rank', name: 'rank', orderable: false, searchable: false },
              { data: 'nameAndImgDisplay', name: 'name', 'orderable' : false},
              { data: 'genres', name: 'genres', 'orderable' : false},
              { data: 'blockchains', name: 'blockchains', 'orderable' : false},
              { data: 'devices', name: 'devices', 'orderable' : false},
              { data: 'status', name: 'status', 'orderable' : false},
              { data: 'f2p', name: 'f2p', 'orderable' : false},
              { data: 'minimum_investment_formatted', name: 'minimum_investment', 'orderable' : false},
              { data: 'ratings', name: 'ratings', 'orderable' : false},
              { data: 'action', name: 'action', 'orderable' : false}
          ];
      @endif
    @endif
      @if(Auth::check())
        var buttons = [{
            text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Add New Game',
            className: 'create-new btn btn-primary',
            attr: {
              'onclick': 'location.href="' + '{{ route("game.create") }}' + '"',
            }
          }];
      @endif
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

      $.get("{{ route('blockchain.get') }}", function(data, status){
        $('#blockchain').html(data);
        $('#blockchain').select2();
      });

      $.get("{{ route('genre.get') }}", function(data, status){
        $('#genre').html(data);
        $('#genre').select2();
      });

  </script>
  <script src="{{ asset('js/scripts/tables/table-datatables-basic.js') }}"></script>
  <script src="{{ asset('js/scripts/forms-validation/form-normal.js') }}"></script>
@endsection
