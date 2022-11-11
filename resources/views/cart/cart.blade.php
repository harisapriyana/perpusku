@extends('index')

@section('container')
<div class="row justify-content-center pt-3">
    <div class="col-md-11">
        {{-- Awal Cart --}}
        <h1>Shopping Cart</h1>

        <div class="shopping-cart">

        <div class="column-labels">
            <label class="product-image">Image</label>
            <label class="product-details">Product</label>
            <label class="product-price-show">Price</label>
            <label class="product-quantity">Quantity</label>
            <label class="product-removal">Remove</label>
            <label class="product-line-price-show">Total</label>
        </div>
        @if($carts->count() > 0 )
            {{-- {{ $carts->count() }} --}}
            @foreach ($carts as $cart)
              
                <div class="product">
                    <div class="product-image">
                    <img src="https://source.unsplash.com/800x1200?{{ $cart->book->category->name }}" alt="{{ $cart->book->category->name }}">
                    </div>
                    <div class="product-details">
                    <div class="product-title">{{ $cart->book->title }}</div>
                        <p class="product-description">{{ $cart->book->excerpt }}</p>
                    </div>
                    <div class="product-price-show">{{ "Rp " . number_format($cart->book->price,2,',','.') }}</div>
                    <div class="product-price d-none">{{ $cart->book->price }}</div>
                    <div class="product-quantity">
                        <input type="number" value="{{ $cart->quantity }}" min="1" name="quantity">
                    </div>
                    <div class="product-removal">
                    <button class="remove-product">
                        Remove
                    </button>
                    </div>
                    <?php
                        $subTotal = $cart->book->price * $cart->quantity; 
                    ?>
                    <div class="product-line-price-show">{{ "Rp " . number_format($subTotal,2,',','.') }}</div>
                    <div class="product-line-price d-none">{{ $subTotal }}</div>
                </div>
            @endforeach
            <form action="/cart/checkout" method="POST">
            @csrf
            @method('post')
                <div class="totals">
                    <div class="totals-item">
                    <label>Subtotal</label>
                    <div class="totals-value" id="cart-subtotal"></div>
                    </div>
                    <div class="totals-item">
                    <label>Tax (5%)</label>
                    <div class="totals-value" id="cart-tax"></div>
                    </div>
                        <div class="totals-item">
                        <label>Shipping</label>
                        <div class="totals-value" id="cart-shipping"></div>
                        </div>
                            <div class="totals-item totals-item-total">
                                <label>Grand Total</label>
                                <div class="totals-value" id="cart-total">
                                </div>
                            </div>
                        </div>
                        
                    <input type="hidden" name="grandTotal" id="grandTotal">
                    <button class="checkout" type="submit">Checkout</button>
                </form>

            </div>
        @else
            <div class="text-center mt-2"><h2>Your Shopping Cart is Empty! <a href="/book" class="text-decoration-none text-dark">Add some!</a></h2></div>
        @endif
        {{-- Akhir Cart --}}
    </div>
</div>
@endsection