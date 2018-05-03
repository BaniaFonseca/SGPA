// JavaScript Document

	/*-----------------outra sessao ----------------------------*/
	
	
	 $(document).ready(function() {
        /// Quando usuário clicar em salvar será feito todos os passo abaixo
        $('#salvar').click(function() {

            var dados = $('#cadUsuario').serialize();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'login.php',
                async: true,
                data: dados,
                success: function(response) {
                    location.reload();
                }
            });

            return false;
        });

//// aqui é o script para abrir o nosso pequeno modal

        $("a[rel=modal]").click(function(ev) {
            ev.preventDefault();

            var id = $(this).attr("href");

            var alturaTela = $(document).height();
            var larguraTela = $(window).width();

            //colocando o fundo preto
            $('#mascara').css({'width': larguraTela, 'height': alturaTela});
            $('#mascara').fadeIn(1000);
            $('#mascara').fadeTo("slow", 0.8);

            var left = ($(window).width() / 2) - ($(id).width() / 2);
            var top = ($(window).height() / 2) - ($(id).height() / 2);

            $(id).css({'top': top, 'left': left});
            $(id).show();
        });

        $("#mascara").click(function() {
            $(this).hide();
            $(".window").hide();
        });

        $('.fechar').click(function(ev) {
            ev.preventDefault();
            $("#mascara").hide();
            $(".window").hide();
        });

    });