<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">




</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md my-nav">
            <div class="my-container">
                <a class="my-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Deliveboo') }}
                </a>
                <button class="my-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span><i class="fas fa-bars"></i></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="my-nav-item">
                                <a class="my-nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="my-nav-item">
                                    <a class="my-nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class=" nav-item dropdown"> {{-- non aggiungere my --}}
                                <a id="navbarDropdown" class="my-name dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        Torna alla home
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <main class="py-4 container-fluid">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ route('checkout') }}" class="container" id="payment-form">
            @csrf
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="customer_mail">Email address</label>
                        <input type="email" class="form-control" name="customer_mail" id="customer_mail"
                            placeholder="mario.rossi@example.com">
                    </div>
                    <div class="form-group">
                        <label for="customer_phone_number">Phone number</label>
                        <input type="customer_phone_number" class="form-control" name="customer_phone_number"
                            id="customer_phone_number" placeholder="123-456-7890">
                    </div>
                    <div class="form-group">
                        <label for="customer_name">Full Name</label>
                        <input type="text" class="form-control" name="customer_name" id="customer_name"
                            placeholder="Mario Rossi">
                    </div>
                    <div class="form-group">
                        <label for="delivery_address">Delivery Address</label>
                        <input type="text" class="form-control" name="delivery_address" id="delivery_address"
                            placeholder="Via Roma 10">
                    </div>
                </div>
            </div>

            <div>
                <h4>Riepilogo Carrello</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>Piatto</th>
                            <th>Prezzo</th>
                            <th>Porzioni</th>
                        </thead>
                        <tbody>
                            @foreach ($allRestaurantDishes as $restaurantDish)
                                @foreach ($ordered_dishes as $ordered_dish => $quantity)
                                    @if ($quantity && $restaurantDish->id == $ordered_dish)
                                        <tr>
                                            <td>{{ $restaurantDish->name }}</td>
                                            <td>{{ $restaurantDish->price }}€</td>
                                            <td>{{ $quantity }}</td>
                                        </tr>
                                        <input type="hidden" name="dishes[{{ $ordered_dish }}]"
                                            value="{{ $quantity }}">
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                        <tfoot>
                            <th>Totale</th>
                            <td>{{ $amount }}€</td>
                            <input type="hidden" name="amount" value="{{ $amount }}">
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="bt-drop-in-wrapper">
                <div id="bt-dropin"></div>
            </div>

            <input id="nonce" name="payment_method_nonce" type="hidden" />
            <div class="my-container-flex flex-between">
                <a href="{{ route('orders.create', ['slug' => $restaurantSlug]) }}"><i
                        class="fas fa-backspace"></i></a>
                <button class="my-submit-btn btn btn-primary" type="submit"><span>Conferma</span></button>
            </div>
        </form>
    </main>

    <script src="https://js.braintreegateway.com/web/dropin/1.31.0/js/dropin.min.js"></script>
    <script>
        var form = document.querySelector('#payment-form');
        var client_token = "{{ $token }}";
        braintree.dropin.create({
            authorization: client_token,
            selector: '#bt-dropin',
        }, function(createErr, instance) {
            if (createErr) {
                console.log('Create Error', createErr);
                return;
            }
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                instance.requestPaymentMethod(function(err, payload) {
                    if (err) {
                        console.log('Request Payment Method Error', err);
                        return;
                    }
                    document.querySelector('#nonce').value = payload.nonce;
                    form.submit();
                });
            });
        });
    </script>
</body>

</html>
