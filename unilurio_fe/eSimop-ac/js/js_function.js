
var contador = 0, contador2 = 0;


function enviar_email(item) {


    $.ajax({
              url:"Processa_docente.php",
              type:"POST",
              data:{disp:item, acao:4},
              success:function (result){

                   $('.visualizar_pl').hide();

                   $('.enviare').html(result);
                   $('.enviare').show('slow');
              }

    })
}

function send_email(dp){


	var e = $('#txtarea').val();
	var msg = $ ('#txtemail').val();
	var sh = $('#txtsenha').val();
	var btval = $('#send_email').val();


              $.ajax({

                      url:"Processa_docente.php",
                      type:"POST",
                      data:{disp:dp, txtarea:msg,txtemail:e, senha:sh, acao:5},

                      success:function(result){

						if (btval == 1){

							$('#res_sucess').html(result).fadeOut(9000);

						}else{

                            $('#resultados').html(result).fadeOut(9000);

						 }

                      }
              });
}


function sair_esimop(item) {
       window.location="../index.html?acao="+item;
}

 /* Codigo js para o primeiro login---------------------------*/

function login1(ctr){

     var un = $('#username').val();
     var pw = $('#password').val();
     $("#result").show();

        if (un != ""){

			var db = prepareDatabase();
			db.transaction(function(t){

				var query = 'SELECT COUNT(*) AS conta FROM ctr_acesso WHERE ctr_acesso.user = ? AND ctr_acesso.pass = ?';
				t.executeSql(query, [un, pw], function (t, rs) {

					if (rs.rows.item(0).conta > 0){
					
							$('#login_offline').hide();
                            $('#ctr_login_doc').show('slow');
							
                            get_vl ++; 

					 }else{

						$("#result").html("Talvez nome ou senha esteja errado").css({'color':'red','font-size':'13px','margin-top':'-1em'})
                            .fadeOut(9000);

					}

					}, function(t, e) {
						jAlert('insercao do estudante: ' + e.message);
				});
			});

		}else{
            $("#result").html("Deve preencher em todos campos de texto").css({'color':'red','fontSize':'13px', 'margin-top':'-1em'});
	    }

}

/*
 * Teste par o segundo Login popup----------------------------*/
function login2(){


		var un = $('#name').val();
		//var pw = $('#pass').val();

        if (un != ""){

            $.ajax({

          			url: "view/User_login.php",
          			type : "POST",
          			data: {username:un, acesso:1, acao: 2},
          			success: function(result){


					$("#myresultlogin").html(result)
					     .css({'font-size':'14px','color':'red', 'font-weight':'bold'});
						contador2++;

						if (contador2 > 2 ){

							jAlert("Os dados de autenticação ainda nao conferem.\n", 'Autenticação');

						}
                    }

		    });


	}else{
	    $("#myresultlogin").html("Campos obrigatorios")
		.css({'font-size':'14px','color':'red'});
    }


}

var vez = 0, tipoavaliacao, nt;

$('select#getAvaliacao').click(function (event){
    tipoavaliacao = $(this).val();
});

function abrir_tela () {

    window.location="Docente_pauta.php";
    localStorage.setItem('myval',3);
}


/**
 *Esta funcao envia o ID da nota para o php de edicao especificado no parametro;
 *  */
function  getItem(item){

	$.ajax({

		url:"Processa_edit_avaliacao.php",
		data:({idNota:item, acao:1}),
		type:"POST",
		success: function(result){

			if (result >= 0 && result <= 20){

				$('#nota').val(result);
				$('.editar_nota').show('slow');

			}else{
				alert ('O estudante ainda nao efectou o pagamento da taxa de exame de recorrencia desta forma o sistema nao permite alteracao');
				return;
			}

		},
		error: function(){
			alert ('Nao foi possivel registar!');
		}

	});


    $('#btnSave').click(function (){

        nt = $('#a_nota').val();

        $.ajax({

            url:"Processa_edit_avaliacao.php",
            type:"POST",

            data: {nota:nt, id:item, acao:4},

            success: function(data){

                $('.sucesso').html(data)
                .css({'font-size':'20','color':'red','font-family':'serif','font-weight':'bold', 'margin-bottom':'1em'})

                $('.myNotas').hide();
                $('.nextAction').show();
                $('.formularioP').hide();
            }
        })

    });

  }

function obterSexo(idsexo){
			if (idsexo == 1){
			return("Masculino");

			}else{
				return("Femenino");
			}
	}

/* --------------- Funcoes pesquisar docente ---------------------------------*/


