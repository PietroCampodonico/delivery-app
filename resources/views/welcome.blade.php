@extends('layouts.app')
@section('content')

<div class="welcome">
    <div class="hero">
      <h1>Scegli il tuo ristorante</h1>
    </div>
    <restaurants-index></restaurants-index>

    <footer>
        <div class="container">
            <div class="my-container-flex section-container">
                <div class="section">
                    <h5>Scopri Deliveboo</h5>
                    <ul>
                        <li><a href="#">Chi siamo</a></li>
                        <li><a href="#">Ristoranti</a></li>
                        <li><a href="#">Il nostro blog</a></li>
                        <li><a href="#">Lavora con noi</a></li>
                        <li><a href="#">Altro</a></li>
                    </ul>
                </div>
                <div class="section">
                    <h5>Note Legali</h5>
                    <ul>
                        <li><a href="#">Termini & Condizioni</a></li>
                        <li><a href="#">Informativa sulla privacy</a></li>
                        <li><a href="#">Cookies</a></li>
                    </ul>
                </div>
                <div class="section">
                    <h5>Note Legali</h5>
                    <ul>
                        <li><a href="#">Contatti</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="section">
                    <h5>Scarica l'App</h5>
                    <ul>
                        <li><a href="#"><img src="{{ asset('images/app-store.png') }}" alt=""></a></li>
                        <li><a href="#"><img src="{{ asset('images/google-play.png') }}" alt=""></a></li>
                    </ul>
                </div>
            </div>
            <div class="my-container-flex bottom-banner">
                <div class="logos-container">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
                <span>© 2021 Deliveboo</span>
            </div>
        </div>
    </footer>
</div>

@endsection