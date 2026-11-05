@props([
    'id' => 'password',
    'name' => 'password',
    'label' => 'Senha',
    'placeholder' => 'Senha',
    'required' => false,
    'hint' => null,
])

{{--
    Password field with client-side rules (same regex as the FormRequests),
    strength meter and show/hide toggle. Script: resources/js/password.js.
--}}
<label class="form-label" for="{{ $id }}">{{ $label }}</label>
<div class="input-group has-validation">
    <input type="password" id="{{ $id }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
        {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
        minlength="8" maxlength="100" autocomplete="new-password"
        pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}"
        title="A senha deve conter no mínimo 8 caracteres, incluindo uma letra maiúscula, uma minúscula, um número e um caractere especial."
        data-password-strength @required($required)>
    <button type="button" class="btn btn-outline-secondary" data-password-toggle="{{ $id }}"
        title="Mostrar senha" aria-label="Mostrar senha">
        <i class="bi bi-eye"></i>
    </button>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="password-strength mt-2 d-none" data-password-strength-for="{{ $id }}" aria-live="polite">
    <div class="progress" style="height: 6px;" role="progressbar" aria-label="Força da senha">
        <div class="progress-bar" style="width: 0%"></div>
    </div>
    <small class="d-block mt-1 fw-semibold" data-strength-label></small>
    <ul class="list-unstyled small mb-0 mt-1">
        <li data-rule="length"><i class="bi bi-x-circle text-danger me-1"></i>Mínimo de 8 caracteres</li>
        <li data-rule="upper"><i class="bi bi-x-circle text-danger me-1"></i>Uma letra maiúscula</li>
        <li data-rule="lower"><i class="bi bi-x-circle text-danger me-1"></i>Uma letra minúscula</li>
        <li data-rule="number"><i class="bi bi-x-circle text-danger me-1"></i>Um número</li>
        <li data-rule="special"><i class="bi bi-x-circle text-danger me-1"></i>Um caractere especial</li>
    </ul>
</div>

@if ($hint)
    <small class="d-block text-body-secondary mt-1">{{ $hint }}</small>
@endif

@pushOnce('js')
    @vite('resources/js/password.js')
@endPushOnce
