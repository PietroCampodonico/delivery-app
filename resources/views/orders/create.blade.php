@extends('layouts.app')
@section('content')
<div class="for-the-nav">

    @if (count($errors->all()) > 0)
        <div class="errorDiv">
                <i class="fas fa-exclamation-triangle"></i>
                
                @foreach ($errors->all() as $error)
                    <h5>{{ $error }}</h5>
                @endforeach
        </div>
    @endif


    <form action="{{ route('payment') }}" method="post" class="oreders create">
        @csrf

        <div class="signboardMobile">
            <h1>{{ $restaurant }}</h1>
        </div>

        <div class="cart-head">

            <div class="divBack">
              <a class="back-bttn" href="{{ route("welcome") }}"><i class="fas fa-backspace"></i></i> </a>
            </div>

            <div class="signboard">
                <h1>{{ $restaurant }}</h1>
            </div>

    @if (count($dishes) > 0)
            <div class="box-submit">
                <button class="my-submit my-bttns" type="submit" value="ordina" value="#ff00ff">
                    <span class="hiddenText"> Ordina adesso!</span>
                    <i class="fas fa-shopping-bag"></i>
                </button>
            </div>

        </div>

        <div class="col-to-row">
            @foreach ($dishes as $dish)
                @if ($dish->visibility == 1)

                    <div class="display-dish">
                        <div class="my-overlay">
                            <h4>{{ $dish->name }}</h4>
                        </div>

                        <div class="border-box">
                            <div class="my-mini-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="description">
                                <h6><strong>Ingredienti:</strong></h6>
                                <p class="enlight">{{ $dish->ingredients }}</p>
                                <p>{{ $dish->description }}</p>
                                <h3>{{ $dish->price }} <span class="enlight">€</span></h3>
                            </div>

                            <div class="counter-div">
                                <div class="tag-counter my-bttns">
                                    
                                    <span onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus">+</span>
                                    
                                        <input class="counter-display my-counter-input "
                                        name="dishes[{{$dish->id}}]" {{--colleziona gli esatti id che vanno sincronizzati anzichè tutti--}}
                                        type="number"
                                        placeholder="0"
                                        value="0" min="0" max="99">
                                    
                                    <span onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus">-</span>

                                </div>
                            </div>
                        </div>
                    </div>

                @endif
            @endforeach
        </div>

        <input type="hidden" name="restaurant_id" value="{{ $dishes[0]->user_id }}">
    @else
        </div>
        <div class="errorDiv">
            <i class="fas fa-exclamation-triangle"></i>
           <h3>Oops! Sembra che non ci siano piatti da poter ordinare in questo ristorante!</h3>
        </div>
    @endif
    </form>
    </div>

@endsection
