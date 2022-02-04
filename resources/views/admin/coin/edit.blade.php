 @inject('request', 'Illuminate\Http\Request')
<div class="modal-dialog modal-lg">
    <form action="{{ route('coin.update', [$coin->id]) }}" method="POST" class="form" enctype='multipart/form-data'>
        @method('PUT')
        @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Coin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-sm-6">
                <label>Name:*</label>
                <input type="text" class="form-control" name="name" value="{{ $coin->name }}">
              </div>
              <div class="col-sm-6">
                <label>Short Name:*</label>
                <input type="text" class="form-control" name="short_name" value="{{ $coin->short_name }}">
              </div>
            </div><br>
            <div class="row mb-2">
              <div class="col-sm-6">
                <label>Icon:*</label>
                <small>Currently: <a href="{{ $coin->imageUrl() }}" target="_blank">{{ $coin->icon }}</a></small>
                <input type="file" class="form-control" name="icon">
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-4">
                  <div class="form-group">
                      <label for="name">Coingecko ID</label>
                      <input type="text" class="form-control" name="coingecko_id" placeholder="Coingecko id" value="{{ $coin->coingecko_id }}">
                  </div>
              </div>

              <div class="col-4">
                  <div class="form-group">
                      <label for="name">Minimum Price</label>
                      <input type="text" class="form-control" name="minimum_price" placeholder="Minimum Price" value="{{ $coin->minimum_price }}">
                  </div>
              </div>

              <div class="col-4">
                  <div class="form-group">
                      <label for="name">Markup Price (%)</label>
                      <input type="text" class="form-control" name="markup_price" placeholder="Markup Price (%)" value="{{ $coin->markup_price }}">
                  </div>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="Active">Active</label>
                  <select class="form-control" name="isActive">
                    <option value="1" {{ $coin->isActive == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ $coin->isActive == 0 ? 'selected' : '' }}>No</option>
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
