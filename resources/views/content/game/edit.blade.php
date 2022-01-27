@inject('request', 'Illuminate\Http\Request')
<div class="modal-dialog modal-xl">
    <form action="{{ route('game.update', [$game->id]) }}" method="POST" class="form" enctype='multipart/form-data'>
        @method('PUT')
        @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Game</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="name">Name:*</label>
                    <input type="text" class="form-control" name="name" placeholder="Game Name" value="{{ $game->name }}">
                </div>
            </div>
            <div class="col-4">
                  <div class="form-group">
                      <label for="status">BlockChain:*<i class="ficon" data-feather="info" data-bs-toggle="tooltip" title="You can select multiple"></i></label>
                      <select class="form-control select2Modal" name="blockchain_ids[]" placeholder="Select BlockChain" multiple="multiple" id="blockchain">
                        @foreach($blockchains as $blockchain)
                          <option value="{{ $blockchain->id }}" {{ in_array($blockchain->id, $game_blockchains) ? 'selected' : '' }}>{{ $blockchain ->name }} ({{ $blockchain->short_name }})</option>
                        @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-4">
                  <div class="form-group">
                      <label for="status">Genre:*<i class="ficon" data-feather="info" data-bs-toggle="tooltip" title="You can select multiple"></i></label>
                      <select class="form-control select2Modal" name="genre_ids[]" placeholder="Select Genre" multiple="multiple">
                        @foreach($genres as $genre)
                          <option value="{{ $genre->id }}" {{ in_array($genre->id, $game_genres) ? 'selected' : '' }}>{{ $genre ->name }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>
            </div><br>

          <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="short_description">Short Description:*</label>
                    <input type="text" class="form-control" name="short_description" value="{{ $game->short_description }}">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="image">Image:*</label>
                    <small>Currently: <a href="{{ $game->imageUrl() }}" target="_blank">{{ $game->image }}</a></small>
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
                      <textarea class="form-control" rows="5" name="description" placeholder="Description">{{ $game->description }}</textarea>
                  </div>
              </div>
          </div><br>
          <div class="row">
            <div class="col-4">
                  <div class="form-group">
                      <label for="status">Status:*</label>
                      <select class="form-control select2Modal" name="status" placeholder="Select Status">
                        <option value="" disabled selected></option>
                        <option value="Live" {{ $game->status == 'Live' ? 'selected' : '' }}>Live</option>
                        <option value="Presale" {{ $game->status == 'Presale' ? 'selected' : '' }}>Presale</option>
                        <option value="Alpha" {{ $game->status == 'Alpha' ? 'selected' : '' }}>Alpha</option>
                        <option value="Beta" {{ $game->status == 'Beta' ? 'selected' : '' }}>Beta</option>
                        <option value="Development" {{ $game->status == 'Development' ? 'selected' : '' }}>Development</option>
                        <option value="Cancelled" {{ $game->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                      </select>
                  </div>
              </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="nft">F2P:*</label>
                    <select class="form-control select2Modal" name="f2p" placeholder="Select f2p Type">
                      <option value="Free-To-Play" {{ $game->f2p == 'Free-To-Play' ? 'selected' : '' }}>Free-To-Play</option>
                      <option value="NFT Required" {{ $game->f2p == 'NFT Required' ? 'selected' : '' }}>NFT Required</option>
                      <option value="Crypto Required" {{ $game->f2p == 'Crypto Required' ? 'selected' : '' }}>Crypto Required</option>
                      <option value="Game Required" {{ $game->f2p == 'Game Required' ? 'selected' : '' }}>Game Required</option>
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="nft">Device:*<i class="ficon" data-feather="info" data-bs-toggle="tooltip" title="You can select multiple"></i></label>
                    <select class="form-control select2Modal" name="device[]" placeholder="Select device" multiple="multiple">
                      <option value="Web" {{ in_array('Web', $device) ? 'selected' : '' }}>Web</option>
                      <option value="Android" {{ in_array('Android', $device) ? 'selected' : '' }}>Android</option>
                      <option value="IOS" {{ in_array('IOS', $device) ? 'selected' : '' }}>IOS</option>
                      <option value="Windows" {{ in_array('Windows', $device) ? 'selected' : '' }}>Windows</option>
                      <option value="Linux" {{ in_array('Linux', $device) ? 'selected' : '' }}>Linux</option>
                      <option value="Playstation" {{ in_array('Playstation', $device) ? 'selected' : '' }}>Playstation</option>
                      <option value="XBOX" {{ in_array('XBOX', $device) ? 'selected' : '' }}>XBOX</option>
                      <option value="Nintendo" {{ in_array('Nintendo', $device) ? 'selected' : '' }}>Nintendo</option>
                    </select>
                </div>
            </div>
        </div><br>
        <div class="row">
          <div class="col-4">
              <div class="form-group">
                  <label for="name">Governance Token:*</label>
                  <input type="text" class="form-control" name="governance_token" placeholder="Governance Token" value="{{ $game->governance_token }}">
              </div>
          </div>
          <div class="col-4">
              <div class="form-group">
                  <label for="name">Rewards Token:*</label>
                  <input type="text" class="form-control" name="rewards_token" placeholder="Rewards Token" value="{{ $game->rewards_token }}">
              </div>
          </div>
          <div class="col-4">
              <div class="form-group">
                  <label for="name">Minimum Investment:</label>
                  <input type="number" class="form-control" name="minimum_investment" placeholder="Minimum Investment" value="{{ $game->minimum_investment }}">
              </div>
          </div>
        </div><br>
         <div class="row">
          <div class="col-4">
              <div class="form-group">
                  <label for="name">Facebook:</label>
                  <input type="text" class="form-control" name="facebook" placeholder="https://www.facebook.com/P2EGamesPH" value="{{ $game->facebook }}">
              </div>
          </div>
          <div class="col-4">
              <div class="form-group">
                  <label for="name">Website:</label>
                  <input type="text" class="form-control" name="website" placeholder="https://p2egames.ph/" value="{{ $game->website }}">
              </div>
          </div>
          <div class="col-4">
              <div class="form-group">
                  <label for="name">Twitter:</label>
                  <input type="text" class="form-control" name="twitter" placeholder="https://twitter.com/p2egamesph" value="{{ $game->twitter }}">
              </div>
          </div>
        </div><br>
        <div class="row mb-2">
          <div class="col-4">
              <div class="form-group">
                  <label for="name">Discord:</label>
                  <input type="text" class="form-control" name="discord" placeholder="https://discord.gg/p2egamesph" value="{{ $game->discord }}">
              </div>
          </div>
          <div class="col-4">
              <div class="form-group">
                  <label for="name">Telegram:</label>
                  <input type="text" class="form-control" name="telegram" placeholder="https://t.me/p2egamesph" value="{{ $game->telegram }}">
              </div>
          </div>
          <div class="col-4">
              <div class="form-group">
                  <label for="name">Medium:</label>
                  <input type="text" class="form-control" name="medium" placeholder="https://p2egamesph.medium.com/" value="{{ $game->medium }}">
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
              <div class="form-group">
                  <label for="redflag">Redflag:</label>
                  <select class="form-control" name="redflag">
                    <option value="0" {{ $game->redflag == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $game->redflag == 1 ? 'selected' : '' }}>Yes</option>
                  </select>
              </div>
          </div>
          <div class="col-4">
              <div class="form-group">
                  <label for="rugpull">Rugpull:</label>
                  <select class="form-control" name="rugpull">
                    <option value="0" {{ $game->rugpull == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $game->rugpull == 1 ? 'selected' : '' }}>Yes</option>
                  </select>
              </div>
          </div>
        </div>
        </div>
        <div class="modal-footer">
              <button type="submit" class="btn btn-primary no-print btn_save"><i class="fa fa-save"></i> Update
              </button>
        </div>
      </div>
  </form>
</div>
<script src="{{ asset('js/scripts/forms-validation/form-modal.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $(".select2Modal").select2({
      width: '100%',
      dropdownParent: $("#view_modal")
    });
  });
</script>
