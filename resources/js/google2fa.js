$(function () {
    const $toggle = $("#google2fa");

    if (! $toggle.length) {
        return;
    }

    // AdminLTE v4 renders a native Bootstrap 5 switch (a plain checkbox), so we
    // listen for the standard "change" event instead of the legacy
    // "switchChange.bootstrapSwitch" event from the old Bootstrap Switch plugin.
    $toggle.on("change", function () {
        const enabled = this.checked;

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: $(this).data("action"),
            type: "POST",
            data: {
                data: enabled ? "true" : "false",
                user: $(this).data("user"),
            },
            success: function ({ message, qrcode, seed }) {
                alert(message);
                $("#seed-container div").remove();

                if (seed) {
                    $("#seed-container").append(
                        `<div>
                            <p class="w-100 d-inline-block px-0">Semente: <span style="letter-spacing: .2rem; margin-left: 20px; font-weight: 700;">${seed}</span></p>
                            <img src="data:image/png;base64,${qrcode}" alt="QRCode" />
                        </div>`
                    );
                }
            },
            error: function () {
                alert("Falha ao atualizar o duplo fator de autenticação.");
            },
        });
    });
});
