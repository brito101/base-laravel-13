<footer class="app-footer {{ config('adminlte.classes_footer', '') }}">
    @yield('footer')
    <strong>Copyright © 2022-{{ date('Y') }} <a href="https://www.rodrigobrito.dev.br" target="_blank"
                rel="noreferrer" title="Rodrigo Brito Desenvolvedor Web">rodrigobrito.dev.br</a>.</strong>
        Todos os direitos Reservados.
        <div class="float-end d-none d-sm-inline-block">
            <b>Versão</b> 1.0.0
        </div>
</footer>
