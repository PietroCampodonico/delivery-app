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
    <div id="app" class="successful my-container-flex">
        <div class="filler"></div>
        <div class="class-thumb-up">
            <i class="far fa-thumbs-up"></i>
        </div>
        <h1>ORDINE EFFETTUATO CON SUCCESSO!</h1>
        <h3>Ordine #{{ $order->id }}</h3>
        <h3>Indirizzo: {{ $order->delivery_address }}</h3>
        <h3>Tempo stimato di arrivo: 10 minuti</h3>
        <div>
            <a href="{{ route('welcome') }}">Ritorna alla pagina iniziale</a>
        </div>
    </div>
</body>

</html>
