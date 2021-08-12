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
    <div id="app" class="orders-part">
        <nav class="navbar navbar-expand-md my-nav">
            <div class="my-container">
                <a class="my-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Deliveboo') }}
                </a>
                <button class="my-toggler"  type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span ><i class="fas fa-bars"></i></span>
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
                            <li class=" nav-item dropdown"> {{--non aggiungere my--}}
                                <a id="navbarDropdown" class="my-name dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        Torna alla home
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
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

        <main class="py-4">
            <div class="container-fluid">
                <div class="my-container-flex flex-between my-link-container">
                    <a href="{{ route('home') }}"><i class="fas fa-backspace"></i></a>
                    <h1>Riepilogo Ordini</h1>
                    <a href="#chartSec"><i class="fas fa-chart-line" aria-hidden="true"></i></a>
                </div>

                @if (count($orders) == 0)
                    <h3 class="center">Non ci sono ordini da mostrare!</h3>
                @else
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>Data</th>
                            <th>Nome Cliente</th>
                            <th>Indirizzo Cliente</th>
                            <th>Totale</th>
                            <th>Info</th>
                        </thead>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->delivery_address }}</td>
                                <td>{{ $order->payment_amount }}€</td>
                                <td><a href="{{ route('orders.show', ['order' => $order->id]) }}">Leggi tutto</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                @endif
            </div>
        </main>
    </div>

    <div class="container-fluid">
        <h3 id="chartSec" class="center">Grafico Annuale</h3>
        <div class="chart-container">
            <canvas id="chartY"></canvas>
        </div>
        <h3 class="center">Grafico dell'Ultimo Anno</h3>
        <div class="chart-container">
            <canvas id="chartM"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">
        var myChart = new Chart(
            document.getElementById('chartY'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($years) !!},
                    datasets: [{
                        label: 'Ordini',
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: {!! json_encode($ordersByYear) !!},
                    }, {
                        label: 'Incassi (€)',
                        backgroundColor: 'green',
                        borderColor: 'green',
                        data: {!! json_encode($profitByYear) !!},
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        var myChart = new Chart(
            document.getElementById('chartM'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($months) !!},
                    datasets: [{
                        label: 'Ordini',
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: {!! json_encode($ordersByMonth) !!},
                    }, {
                        label: 'Incassi (€)',
                        backgroundColor: 'green',
                        borderColor: 'green',
                        data: {!! json_encode($profitByMonth) !!},
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
    </script>
</body>

</html>
