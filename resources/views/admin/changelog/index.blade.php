@extends('adminlte::page')

@section('title', '- Changelog')

@php
    $versions = [
        [
            'version' => '1.0.0',
            'date' => null,
            'changes' => [
                'Módulo de ACL com perfis e permissões',
                'Módulo de Usuários',
                'Duplo fator de autenticação (2FA)',
                'Autenticação via Azure SSO',
                'Changelog',
            ],
        ],
    ];

    $stack = [
        ['title' => 'Laravel', 'file' => 'laravel.svg'],
        ['title' => 'PHP', 'file' => 'php.svg'],
        ['title' => 'JavaScript', 'file' => 'javascript.svg'],
        ['title' => 'Bootstrap', 'file' => 'bootstrap.svg'],
        ['title' => 'HTML5', 'file' => 'html5.svg'],
        ['title' => 'CSS3', 'file' => 'css3.svg'],
    ];
@endphp

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3"><i class="bi bi-code-slash me-2"></i>Changelog</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Changelog</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Histórico do Sistema</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Recolher">
                        <i class="bi bi-dash-lg"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="row g-4">

                    {{-- Versionamento --}}
                    <div class="col-12 col-lg-7 order-2 order-lg-1">
                        <h4 class="mb-3"><i class="bi bi-clock-history me-2"></i>Versionamento</h4>

                        <div class="overflow-auto pe-1" style="max-height: 60vh;">
                            @foreach ($versions as $release)
                                <div class="changelog-entry position-relative ps-4 pb-4">
                                    <span class="changelog-dot"></span>

                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="badge text-bg-primary fs-6">v{{ $release['version'] }}</span>
                                        @if (!empty($release['date']))
                                            <small class="text-muted">{{ $release['date'] }}</small>
                                        @endif
                                    </div>

                                    <ul class="list-unstyled mb-0">
                                        @foreach ($release['changes'] as $change)
                                            <li class="d-flex align-items-start mb-1">
                                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                                <span>{{ $change }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Sobre --}}
                    <div class="col-12 col-lg-5 order-1 order-lg-2">
                        <x-adminlte-profile-widget name="{{ config('app.name') }}" desc="{{ env('APP_DES') }}"
                            theme="primary" img="{{ asset('img/favicon.svg') }}" layout-type="classic">

                            <x-adminlte-profile-row-item
                                title="Rodrigo Carvalho de Brito &ndash; contato@rodrigobrito.dev.br"
                                class="border-bottom border-secondary pb-2" />

                            @foreach ($stack as $tech)
                                <div class="col-4 text-center py-3">
                                    <img src="{{ asset('img/tech/' . $tech['file']) }}" alt="{{ $tech['title'] }}"
                                        width="40" height="40" class="tech-icon mb-2">
                                    <p class="fw-bold small mb-0">{{ $tech['title'] }}</p>
                                </div>
                            @endforeach
                        </x-adminlte-profile-widget>
                    </div>

                </div>
            </div>
        </div>

    </section>
@endsection

@push('css')
    <style>
        .changelog-entry {
            border-left: 2px solid var(--bs-border-color);
        }

        .changelog-entry:last-child {
            border-left-color: transparent;
            padding-bottom: 0 !important;
        }

        .changelog-dot {
            position: absolute;
            left: -0.5rem;
            top: 0.15rem;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            background-color: var(--bs-primary);
            border: 3px solid var(--bs-body-bg);
        }

        .tech-icon {
            object-fit: contain;
            transition: transform 0.15s ease-in-out;
        }

        .tech-icon:hover {
            transform: scale(1.15);
        }
    </style>
@endpush
