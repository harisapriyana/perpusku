@extends('index')

@section('container')
<div class="container wow fadeIn">

    <!-- Heading -->
    <h2 class="my-5 h2 text-center">Checkout Form</h2>

    <!--Grid row-->
    <div class="row">

      <!--Grid column-->
      <div class="col-md-8 mb-4">

        <!--Card-->
        <div class="card">

          <!--Card content-->
          <form class="card-body">

            <!--Grid row-->
            <div class="row">

              <!--Grid column-->
              <div class="col-form mb-5">

                <!--FullName-->
                <div class="md-form ">
                  <input type="text" id="firstName" class="form-control" value="{{ $order->user->name }}">
                  <label for="firstName" class="">Full Name</label>
                </div>

              </div>
              <!--Grid column-->


            </div>
            <!--Grid row-->

            <!--Username-->
            <div class="md-form input-group pl-0 mb-5">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">@</span>
              </div>
              <input type="text" class="form-control py-0"  value="{{ $order->user->username }}" aria-describedby="basic-addon1">
            </div>

            <!--email-->
            <div class="md-form mb-5">
              <input type="text" id="email" class="form-control"  value="{{ $order->user->email }}">
              <label for="email" class="">Email</label>
            </div>

            <!--address-->
            <div class="md-form mb-5">
              <input type="text" id="address" class="form-control" placeholder="Jalan ABC Gg DEF No 123">
              <label for="address" class="">Address</label>
            </div>

            <!--address-2-->
            <div class="md-form mb-5">
              <input type="text" id="address-2" class="form-control" placeholder="Apartment or suite">
              <label for="address-2" class="">Address 2 (optional)</label>
            </div>

            <!--Grid row-->
            <div class="row">

              <!--Grid column-->
              <div class="col-lg-4 col-md-12 mb-4">

                <label for="country">Province</label>
                <select class="custom-select d-block w-100" id="province" required>
                  <option value="">Choose...</option>
                  <option>Bali</option>
                </select>
                <div class="invalid-feedback">
                  Please select a valid country.
                </div>

              </div>
              <!--Grid column-->

              <!--Grid column-->
              <div class="col-lg-4 col-md-6 mb-4">

                <label for="state">Regency</label>
                <select class="custom-select d-block w-100" id="regency" required>
                  <option value="">Choose...</option>
                  <option>Denpasar</option>
                </select>
                <div class="invalid-feedback">
                  Please provide a valid state.
                </div>

              </div>
              <!--Grid column-->

              <!--Grid column-->
              <div class="col-lg-4 col-md-6 mb-4">

                <label for="state">District</label>
                <select class="custom-select d-block w-100" id="district" required>
                  <option value="">Choose...</option>
                  <option>Denpasar Utara</option>
                </select>
                <div class="invalid-feedback">
                  Please provide a valid state.
                </div>

              </div>
              <!--Grid column-->

              <!--Grid column-->
              <div class="col-lg-4 col-md-6 mb-4">

                <label for="state">Village</label>
                <select class="custom-select d-block w-100" id="village" required>
                  <option value="">Choose...</option>
                  <option>Peguyangan Kaja</option>
                </select>
                <div class="invalid-feedback">
                  Please provide a valid state.
                </div>

              </div>
              <!--Grid column-->

              <!--Grid column-->
              <div class="col-lg-4 col-md-6 mb-4">

                <label for="zip">Zip</label>
                <input type="text" class="form-control" id="zip" placeholder="" required>
                <div class="invalid-feedback">
                  Zip code required.
                </div>

              </div>
              <!--Grid column-->

            </div>
            <!--Grid row-->

            <hr>

            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="same-address">
              <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="save-info">
              <label class="custom-control-label" for="save-info">Save this information for next time</label>
            </div>

            <hr>

            <hr class="mb-4">
            <input type="hidden" name="snapToken" value="{{ $snapToken }}" id="snapToken">
            <button class="btn btn-primary btn-lg btn-block" type="submit" id="pay-button">Pay Now!</button>

          </form>

        </div>
        <!--/.Card-->

      </div>
      <!--Grid column-->

      <!--Grid column-->
      <div class="col-md-4 mb-4">

        <!-- Heading -->
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-muted">Your cart</span>
          <div class="alert alert-success d-none" role="alert">
          <div class="alert alert-error d-none" role="alert">
            
          </div>
        </h4>

        <!-- Cart -->
        <ul class="list-group mb-3 z-depth-1">
          @foreach ($orders as $order)
        <?php
          $subTotal = $order->book->price * $order->quantity; 
        ?>
          <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
              <h6 class="my-0">{{ $order->book->title }}</h6>
              <small class="text-muted">{{ $order->book->category->name }}</small>
            </div>
            <span class="text-muted">{{ "Rp. " . number_format($subTotal,2,',','.') }}</span>
          </li>
        {{-- <li>
          <div class="row">
            <div class="col-md-1">{{ $order->quantity }}</div>
            <div class="col-md-6">{{ $order->book->title }}</div>
            <div class="col-md-5">{{ "Rp. " . number_format($subTotal,2,',','.') }}</div>
          </div>
        </li> --}}
      @endforeach
          {{-- <li class="list-group-item d-flex justify-content-between bg-light">
            <div class="text-success">
              <h6 class="my-0">Promo code</h6>
              <small>EXAMPLECODE</small>
            </div>
            <span class="text-success">-$5</span>
          </li> --}}
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (include Tax & Shipping Fee)</span>
            <strong>{{ "Rp. " . number_format($grandTotal,2,',','.') }}</strong>
          </li>
        </ul>
        <!-- Cart -->

        <!-- Promo code -->
        <form class="card p-2">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Promo code" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="btn btn-secondary btn-md waves-effect m-0" type="button">Redeem</button>
            </div>
          </div>
        </form>
        <!-- Promo code -->

      </div>
      <!--Grid column-->

    </div>
    <!--Grid row-->

  </div>
@endsection