@extends('adminlte::master')

@section('adminlte_css')
    <style>
        body {
            background-color: #3b3b3b !important;
        }

        .error-area {
            min-height: 100vh;
            min-height: 100dvh;
        }

        .error-content {
            max-width: 560px;
        }

        .error-content img {
            max-width: 100%;
            max-height: 50vh;
            object-fit: contain;
        }
    </style>
@stop

@section('body')
    <main class="error-area d-flex align-items-center justify-content-center px-3 py-4">
        <div class="error-content text-center">
            <img src="@yield('error_image')" alt="@yield('error_title')" class="mb-4">
            <h3 class="text-light">@yield('error_title')</h3>
            <p class="text-white-50 mb-4">@yield('error_message')</p>
            <a href="{{ route('admin.home') }}" class="btn btn-lg btn-warning">
                Retornar à página inicial
            </a>
        </div>
    </main>
@endsection
