@extends('adminlte::page')

@section('title', '- Permissões')

@section('plugins.jQuery', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesButtons', true)

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3"><i class="bi bi-person-lock me-2"></i>Permissões</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">ACL</a></li>
                            <li class="breadcrumb-item active">Permissões</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @include('components.alert')

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                <h3 class="card-title align-self-center">Permissões Cadastradas</h3>
                                @can('Criar Permissões')
                                    <a href="{{ route('admin.permission.create') }}" title="Nova Permissão"
                                        class="btn btn-success"><i class="bi bi-plus"></i>Nova Permissão</a>
                                @endcan
                            </div>
                        </div>

                        @php
                            $heads = [
                                ['label' => 'ID', 'width' => 10],
                                'Nome',
                                ['label' => 'Ações', 'no-export' => true, 'width' => 10],
                            ];
                            $config = [
                                'ajax' => url('/admin/permission'),
                                'columns' => [
                                    ['data' => 'id', 'name' => 'id'],
                                    ['data' => 'name', 'name' => 'name'],
                                    [
                                        'data' => 'action',
                                        'name' => 'action',
                                        'orderable' => false,
                                        'searchable' => false,
                                    ],
                                ],
                                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                'autoFill' => true,
                                'processing' => true,
                                'serverSide' => true,
                                'responsive' => true,
                            ];
                        @endphp

                        <div class="card-body">
                            <x-adminlte-datatable id="table1" :heads="$heads" :heads="$heads" :config="$config"
                                striped hoverable beautify with-buttons/>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
