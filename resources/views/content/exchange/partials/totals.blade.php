<table class="table">
    <tr>
      <th class="text-start">Product</th>
      <th class="text-end">Total</th>
    </tr>
    <tr>
      <td class="text-start">{{ $cart['coin']->fullName }} x <b>{{ $cart['qty'] }}</b></td>
      <th class="text-end">₱{{ number_format($cart['computedPrice'], 2) }}</th>
    </tr>
    <tr>
      <td class="text-start">Subtotal</td>
      <th class="text-end">₱{{ number_format($cart['computedPrice'], 2) }}</th>
    </tr>
    <tr>
      <td class="text-start">Transaction Fee</td>
      @if ($cart['transaction'] == "buy")
        <th class="text-end">₱{{ number_format($cart['transactionFee'], 2) }}</th>
      @elseif($cart['transaction'] == "sell")
        <th class="text-end">(₱{{ number_format($cart['transactionFee'], 2) }})</th>
      @endif
    </tr>
    <tr>
      <td class="text-start">Service Charge</td>
      @if ($cart['transaction'] == "buy")
        <th class="text-end">₱{{ number_format($cart['exchangeFixPrice'], 2) }}</th>
      @elseif($cart['transaction'] == "sell")
        <th class="text-end">(₱{{ number_format($cart['exchangeFixPrice'], 2) }})</th>
      @endif
    </tr>
    <tr>
      @if ($cart['transaction'] == "buy")
        <td class="text-start">Total</td>
        <th class="text-end">₱{{ number_format($cart['total'], 2) }}</th>
      @elseif($cart['transaction'] == "sell")
        <td class="text-start">Total Payout</td>
        <th class="text-end">₱{{ number_format($cart['total'], 2) }}</th>
      @endif
    </tr>
</table>

<script type="text/javascript">
  @if(Session::has('message'))
    Swal.fire({
      icon: 'info',
      title: "{{ Session::get('message') }}",
      showConfirmButton: true,
      // timer: 1500,
      confirmButtonText: "Accept",
      showCancelButton: false,
      showClass: {
        popup: 'animate__animated animate__fadeIn'
      },
    })
    @php
    Session::forget('message');
    @endphp
  @endif
</script>
