 @inject('request', 'Illuminate\Http\Request')
<div class="modal-dialog modal-lg">
    <form action="{{ route('paymentMethod.update', $paymentMethod->id) }}" method="POST" class="form" enctype='multipart/form-data'>
        @method('PUT')
        @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Payment Method</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row mb-2">
              <div class="col-4">
                  <div class="form-group">
                      <label>Account Name</label>
                      <input type="text" class="form-control" name="account_name" placeholder="Account Name" value="{{ $paymentMethod->account_name }}">
                  </div>
              </div>
              <div class="col-4">
                  <div class="form-group">
                      <label>Account Number</label>
                      <input type="text" class="form-control" name="account_number" placeholder="Account Number" value="{{ $paymentMethod->account_number }}">
                  </div>
              </div>
              <div class="col-4">
                  <div class="form-group">
                      <label>Provider</label>
                      <input type="text" class="form-control" name="provider" placeholder="Provider (E.g Gcash, Bdo)" value="{{ $paymentMethod->provider }}">
                  </div>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="Active">Active</label>
                  <select class="form-control" name="isActive">
                    <option value="1" {{ $paymentMethod->isActive == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ $paymentMethod->isActive == 0 ? 'selected' : '' }}>No</option>
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
