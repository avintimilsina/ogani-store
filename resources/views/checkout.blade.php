@extends('layout')

@section('content')
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Checkout</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your
                        code
                    </h6>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="checkout__form">
                <h4>Billing Details</h4>
                <form action={{ route('checkout.store') }} method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div
                                        class="checkout__input 
                                   @if ($errors->has('first_name')) invalid @endif">
                                        <p>First Name<span>*</span></p>
                                        <input type="text" name="first_name" value="{{ old('first_name') }}">
                                        <small> {{ $errors->first('first_name') }}</small>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div
                                        class="checkout__input 
                                   @if ($errors->has('last_name')) invalid @endif">
                                        <p>Last Name<span>*</span></p>
                                        <input type="text" name="last_name" value="{{ old('last_name') }}">
                                        <small> {{ $errors->first('last_name') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="checkout__input 
                                   @if ($errors->has('country')) invalid @endif">
                                <p>Country<span>*</span></p>
                                <input type="text" name="country" value="{{ old('country') }}">
                                <small> {{ $errors->first('country') }}</small>
                            </div>

                            <div
                                class="checkout__input 
                           @if ($errors->has('address')) invalid @endif">
                                <p>Address<span>*</span></p>
                                <input type="text" placeholder="Street Address" class="checkout__input__add"
                                    name="address" value="{{ old('address') }}">
                                <small> {{ $errors->first('address') }}</small>
                            </div>
                            <div class="checkout__input">
                                <p>District<span>*</span></p>
                                <input type="text" name="district" value="{{ old('district') }}">

                                <small> {{ $errors->first('district') }}</small>
                            </div>
                            <div class="checkout__input">
                                <p>Province<span>*</span></p>
                                <input type="text" name="province" value="{{ old('province') }}">
                                <small> {{ $errors->first('province') }}</small>
                            </div>
                            <div class="checkout__input">
                                <p>Postcode / ZIP<span>*</span></p>
                                <input type="text" name="zip" value="{{ old('zip') }}">
                                <small> {{ $errors->first('zip') }}</small>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Phone<span>*</span></p>
                                        <input type="text" name="phone" value="{{ old('phone') }}">
                                        <small> {{ $errors->first('phone') }}</small>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text" name="email" value="{{ old('email') }}">
                                        <small> {{ $errors->first('phone') }}</small>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Your Order</h4>
                                <div class="checkout__order__products">Products <span>Total</span></div>
                                <ul>
                                    @foreach ($items as $item)
                                        <li>{{ $item->getTitle() }} <span>{{ $item->getPrice() }}</span></li>
                                    @endforeach

                                </ul>
                                <div class="checkout__order__subtotal">Subtotal <span>{{ $subTotal }}</span></div>
                                <div class="checkout__order__total">Total <span>{{ $total }}</span></div>

                                <div class="checkout__input__checkbox">
                                    <label for="payment">
                                        Cash on delivery
                                        <input type="radio" id="payment" name="payment_gateway" value="cod"
                                            @if (old('payment_gateway') == 'cod') checked @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="khalti">
                                        Khalti
                                        <input type="radio" id="khalti" name="payment_gateway" value="khalti"
                                            @if (old('payment_gateway') == 'khalti') checked @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <button type="submit" class="site-btn">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection
