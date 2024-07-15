@extends('layouts.app')

@section('content')
    <!-- CSS de Bootstrap (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- JavaScript de Bootstrap (CDN) y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>{{ __('Bienvenido') }}</h3>
                    </div>
                    <div class="text-center">
                        <img src="{{ asset('images/bima.png') }}" alt="Login" style="width: 180px; height: 120px;" />
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">

                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end"></label>

                                <div class="col-md-4">
                                    <input id="email" type="text" placeholder="Nombre Usuario"
                                        class="form-control text-center @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end"></label>

                                <div class="col-md-4">
                                    <input id="password" type="password" placeholder="********"
                                        class="form-control text-center @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class=" text-center">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Iniciar Sesión') }}
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
