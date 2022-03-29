<!-- Add Payment Sidebar -->
<div class="modal modal-slide-in fade add-payment-sidebar" id="add-payment-sidebar" aria-hidden="true">
  <form action="{{ route('order.update', [$order->id]) }}" method="POST" class="form" enctype='multipart/form-data'>
    @csrf
    @method('PUT')
    <input type="hidden" name="updateMethod" value="payment">
    <div class="modal-dialog sidebar-lg">
      <div class="modal-content p-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
        <div class="modal-header mb-1">
          <h5 class="modal-title">
            <span class="align-middle">Add Payment</span>
          </h5>
        </div>
        <div class="modal-body flex-grow-1">
          <form>
            <div class="mb-1">
              @if ($order->transaction == "buy")
                <input id="balance" class="form-control" type="text" value="Total Due: ₱{{ number_format($order->total, 2) }}" disabled />
              @elseif($order->transaction == "sell")
                <input id="balance" class="form-control" type="text" value="Total Payout: ₱{{ number_format($order->total, 2) }}" disabled />
              @endif
            </div>
            <div class="mb-2">
              <label class="form-label" for="amount">Upload Payment Screenshot</label>
              <input  class="form-control" type="file" name="payment_proof">
            </div>
            <div class="d-flex flex-wrap mb-0">
              <button type="submit" class="btn btn-primary me-1 btn_save">Submit</button>
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </form>
</div>
<!-- /Add Payment Sidebar -->
