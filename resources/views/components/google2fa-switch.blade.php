@props(['user'])

{{--
    2FA (Google Authenticator) switch, toggled via AJAX (UserController@google2fa).
    The seed and the QR Code are shown only to the user themself or to a Programador.
    Script: resources/js/google2fa.js.
--}}
@php($canSeeSeed = Auth::id() === $user->id || Auth::user()->hasRole('Programador'))

<x-adminlte-input-switch name="google2fa_secret_enabled" id="google2fa"
    label="Duplo Fator de Autenticação (Google Auth)"
    :config="['onColor' => 'primary', 'state' => (bool) $user->google2fa_secret_enabled]"
    data-action="{{ route('admin.user.google2fa') }}" data-user="{{ $user->id }}" />

<div class="col-12 px-0 mb-3" id="seed-container">
    <div>
        @if ($user->google2fa_secret_enabled && $canSeeSeed)
            <p class="w-100 d-inline-block px-0">
                Semente: <span
                    style="letter-spacing: .2rem; margin-left: 20px; font-weight: 700;">{{ $user->google2fa_secret }}</span>
            </p>
            <img alt="QRCode" src="data:image/png;base64,{{ base64_encode($user->getQRCodeInline()) }}" />
        @elseif ($user->google2fa_secret_enabled)
            <small class="text-body-secondary">O QR Code fica disponível apenas no perfil do próprio usuário.</small>
        @endif
    </div>
</div>

@pushOnce('js')
    @vite('resources/js/google2fa.js')
@endPushOnce
