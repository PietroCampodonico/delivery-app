@extends('layouts.app')
@section('content')
<div class="for-the-nav">

    <div class="container dishes show">
            <a href="{{ route('dishes.index') }}"><i class="fas fa-backspace back-bttn"></i></a>
       
            <h2>{{$dish->name}} </h2>
            <h5><span>Ingredienti:</span> {{$dish->ingredients}} </h5>
            <h5><span>Descrizione:</span> {{$dish->description}} </h5>
            <h5><span>Prezzo:</span> {{$dish->price}} Euro</h5>

                @if($dish->visibility == 1)
                    <h5 class="visibility"><em>Visibile nel menù</em></h5> 
                @elseif($dish->visibility == 0)
                    <h5 class="visibility"><em>Non visibile nel menù</em></h5> 
                @endif

            
            <a href="{{ route('dishes.edit', ['dish' => $dish->id]) }}" class="btn btn-primary myBtn edit"> Modifica </a> 
            @include('layouts.deleteBtn', [ "id" => $dish->id, "resource" => "dishes" ])


    </div>
</div>
@endsection