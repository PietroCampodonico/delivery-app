@extends('layouts.app')
@section('content')
<div class="for-the-nav">

<div class="container home">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between mytext bg-primary">
                    <span class="card-span">Area personale</span>
                    <span class="card-span">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="card data" >
                        <img class="img-thumbnail" src="{{ asset('storage/covers/'.auth()->user()->id .'/'.auth()->user()->cover_UR)}}">

                        <h3>Dati ristorante <span><strong>{{ Auth::user()->name }}</strong></span></h3>
 
                        <div>
                             <h6> <strong> mail: </strong></h6> 
                             <h5 class="block-user">{{ Auth::user()->email }}</h5>

                             <h6> <strong> indirizzo: </strong></h6> 
                             <h5 class="block-user">{{ Auth::user()->address }}</h5>

                             <h6> <strong> p.IVA </strong></h6> 
                             <h5 class="block-user">{{ Auth::user()->VAT }}</h5>

                        </div>
                  

                        <div class="link-container">

                            <a  class="btn btn-secondary" href="{{ route('dishes.index') }}"> 
                                <span class="card-span-2">
                                    <i class="fas fa-clipboard-list"></i>
                                    Vedi menù
                                </span>
                            </a>
                               
                            <a  class="btn btn-secondary" href="{{ route('dishes.create') }}">
                                <span class="card-span-2">
                                    <i class="fas fa-hamburger"></i>
                                    Carica nuovi piatti
                                </span>
                            </a>
                            <a  class="btn btn-secondary" href="{{ route('orders.index') }}">
                                <span class="card-span-2">
                                    <i class="fas fa-hourglass-end"></i>
                                    Storico Ordini
                                </span>
                            </a>
                        </div>

                    

                    </div>
                

                              
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
