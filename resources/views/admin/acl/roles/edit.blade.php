@extends('adminlte::page')

@section('title', '- Editar Perfil')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3"><i class="bi bi-person-gear me-2"></i>Editar Perfil</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">ACL</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.role.index') }}">Perfis</a></li>
                            <li class="breadcrumb-item active">Editar Perfil</li>
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
                            <h3 class="card-title">Dados do Perfil</h3>
                        </div>

                        <form method="POST" action="{{ route('admin.role.update', ['role' => $role->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pe-md-2">
                                        <label class="form-label" for="name">Nome do Perfil</label>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Nome do Perfil" name="name"
                                            value="{{ old('name') ?? $role->name }}" required>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
