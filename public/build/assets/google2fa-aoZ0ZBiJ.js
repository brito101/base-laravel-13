$(function(){const e=$("#google2fa");e.length&&e.on("change",function(){const t=this.checked;$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},url:$(this).data("action"),type:"POST",data:{data:t?"true":"false",user:$(this).data("user")},success:function({message:n,qrcode:o,seed:a}){alert(n),$("#seed-container div").remove(),a&&$("#seed-container").append(`<div>
                            <p class="w-100 d-inline-block px-0">Semente: <span style="letter-spacing: .2rem; margin-left: 20px; font-weight: 700;">${a}</span></p>
                            <img src="data:image/png;base64,${o}" alt="QRCode" />
                        </div>`)},error:function(){alert("Falha ao atualizar o duplo fator de autenticação.")}})})});
//# sourceMappingURL=google2fa-aoZ0ZBiJ.js.map
