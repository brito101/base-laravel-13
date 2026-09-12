@if ($errors->any())
    <x-adminlte-card theme="warning" title="Atenção" icon="bi bi-exclamation-triangle" removable>
        @foreach ($errors->all() as $error)
            <span class="d-block">{{ $error }}</span>
        @endforeach
    </x-adminlte-card>
@endif

@if (session('success'))
    <x-adminlte-card theme="success" title="Sucesso" icon="bi bi-hand-thumbs-up" removable>
        {{ session('success') }}
    </x-adminlte-card>
@endif

@if (session('error'))
    <x-adminlte-card theme="danger" title="Erro" icon="bi bi-exclamation-triangle" removable>
        {{ session('error') }}
    </x-adminlte-card>
@endif

@if (session('warning'))
    <x-adminlte-card theme="warning" title="Atenção" icon="bi bi-exclamation-triangle" removable>
        {{ session('warning') }}
    </x-adminlte-card>
@endif
