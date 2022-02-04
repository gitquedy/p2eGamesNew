 @inject('request', 'Illuminate\Http\Request')
<div class="modal-dialog modal-xl">
    <form action="{{ route('banner.update', [$banner->id]) }}" method="POST" class="form" enctype='multipart/form-data'>
        @method('PUT')
        @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Banner</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-4">
              <div class="form-group">
                  <label for="name">Banner Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Banner Name" value="{{ $banner->name }}">
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                  <label for="delegation">Delegation</label>
                  <select class="form-control" name="delegation">
                    <option value="1" {{ $banner->delegation == 1 ? 'selected' : '' }}>Banner 1</option>
                    <option value="2" {{ $banner->delegation == 2 ? 'selected' : '' }}>Banner 2</option>
                  </select>
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                  <label for="name">Link</label>
                  <input type="text" class="form-control" name="link" placeholder="Link" value="{{ $banner->link }}">
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-4">
              <div class="form-group">
                  <label for="name">Full Image</label>
                  <small>Currently: <a target="_blank" href="{{ $banner->imageUrl($banner->full) }}"> {{ $banner->full }}</a></small>
                  <input type="file" class="form-control" name="full" placeholder="Full">
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                  <label for="name">Mobile Image</label>
                  <small>Currently: <a target="_blank" href="{{ $banner->imageUrl($banner->mobile) }}">{{ $banner->mobile }}</a></small>
                  <input type="file" class="form-control" name="mobile" placeholder="Mobile">
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                  <label for="name">Tablet Image</label>
                  <small>Currently: <a target="_blank" href="{{ $banner->imageUrl($banner->tablet) }}">{{ $banner->tablet }}</a></small>
                  <input type="file" class="form-control" name="tablet" placeholder="Tablet">
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-4">
              <div class="form-group">
                  <label for="Active">Active</label>
                  <select class="form-control" name="isActive">
                    <option value="1" {{ $banner->isActive == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ $banner->isActive == 0 ? 'selected' : '' }}>No</option>
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
