@inject('request', 'Illuminate\Http\Request')
@extends('layouts/contentLayoutMaster')

@section('title', 'Create Game')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
@endsection


@section('content')
<!-- // Basic Floating Label Form section start -->
<section id="basic-vertical-layouts">
  <div class="row">
      <div class="col-md-12 col-12">
          <div class="card">
              <div class="card-content">
                  <div class="card-body">
                      <form action="{{ route('game.store') }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
                          @csrf
                          <div class="form-body">
                            <div class="row">
                              <div class="col-4">
                                  <div class="form-group">
                                      <label for="name">Name:*</label>
                                      <input type="text" class="form-control" name="name" placeholder="Game Name">
                                  </div>
                              </div>
                              <div class="col-4">
                                    <div class="form-group">
                                        <label for="status">BlockChain:*<i class="ficon" data-feather="info" data-bs-toggle="tooltip" title="You can select multiple"></i></label>
                                        <select class="form-control select2" name="blockchain_ids[]" placeholder="Select BlockChain" multiple="multiple">
                                          @foreach($blockchains as $blockchain)
                                            <option value="{{ $blockchain->id }}">{{ $blockchain ->name }} ({{ $blockchain->short_name }})</option>
                                          @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="status">Genre:*<i class="ficon" data-feather="info" data-bs-toggle="tooltip" title="You can select multiple"></i></label>
                                        <select class="form-control select2" name="genre_ids[]" placeholder="Select Genre" multiple="multiple">
                                          @foreach($genres as $genre)
                                            <option value="{{ $genre->id }}">{{ $genre ->name }}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                </div>
                              </div><br>

                            <div class="row">
                              <div class="col-4">
                                  <div class="form-group">
                                      <label for="short_description">Short Description:*</label>
                                      <input type="text" class="form-control" name="short_description">
                                  </div>
                              </div>
                              <div class="col-4">
                                  <div class="form-group">
                                      <label for="image">Image:*</label>
                                      <input type="file" class="form-control" name="image">
                                  </div>
                              </div>
                              <div class="col-4">
                                  <div class="form-group">
                                      <label for="screenshots">Screenshots:<i class="ficon" data-feather="info" data-bs-toggle="tooltip" title="To select multiple hold control then select."></i></label>
                                      <input type="file" class="form-control" name="screenshots[]" multiple>
                                  </div>
                              </div>
                            </div><br>
                            <div class="row">
                              <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Description:*</label>
                                        <textarea class="form-control" rows="5" name="description" placeholder="Description">
                                        </textarea>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                              <div class="col-4">
                                    <div class="form-group">
                                        <label for="status">Status:*</label>
                                        <select class="form-control select2" name="status" placeholder="Select Status">
                                          <option value="" disabled selected></option>
                                          <option value="Live">Live</option>
                                          <option value="Presale">Presale</option>
                                          <option value="Alpha">Alpha</option>
                                          <option value="Beta">Beta</option>
                                          <option value="Development">Development</option>
                                          <option value="Cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                              <div class="col-4">
                                <div class="form-group">
                                    <label for="nft">NFT:*</label>
                                    <select class="form-control select2" name="nft" placeholder="Select NFT Type">
                                      <option value="" disabled selected></option>
                                      <option value="1">NFT Support</option>
                                      <option value="0">No NFT Support</option>
                                    </select>
                                </div>
                              </div>
                              <div class="col-4">
                                  <div class="form-group">
                                      <label for="nft">F2P:*</label>
                                      <select class="form-control select2" name="f2p" placeholder="Select f2p Type">
                                        <option value="" disabled selected></option>
                                        <option value="Free-To-Play">Free-To-Play</option>
                                        <option value="NFT Required">NFT Required</option>
                                        <option value="Crypto Required">Crypto Required</option>
                                        <option value="Game Required">Game Required</option>
                                      </select>
                                  </div>
                              </div>
                          </div><br>
                          <div class="row">
                            <div class="col-4">
                                  <div class="form-group">
                                      <label for="nft">Device:*<i class="ficon" data-feather="info" data-bs-toggle="tooltip" title="You can select multiple"></i></label>
                                      <select class="form-control select2" name="device[]" placeholder="Select device" multiple="multiple">
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
                              </div>
                          </div><br>
                          <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">Governance Token:*</label>
                                    <input type="text" class="form-control" name="governance_token" placeholder="Governance Token">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">Rewards Token:*</label>
                                    <input type="text" class="form-control" name="rewards_token" placeholder="Rewards Token">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">Minimum Investment:</label>
                                    <input type="number" class="form-control" name="minimum_investment" placeholder="Minimum Investment">
                                </div>
                            </div>
                          </div><br>
                          <div class="row">
                            <div class="col-sm-6 offset-sm-5">
                              <button type="submit" class="btn btn-primary me-1 btn_save">Submit</button>
                              <button type="reset" class="btn btn-outline-secondary">Reset</button>
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
  <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
  <script src="{{ asset('js/scripts/forms-validation/form-normal.js') }}"></script>
@endsection
@section('page-script')
<script type="text/javascript">
  // $(document).ready(function(){
    $(".select2").select2({
      width: '100%',
    });
  // });
</script>
@endsection
