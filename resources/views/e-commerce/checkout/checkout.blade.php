@extends('e-commerce.layouts.layout')
@section('section')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active">Checkout</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Checkout Start -->
    <div class="checkout">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-inner">
                        <form action="{{ route('orderPlace') }}" method="post">
                            @csrf

                            <input type="hidden" name="sub_total" value="{{ $quotedata->subtotal }}">
                            <input type="hidden" name="shipping_cost" value="" id="shipping_cost_input">
                            <input type="hidden" name="coupon" value="{{ $quotedata->coupon }}">
                            <input type="hidden" name="total" value="" id="total_input">
                            {{-- @dd($savedAddresses); --}}
                            
                            @if ($savedAddresses->isEmpty())
                    
                            <div class="billing-address">
                                <h2>Billing Address</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Name</label>
                                        <input class="form-control" type="text" placeholder="Enter Name" name="name" value="{{old('name')}}">
                                        @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>E-mail</label>
                                        <input class="form-control" type="text" placeholder="E-mail" name="email"value="{{old('email')}}">
                                        @error('email')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>Mobile No</label>
                                        <input class="form-control" type="text" placeholder="Mobile No" name="phone"value="{{old('phone')}}">
                                        @error('phone')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>Address</label>
                                        <input class="form-control" type="text" placeholder="Address" name="address"value="{{old('address')}}">
                                        @error('address')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>Address 2</label>
                                        <input class="form-control" type="text" placeholder="Address 2" name="address2" value="{{old('address2')}}">
                                        @error('address2')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>Country</label>
                                        <select class="custom-select" name="country">
                                            <option value="">Select Country</option>
                                            <option value="united_states" {{old('country') == 'united_states' ? 'selectrd' : ''}}>United States</option>
                                            <option value="india" {{old('country') == 'india' ? 'selectrd' : ''}}>India</option>
                                            <option value="albania"{{old('country') == 'albania' ? 'selectrd' : ''}}>Albania</option>
                                            <option value="algeria"{{old('country') == 'algeria' ? 'selectrd' : ''}}>Algeria</option>
                                        </select>
                                        @error('country')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>City</label>
                                        <input class="form-control" type="text" placeholder="City" name="city" value="{{old('city')}}">
                                        @error('city')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>State</label>
                                        <input class="form-control" type="text" placeholder="State" name="state" value="{{old('state')}}">
                                        @error('state')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>ZIP Code</label>
                                        <input class="form-control" type="text" placeholder="ZIP Code" name="zip_code" value="{{old('zip_code')}}">
                                        @error('zip_code')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="newaccount">
                                            <label class="custom-control-label" for="newaccount">Create an account</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="shipto" name="shipto">
                                            <label class="custom-control-label" for="shipto">Ship to different address</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="shipping-address">
                                <h2>Shipping Address</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Name</label>
                                        <input class="form-control" type="text" placeholder="Enter Name" name="shipping_name" value="{{old('shipping_name')}}">
                                        @error('shipping_name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>E-mail</label>
                                        <input class="form-control" type="text" placeholder="E-mail" name="shipping_email" value="{{old('shipping_email')}}">
                                        @error('shipping_email')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>Mobile No</label>
                                        <input class="form-control" type="text" placeholder="Mobile No" name="shipping_phone" value="{{old('shipping_phone')}}">
                                        @error('shipping_phone')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>Address</label>
                                        <input class="form-control" type="text" placeholder="Address" name="shipping_address" value="{{old('shipping_address')}}">
                                        @error('shipping_address')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>Address 2</label>
                                        <input class="form-control" type="text" placeholder="Address 2" name="shipping_address2" value="{{old('shipping_address2')}}">
                                        @error('shipping_address2')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>Country</label>
                                        <select class="custom-select" name="shipping_country">
                                            <option>Select Country</option>
                                            <option value="united_states" {{old('shipping_country') == 'united_states' ? 'selected' : ''}}>United States</option>
                                            <option value="india" {{old('shipping_country') == 'india' ? 'selected' : ''}}>India</option>
                                            <option value="albania" {{old('shipping_country') == 'albania' ? 'selected' : ''}}>Albania</option>
                                            <option value="algeria" {{old('shipping_country') == 'algeria' ? 'selected' : ''}}>Algeria</option>
                                        </select>
                                        @error('shipping_country')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>City</label>
                                        <input class="form-control" type="text" placeholder="City" name="shipping_city" value="{{old('shipping_city')}}">
                                        @error('shipping_city')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>State</label>
                                        <input class="form-control" type="text" placeholder="State" name="shipping_state" value="{{old('shipping_state')}}">
                                        @error('shipping_state')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>ZIP Code</label>
                                        <input class="form-control" type="text" placeholder="ZIP Code" name="shipping_zip_code" value="{{old('shipping_zip_code')}}">
                                        @error('shipping_zip_code')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                      
                            @else
                            <div class="billing-address">
                                <h2>Billing Address</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Select Address</label>
                                        <select id="billingAddressDropdown" name="billing_address_id" class="custom-select" onchange="showBillingAddressFields()">
                                            <option>Select Address</option>
                                            @foreach($savedAddresses as $address)
                                            @if ($address->address_type == 'billing_address')
                                                <option value="{{ $address->id }}">{{ $address->name }} - {{ $address->address }}</option>
                                            @endif 
                                            @endforeach
                                            <option id="new" value="">New Address</option>
                                        </select>
                                        
                                    </div>
                                </div>
                                <div id="billingAddressFields" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Name</label>
                                            <input class="form-control" type="text" placeholder="Enter Name" name="name" value="{{old('name')}}">
                                            @error('name')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label>E-mail</label>
                                            <input class="form-control" type="text" placeholder="E-mail" name="email"value="{{old('email')}}">
                                            @error('email')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label>Mobile No</label>
                                            <input class="form-control" type="text" placeholder="Mobile No" name="phone"value="{{old('phone')}}">
                                            @error('phone')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label>Address</label>
                                            <input class="form-control" type="text" placeholder="Address" name="address"value="{{old('address')}}">
                                            @error('address')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label>Address 2</label>
                                            <input class="form-control" type="text" placeholder="Address 2" name="address2" value="{{old('address2')}}">
                                            @error('address2')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label>Country</label>
                                            <select class="custom-select" name="country">
                                                <option>Select Country</option>
                                                <option value="united_states" {{old('country') == 'united_states' ? 'selectrd' : ''}}>United States</option>
                                                <option value="india" {{old('country') == 'india' ? 'selectrd' : ''}}>India</option>
                                                <option value="albania"{{old('country') == 'albania' ? 'selectrd' : ''}}>Albania</option>
                                                <option value="algeria"{{old('country') == 'algeria' ? 'selectrd' : ''}}>Algeria</option>
                                            </select>
                                            @error('country')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label>City</label>
                                            <input class="form-control" type="text" placeholder="City" name="city" value="{{old('city')}}">
                                            @error('city')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label>State</label>
                                            <input class="form-control" type="text" placeholder="State" name="state" value="{{old('state')}}">
                                            @error('state')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label>ZIP Code</label>
                                            <input class="form-control" type="text" placeholder="ZIP Code" name="zip_code" value="{{old('zip_code')}}">
                                            @error('zip_code')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="shiping-address">
                                <h2>Shipping Address</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Select Address</label>
                                        <select id="shippingAddressDropdown" name="shipping_address_id" class="custom-select" onchange="showShippingAddressFields()">
                                            <option value="null">Select Address</option>
                                            @foreach($savedAddresses as $address)
                                            @if ($address->address_type == 'shipping_address')
                                                <option value="{{ $address->id }}">{{ $address->name }} - {{ $address->address }}</option>
                                            @endif
                                            @endforeach
                                            <option id="new" value="">New Address</option>
                                        </select>
                                        
                                    </div>
                                    <div id="shippingAddressFields" style="display:none;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                                <input class="form-control" type="text" placeholder="Enter Name" name="shipping_name" value="{{old('shipping_name')}}">
                                                @error('shipping_name')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>E-mail</label>
                                                <input class="form-control" type="text" placeholder="E-mail" name="shipping_email" value="{{old('shipping_email')}}">
                                                @error('shipping_email')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>Mobile No</label>
                                                <input class="form-control" type="text" placeholder="Mobile No" name="shipping_phone" value="{{old('shipping_phone')}}">
                                                @error('shipping_phone')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>Address</label>
                                                <input class="form-control" type="text" placeholder="Address" name="shipping_address" value="{{old('shipping_address')}}">
                                                @error('shipping_address')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>Address 2</label>
                                                <input class="form-control" type="text" placeholder="Address 2" name="shipping_address2" value="{{old('shipping_address2')}}">
                                                @error('shipping_address2')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>Country</label>
                                                <select class="custom-select" name="shipping_country">
                                                    <option>Select Country</option>
                                                    <option value="united_states" {{old('shipping_country') == 'united_states' ? 'selected' : ''}}>United States</option>
                                                    <option value="india" {{old('shipping_country') == 'india' ? 'selected' : ''}}>India</option>
                                                    <option value="albania" {{old('shipping_country') == 'albania' ? 'selected' : ''}}>Albania</option>
                                                    <option value="algeria" {{old('shipping_country') == 'algeria' ? 'selected' : ''}}>Algeria</option>
                                                </select>
                                                @error('shipping_country')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>City</label>
                                                <input class="form-control" type="text" placeholder="City" name="shipping_city" value="{{old('shipping_city')}}">
                                                @error('shipping_city')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>State</label>
                                                <input class="form-control" type="text" placeholder="State" name="shipping_state" value="{{old('shipping_state')}}">
                                                @error('shipping_state')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>ZIP Code</label>
                                                <input class="form-control" type="text" placeholder="ZIP Code" name="shipping_zip_code" value="{{old('shipping_zip_code')}}">
                                                @error('shipping_zip_code')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>     
        
                            @endif 

                            <!-- Rest of your code -->
                    </div>
                    <div class="mb-5">
                        <h5 class="section-title position-relative text-uppercase mb-3">
                            <p class="ship-cost">Shipping Cost</p>
                        </h5>
                        <div class="bg-light p-30">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input shipping_method"
                                        name="shipping_method" value="standard_delivery" id="standard_delivery"
                                        data-cost="0">
                                    <label class="custom-control-label" for="standard_delivery">Standard Delivery
                                        (Free)</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input shipping_method"
                                        name="shipping_method" value="express_delivery" id="express_delivery"
                                        data-cost="100">
                                    <label class="custom-control-label" for="express_delivery">Express Delivery
                                        (₹100)</label>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input shipping_method"
                                        name="shipping_method" value="next_business_day" id="next_business_day"
                                        data-cost="50">
                                    <label class="custom-control-label" for="next_business_day">Next Business Day
                                        (₹50)</label>
                                </div>
                            </div>
                            @error('shipping_method')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="checkout-inner">
                        <div class="checkout-summary">
                            <h1>Cart Total</h1>
                            <p>Product Name</p>
                            <ol>
                                @foreach ($checkItems as $checkItem)
                                    <input type="hidden" name="product_id" value="{{ $checkItem->product_id }}">
                                    <li>{{ $checkItem->product->name }} ({{ $checkItem->qty }})</li>
                                @endforeach
                            </ol>
                            <p class="sub-total">Sub Total<span>₹{{ $quotedata->subtotal }}</span></p>
                            <input type="hidden" name="coupon_discount" value="{{ $quotedata->coupon_discount }}">
                            <p class="ship-cost">Coupon Amount<span>-₹{{ $quotedata->coupon_discount }}</span></p>
                            <div class="shipping-info">
                                <p class="ship-cost">Shipping Cost: <span id="cost">₹0</span></p>
                                <h2>Grand Total: <span id="total">₹{{ $quotedata->total }}</span></h2>
                            </div>
                        </div>

                        <div class="checkout-payment">
                            <div class="payment-methods">
                                <h1>Payment Methods</h1>
                                <div class="payment-method">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="payment-1" name="payment"
                                            value="paypal">
                                        <label class="custom-control-label" for="payment-1">Paypal</label>
                                    </div>
                                </div>
                                <div class="payment-method">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="payment-2" name="payment"
                                            value="Payoneer">
                                        <label class="custom-control-label" for="payment-2">Payoneer</label>
                                    </div>
                                </div>
                                <div class="payment-method">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="payment-3" name="payment"
                                            value="check_payment">
                                        <label class="custom-control-label" for="payment-3">Check Payment</label>
                                    </div>
                                </div>
                                <div class="payment-method">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="payment-4" name="payment"
                                            value="direct_bank_transfer">
                                        <label class="custom-control-label" for="payment-4">Direct Bank Transfer</label>
                                    </div>
                                </div>
                                <div class="payment-method">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="payment-5" name="payment"
                                            value="cash_on_delivery">
                                        <label class="custom-control-label" for="payment-5">Cash on Delivery</label>
                                    </div>
                                </div>
                                @error('payment')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="checkout-btn">
                                <button type="submit">Place Order</button>
                            </div>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->

@section('script')
    <script>
        $('.shipping_method').click(function() {
            const target = $(this).attr('data-cost');
            $.ajax({
                url: "{{ route('shipping_cost') }}",
                method: "POST",
                data: {
                    shipping_cost: target,
                    quote_id: "{{ $quotedata->id }}",
                    _token: "{{ csrf_token() }}"
                },
                success: function(result) {
                    $("#cost").html("₹" + result.shipping_cost);
                    $("#total").html("₹" + result.total);
                    $('#shipping_cost_input').val(result.shipping_cost);
                    $('#total_input').val(result.total);
                },
            });
        });

        function showBillingAddressFields() {
            const dropdown = document.getElementById("billingAddressDropdown");
            const fields = document.getElementById("billingAddressFields");
            fields.style.display = dropdown.options[dropdown.selectedIndex].id === "new" ? "block" : "none";

        }

        function showShippingAddressFields() {
            const dropdown = document.getElementById("shippingAddressDropdown");
            const fields = document.getElementById("shippingAddressFields");
            fields.style.display = dropdown.options[dropdown.selectedIndex].id === "new" ? "block" : "none";

        }
    </script>
@endsection
@endsection
