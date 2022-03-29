@inject('request', 'Illuminate\Http\Request')
@extends('layouts/contentLayoutMaster')
@section('title', 'Invoice Preview')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/swiper.min.css') }}">
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
<link rel="stylesheet" href="{{asset('css/base/pages/app-invoice.css')}}">
@endsection

@section('content')
<section class="invoice-preview-wrapper">
  <div class="row invoice-preview">
    <!-- Invoice -->
    <div class="col-xl-9 col-md-8 col-12">
      <div class="card invoice-preview-card">
        <div class="card-body invoice-padding pb-0">
          <!-- Header starts -->
          <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
            <div>
              <div class="logo-wrapper">

              </div>
              @if($order->status == 1)
              <p class="card-text mb-25">Please pay within 1 hour or else your order will be automatically cancelled.</p>
              @endif
              @if($order->txid)
              <p class="card-text mb-25">{{ $order->txid }}</p>
              @endif
              <!-- <p class="card-text mb-25">San Diego County, CA 91905, USA</p> -->
              <!-- <p class="card-text mb-0">+1 (123) 456 7891, +44 (876) 543 2198</p> -->
            </div>
            <div class="mt-md-0 mt-2">
              <h4 class="invoice-title">
                {!! $order->getTransactionBadge() !!} Order
                <span class="invoice-number">#{{ $order->id }}</span>
              </h4>
              <div class="invoice-date-wrapper">
                <p class="invoice-date-title">Created at:</p>
                <p class="invoice-date">{{ $order->createdAtFormatted }}</p>
              </div>
              <div class="invoice-date-wrapper">
                <p class="invoice-date-title">Expires at:</p>
                <p class="invoice-date">{{ $order->expiredAt }}</p>
              </div>
              <div class="invoice-date-wrapper">
                <p class="invoice-date-title">Status:</p>
                <p class="invoice-date text-{{$order->statusDisplay['class']}}">{{ $order->statusDisplay['text'] }}</p>
              </div>
            </div>
          </div>
          <!-- Header ends -->
        </div>

        <hr class="invoice-spacing" />

        <!-- Address and Contact starts -->
        <div class="card-body invoice-padding pt-0">
          <div class="row invoice-spacing">
            <div class="col-xl-8 p-0">
              @if ($order->transaction == "buy")
                <h6 class="mb-2 badge badge-glow bg-danger">Send Payments To:</h6>
                <table>
                  <tbody>
                    <tr>
                      <td class="pe-1">Total Due:</td>
                      <td><span class="fw-bold badge bg-danger">{{ number_format($order->total, 2) }}</span></td>
                    </tr>
                    <tr>
                      <td class="pe-1">Provider:</td>
                      <td class="badge bg-danger">{{ $order->paymentMethod->provider }}</td>
                    </tr>
                    <tr>
                      <td class="pe-1">Name:</td>
                      <td class="badge bg-danger">{{ $order->paymentMethod->account_name }}</td>
                    </tr>
                    <tr>
                      <td class="pe-1">Number:</td>
                      <td class="badge bg-danger">{{ $order->paymentMethod->account_number }}</td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>After sending the payment, please attach proof of payment (screenshot) by clicking the <a href="#" data-bs-toggle="modal" data-bs-target="#add-payment-sidebar">"ADD PAYMENT"</a> button.</td>
                    </tr>
                  </tbody>
                </table>
              @elseif($order->transaction == "sell")
                <h6 class="mb-2">Please send your token to the following address depending on the network</h6>
                <table>
                  <tbody>
                    <tr>
                      <td class="pe-1">Binance Smartchain (BSC)</td>
                      <td><span class="fw-bold badge bg-danger">0x92A8C7112430213984D8ed3c0bc9542F515D9B3d</span></td>
                    </tr>
                    <tr>
                      <td class="pe-1">Polygon Network</td>
                      <td><span class="fw-bold badge bg-danger">0x92A8C7112430213984D8ed3c0bc9542F515D9B3d</span></td>
                    </tr>
                    <tr>
                      <td class="pe-1">Ronin Network</td>
                      <td><span class="fw-bold badge bg-danger">ronin:81718f6fa762bc9c9aa541394e060990c78cb801</span></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>After sending the tokens, please click <a href="#" data-bs-toggle="modal" data-bs-target="#add-txid-sidebar">"ADD TRANSACTION ID"</a> and put your transaction hash key/id </td>
                    </tr>
                  </tbody>
                </table>
              @endif
            </div>
            <div class="col-xl-4 p-0 mt-xl-0 mt-2">
              @if ($order->transaction == "buy")
                <h6 class="mb-2">Order To:</h6>
                <h6 class="mb-25">{{ $order->user->name }}</h6>
                <h6 class="mb-25"><span class="fw-bold badge bg-secondary">{{ $order->eth_address }}</span></h6>
                <p class="card-text mb-25">{{ $order->user->phone_number }}</p>
                <p class="card-text mb-25">{{ $order->user->email }}</p>
              @elseif ($order->transaction == "sell")
                <h6 class="mb-2">Order To:</h6>
                <h6 class="mb-25">{{ $order->user->name }}</h6>
                <h6 class="mb-25">{{ $order->notes }}</h6>
              @endif
            </div>

          </div>
        </div>
        <!-- Address and Contact ends -->

        <!-- Invoice Description starts -->
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th class="py-1">Product</th>
                <!-- <th class="py-1">Rate</th> -->
                <th class="py-1">Price</th>
                <th class="py-1">Qty</th>
                <th class="py-1 text-end">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-bottom">
                <td class="py-1">
                  <p class="card-text fw-bold mb-25">{!! $order->coin->getNameAndIconDisplay() !!}</p>
            <!--       <p class="card-text text-nowrap">
                    Developed a full stack native app using React Native, Bootstrap & Python
                  </p> -->
                </td>
       <!--          <td class="py-1">
                  <span class="fw-bold">$60.00</span>
                </td> -->
                <td class="py-1">
                  <span class="fw-bold">{{ number_format($order->priceWithMarkup, 2) }}</span>
                </td>
                <td class="py-1">{{ $order->qty }}</td>
                <td class="py-1 text-end">
                  <span class="fw-bold">₱{{ number_format($order->sub_total, 2) }}</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="card-body invoice-padding pb-1">
          <div class="row invoice-sales-total-wrapper">
            <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
    <!--           <p class="card-text mb-0">
                <span class="fw-bold">Salesperson:</span> <span class="ms-75">Alfie Solomons</span>
              </p> -->
            </div>
            <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
              <div class="invoice-total-wrapper">
                <div class="invoice-total-item">
                  <p class="invoice-total-title">Subtotal:</p>
                  <p class="invoice-total-amount">₱{{ number_format($order->sub_total, 2) }}</p>
                </div>
                <div class="invoice-total-item">
                  <p class="invoice-total-title">Transaction Fee:</p>
                  <p class="invoice-total-amount">₱{{ number_format($order->transaction_fee, 2) }}</p>
                </div>
                <div class="invoice-total-item">
                  <p class="invoice-total-title">Service Charge:</p>
                  <p class="invoice-total-amount">₱{{ $order->exchange_fix_price }}</p>
                </div>
                <hr class="my-50" />
                <div class="invoice-total-item">
                  <p class="invoice-total-title">Total:</p>
                  <p class="invoice-total-amount">₱{{ number_format($order->total, 2) }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Invoice Description ends -->


        @if($order->notes)
        <hr class="invoice-spacing" />
        <!-- Invoice Note starts -->
          <div class="card-body invoice-padding pt-0">
            <div class="row">
              <div class="col-12">
                <span class="fw-bold">Note:</span>
                <span
                  >{{ $order->notes }}</span
                >
              </div>
            </div>
          </div>
        @endif


        @if($order->payment_proof)
        <hr class="invoice-spacing" />
        <!-- Invoice Note starts -->
          <div class="card-body invoice-padding pt-0">
            <div class="row">
              <div class="col-12">
                <span class="fw-bold">Payment Screenshot:</span>
                <div class="col-12 p-1 modal_button" data-action="{{ route('order.getPaymentProof', $order) }}" style="cursor:pointer;">
                    <img class="img-thumbnail px-2" src="{{ $order->paymentUrl() }}" alt="Payment Proof" / style="height:150px">
                </div>
              </div>
            </div>
          </div>
        @endif
        <!-- Invoice Note ends -->
      </div>
    </div>
    <!-- /Invoice -->

    <!-- Invoice Actions -->
    <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">
      <div class="card">
        <div class="card-body">
<!--           <button class="btn btn-primary w-100 mb-75" data-bs-toggle="modal" data-bs-target="#send-invoice-sidebar">
            Send Invoice
          </button>
          <button class="btn btn-outline-secondary w-100 btn-download-invoice mb-75">Download</button>
          <a class="btn btn-outline-secondary w-100 mb-75" href="{{url('app/invoice/print')}}" target="_blank"> Print </a>
          <a class="btn btn-outline-secondary w-100 mb-75" href="{{url('app/invoice/edit')}}"> Edit </a> -->
          @if($order->status == 1)
          @if ($order->transaction == "buy")
            <button class="btn btn-success w-100 mb-75" data-bs-toggle="modal" data-bs-target="#add-payment-sidebar">
              Add Payment
            </button>
          @elseif($order->transaction == "sell")
            <button class="btn btn-success w-100 mb-75" data-bs-toggle="modal" data-bs-target="#add-txid-sidebar">
              Add Transaction ID
            </button>
          @endif

          @endif
          @if(in_array($order->status, ['1', '2', '3']) && $request->user()->isAdmin())
          <button class="btn btn-danger w-100 confirmation mb-75" data-action="{{ route('order.cancel', $order) }}" data-title="Are you sure to cancel this order?">
            Cancel Order
          </button>
          @endif
          @if($order->status == 2 && $request->user()->isAdmin())
          <button class="btn btn-primary w-100 confirmation mb-75" data-action="{{ route('order.confirmReceipt', $order) }}" data-title="Are you sure to Confirm Receipt?">
            Confirm Receipt
          </button>
          @endif
          @if(($order->status == 3 && $order->transaction == "buy") && $request->user()->isAdmin())
          <button class="btn btn-success w-100 mb-75" data-bs-toggle="modal" data-bs-target="#add-txid-sidebar">
            Order Complete
          </button>
          @endif
          @if(($order->status == 6 && $order->transaction == "sell") && $request->user()->isAdmin())
          <button class="btn btn-success w-100 mb-75" data-bs-toggle="modal" data-bs-target="#add-payment-sidebar">
            Order Complete
          </button>
          @endif
        </div>
      </div>
    </div>
    <!-- /Invoice Actions -->
  </div>
</section>

<!-- Send Invoice Sidebar -->
<div class="modal modal-slide-in fade" id="send-invoice-sidebar" aria-hidden="true">
  <div class="modal-dialog sidebar-lg">
    <div class="modal-content p-0">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
      <div class="modal-header mb-1">
        <h5 class="modal-title">
          <span class="align-middle">Send Invoice</span>
        </h5>
      </div>
      <div class="modal-body flex-grow-1">
        <form>
          <div class="mb-1">
            <label for="invoice-from" class="form-label">From</label>
            <input
              type="text"
              class="form-control"
              id="invoice-from"
              value="shelbyComapny@email.com"
              placeholder="company@email.com"
            />
          </div>
          <div class="mb-1">
            <label for="invoice-to" class="form-label">To</label>
            <input
              type="text"
              class="form-control"
              id="invoice-to"
              value="qConsolidated@email.com"
              placeholder="company@email.com"
            />
          </div>
          <div class="mb-1">
            <label for="invoice-subject" class="form-label">Subject</label>
            <input
              type="text"
              class="form-control"
              id="invoice-subject"
              value="Invoice of purchased Admin Templates"
              placeholder="Invoice regarding goods"
            />
          </div>
          <div class="mb-1">
            <label for="invoice-message" class="form-label">Message</label>
            <textarea
              class="form-control"
              name="invoice-message"
              id="invoice-message"
              cols="3"
              rows="11"
              placeholder="Message..."
            >
Dear Queen Consolidated,

Thank you for your business, always a pleasure to work with you!

We have generated a new invoice in the amount of $95.59

We would appreciate payment of this invoice by 05/11/2019</textarea
            >
          </div>
          <div class="mb-1">
            <span class="badge badge-light-primary">
              <i data-feather="link" class="me-25"></i>
              <span class="align-middle">Invoice Attached</span>
            </span>
          </div>
          <div class="mb-1 d-flex flex-wrap mt-2">
            <button type="button" class="btn btn-primary me-1" data-bs-dismiss="modal">Send</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /Send Invoice Sidebar -->
@include('content.order.partials.addPayment', ['order' => $order])
@include('content.order.partials.addTxid', ['order' => $order])


@endsection

@section('vendor-script')
<script src="{{asset('vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{ asset('vendors/js/extensions/swiper.min.js') }}"></script>
@endsection

@section('page-script')
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
<script type="text/javascript">
  var modalToggle = "add-payment-sidebar";
</script>
<script src="{{ asset('js/scripts/forms-validation/form-modal.js') }}"></script>
<script src="{{ asset('js/scripts/forms-validation/form-confirmation.js') }}"></script>
@endsection
