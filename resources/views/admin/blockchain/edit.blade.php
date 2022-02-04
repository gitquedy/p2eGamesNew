 @inject('request', 'Illuminate\Http\Request')
<div class="modal-dialog modal-l">
    <form action="{{ route('blockchain.update', [$blockchain->id]) }}" method="POST" class="form" enctype='multipart/form-data'>
        @method('PUT')
        @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Blockchain</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-sm-6">
                <label>Name:*</label>
                <input type="text" class="form-control" name="name" value="{{ $blockchain->name }}">
              </div>
              <div class="col-sm-6">
                <label>Short Name:*</label>
                <input type="text" class="form-control" name="short_name" value="{{ $blockchain->short_name }}">
              </div>
            </div><br>
            <div class="row">
              <div class="col-sm-6">
                <label>Icon:*</label>
                <small>Currently: <a href="{{ $blockchain->imageUrl() }}" target="_blank">{{ $blockchain->icon }}</a></small>
                <input type="file" class="form-control" name="icon">
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
