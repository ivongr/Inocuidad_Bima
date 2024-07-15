@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('navbar.navbar')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center"><h3>{{ __('Registro de Usuario') }}</h3></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                     
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nombre Completo') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Nombre Usuario') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" >
                            </div>
                        </div>
                        

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-form-label text-md-end">Rol:</label>
                            <div class="col-md-6">
                                <select id="role" name="role" class="form-select">
                                    <option value="empleado">Empleado</option>
                                    <option value="administrador">Administrador</option>
                                    <option value="inocuidad">Inocuidad</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class=" text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrar') }}
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
