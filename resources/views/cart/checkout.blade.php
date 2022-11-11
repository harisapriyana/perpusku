@extends('index')

@section('container')
<div class="container-checkout">
  <div class="icing">
    <h2>Your Order</h2>
    <ul class="order">
      @foreach ($carts as $cart)
        <?php
          $subTotal = $cart->book->price * $cart->quantity; 
        ?>
        <li><span class="item-count">{{ $cart->quantity }} </span>&nbsp;&nbsp;<span class="item-name">{{ $cart->book->title }}</span>&nbsp;&nbsp;<span class="item-price">{{ "Rp. " . number_format($subTotal,2,',','.') }}</span></li>
      @endforeach
    </ul>
    <div class="total">{{ "Rp. " . number_format($grandTotal,2,',','.') }}</div>
  </div>
  <div class="dough">
    <h2>Payment</h2>
    <form class="form">
      <div class="inputs">
        <div class="rows">
          <div class="column card-group">
            <label class="label" for="card">Card</label>
            <input class="text-input card-input" id="card" placeholder="1234 5678 9012 3456"/>
          </div>
        </div>
        <div class="rows">
          <div class="column name-group">
            <label class="label" for="name">Name on Card</label>
            <input class="text-input name-input" id="name"/>
          </div>
          <div class="column expiry-group">
            <label class="label" for="expiry">Expiry</label>
            <input class="text-input expiry-input" id="expiry" placeholder="dd/yy"/>
          </div>
        </div>
        <div class="rows">
          <div class="column cvc-group">
            <label class="label" for="cvc">CVC/Security Code</label>
            <input class="text-input cvc-input" id="cvc"/>
          </div>
          <div class="column cvc-help">3-4 digit code. Usually on the back, by the signature.</div>
        </div>
      </div>
      <div class="buttons">
        <button class="order-button">Order</button>
      </div>
    </form>
  </div>
</div>
@endsection