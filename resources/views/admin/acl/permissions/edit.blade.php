@extends('adminlte::page')

@section('title', '- Editar de Permissão')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3"><i class="bi bi-person-lock me-2"></i>Editar Permissão</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">ACL</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.permission.index') }}">Permissões</a></li>
                            <li class="breadcrumb-item active">Editar Permissão</li>
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

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Dados da Permissão</h3>
                        </div>

                        <form method="POST"
                            action="{{ route('admin.permission.update', ['permission' => $permission->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pe-md-2">
                                        <label for="name" class="form-label">Nome da Permissão</label>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Nome da Permissão" name="name"
                                            value="{{ old('name') ?? $permission->name }}" required>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Atualizar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
