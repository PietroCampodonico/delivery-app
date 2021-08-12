@extends('layouts.app')
@section('content')
<div class="for-the-nav">

    <div class="container-fluid orders-part">
        <div class="my-link-container py-4">
            <a href="{{ route('orders.index') }}"><i class="fas fa-backspace"></i></a>
        </div>
        <h1>Ordine #{{ $order->id }}</h1>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <th>Piatto</th>
                    <th>Prezzo</th>
                    <th>Quantità</th>
                </thead>
                <tbody>
                    @foreach ($order->dishes as $dish)
                        <tr>
                            <td>{{ $dish->name }}</td>
                            <td>{{ $dish->price }}€</td>
                            <td>x{{ $dish->pivot->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <th>Totale</th>
                    <td>{{ $order->payment_amount }}€</td>
                </tfoot>
            </table>
        </div>
        <h1>Dati Cliente</h1>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Nome</th>
                    <td>{{ $order->customer_name }}</td>
                </tr>
                <tr>
                    <th>Telefono</th>
                    <td>{{ $order->customer_phone_number }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $order->customer_mail }}</td>
                </tr>
                <tr>
                    <th>Indirizzo</th>
                     <td>{{ $order->delivery_address }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
