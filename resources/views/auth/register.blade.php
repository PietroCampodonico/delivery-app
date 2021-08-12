@extends('layouts.app')
@section('content')
<div class="for-the-nav">

<div class="container register img_bg_style_register  img_bg_style_login img_bg_style_home">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register Your Restaurant') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>


                        {{-- --}}

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" required>
                            </div>
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="VAT" class="col-md-4 col-form-label text-md-right">{{ __('P.IVA') }}</label>
                            <div class="col-md-6">
                                <input id="VAT" type="text" class="form-control @error('VAT') is-invalid @enderror" name="VAT" required>
                            </div>

                            @error('VAT')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        {{-- input cover ristorante --}}

                        <div class="form-group row">

                            <label for="cover_UR" class="col-md-4 col-form-label text-md-right">{{ __('Cover Image') }}
                            </label>

                            <div class="col-md-6">
                                <label class="btn btn-primary">
                                    Scegli immagine
                                    <input id="cover_UR" type="file" name="cover_UR">
                                </label>
                            </div>
                        </div>


                        {{-- Tipologie di ristorante --}}

                        <label class="types-label">Tipologie di ristorante</label>
                        <div class="form-group row types">
                            @foreach ($types as $type)

                            <div class="form-check form-check-inline col-xl-3 col-lg-4 col-md-5">
                                <label class="form-check-label type">
                                    <input name="types[]" class="form-check-input" type="checkbox" value="{{ $type->id }}">

                                    {{ $type->name }}
                                </label>
                            </div>

                            @endforeach

                        </div>


                        {{-- --}}

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

