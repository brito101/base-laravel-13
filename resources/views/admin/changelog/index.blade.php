@extends('adminlte::page')

@section('title', '- Changelog')

@php
    $current = $releases[0] ?? null;
    $date = fn(?string $value) => $value ? \Illuminate\Support\Carbon::parse($value)->format('d/m/Y') : null;
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
        <div class="container-fluid">

            {{-- About the platform --}}
            <div class="card card-outline card-primary mb-4">
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-12 col-lg-6">
                            <img src="{{ asset('img/favicon.svg') }}" alt="{{ config('app.name') }}" height="44"
                                class="mb-3">
                            <h2 class="fs-5 fw-semibold mb-1">{{ config('app.name') }}</h2>
                            @if (!empty($about['description']))
                                <p class="text-body-secondary mb-0">{{ $about['description'] }}</p>
                            @endif
                        </div>
                        <div class="col-12 col-lg-6">
                            <dl class="row mb-0 small changelog-meta">
                                @if ($current)
                                    <dt class="col-5 col-sm-4">Versão atual</dt>
                                    <dd class="col-7 col-sm-8"><span
                                            class="font-monospace">v{{ $current['version'] }}</span>
                                        @if ($date($current['date'] ?? null))
                                            <span class="text-body-secondary">· {{ $date($current['date']) }}</span>
                                        @endif
                                    </dd>
                                @endif
                                <dt class="col-5 col-sm-4">Tecnologias</dt>
                                <dd class="col-7 col-sm-8">
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach ($about['stack'] ?? [] as $tech)
                                            <span
                                                class="badge rounded-pill border text-body-secondary fw-normal">{{ $tech }}</span>
                                        @endforeach
                                    </div>
                                </dd>
                                <dt class="col-5 col-sm-4">Desenvolvimento</dt>
                                <dd class="col-7 col-sm-8">
                                    {{ $about['author'] ?? '' }}
                                    @isset($about['contact'])
                                        <a href="mailto:{{ $about['contact'] }}"
                                            class="d-block link-secondary text-decoration-none">{{ $about['contact'] }}</a>
                                    @endisset
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Releases, newest first; each one grouped by area --}}
            @foreach ($releases as $release)
                <div class="card card-outline card-primary {{ $loop->last ? '' : 'mb-4' }}">
                    <div class="card-header">
                        <h3 class="card-title d-flex flex-wrap align-items-center gap-2">
                            <span class="font-monospace fw-semibold text-primary">v{{ $release['version'] }}</span>
                            @if (!empty($release['title']))
                                <span>{{ $release['title'] }}</span>
                            @endif
                            @if ($loop->first)
                                <span
                                    class="badge rounded-pill bg-primary-subtle text-primary-emphasis border border-primary-subtle fw-normal">Atual</span>
                            @endif
                        </h3>
                        @if ($date($release['date'] ?? null))
                            <div class="card-tools">
                                <time class="small text-body-secondary"
                                    datetime="{{ $release['date'] }}">{{ $date($release['date']) }}</time>
                            </div>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        @foreach ($release['groups'] ?? ['' => $release['changes'] ?? []] as $group => $changes)
                            <section class="row g-0 px-4 py-4 {{ $loop->last ? '' : 'border-bottom' }}">
                                @if ($group !== '')
                                    <div class="col-12 col-md-4 col-xl-3 pe-md-4 mb-2 mb-md-0">
                                        <h4 class="fs-6 fw-semibold mb-0">{{ $group }}</h4>
                                    </div>
                                @endif
                                <div class="col-12 {{ $group !== '' ? 'col-md-8 col-xl-9' : '' }}">
                                    <ul class="changelog-list mb-0">
                                        @foreach ($changes as $change)
                                            <li>{{ $change }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </section>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </section>
@endsection

@push('css')
    <style>
        .changelog-meta dt {
            font-weight: 500;
            color: var(--bs-secondary-color);
        }

        .changelog-meta dd {
            margin-bottom: .75rem;
        }

        .changelog-meta dd:last-child {
            margin-bottom: 0;
        }

        .changelog-list {
            list-style: none;
            padding-left: 0;
        }

        .changelog-list li {
            position: relative;
            padding-left: 1.1rem;
            margin-bottom: .4rem;
        }

        .changelog-list li:last-child {
            margin-bottom: 0;
        }

        .changelog-list li::before {
            content: "";
            position: absolute;
            left: 0;
            top: .6em;
            width: .35rem;
            height: .35rem;
            border-radius: 50%;
            background: var(--bs-secondary-color);
            opacity: .6;
        }
    </style>
@endpush
