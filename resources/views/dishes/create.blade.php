@extends('layouts.app')
@section('content')
<div class="for-the-nav container">


    @if(count($errors->all())>0) 
    <div class="errorDiv">
        <i class="fas fa-exclamation-triangle"></i>

        @foreach($errors->all() as $error)
            <h5>{{$error}}</h5>   
        @endforeach
        
    </div>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-default dishes">
        <i class="fas fa-backspace back-bttn"></i>
    </a>

    <form class="dishes create" action ="{{route('dishes.store')}}" method="post"> 
        @csrf 
            

            <div>
            <textarea name="name" class="form-control" aria-label="With textarea" rows="1" style="resize: none" placeholder="Nome piatto"></textarea>
            </div>  

            <div>               
            <textarea name="ingredients" class="form-control" aria-label="With textarea" rows="3" placeholder="Ingredienti"></textarea>
            </div>

            <div>  
            <textarea name="description" class="form-control" aria-label="With textarea" rows="6" placeholder="Breve descrizione"></textarea>
            </div>

            <div>  
            <textarea name="price" class="form-control" aria-label="With textarea" rows="1" style="resize: none" placeholder="Prezzo"></textarea>
            </div>

            <div>
                <label>Disponibilità</label>  <br>
                <input type="radio" value=1 id="" name="visibility" checked>
                <label for="1">Immediata</label> <br>
                <input type="radio" value=0 id="" name="visibility">
                <label for="0">Nascondi dal menù</label>  
            </div>

        <div>
        <input type="submit" value="Carica" class="btn btn-primary">
        </div>
    </form>
</div>
@endsection