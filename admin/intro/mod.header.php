<?php
## NOTA: CASO EM NENHUM OUTRO MODULO SEJA DEFINIDO O ARQUIVO HEADER, ESSE SERA O ARQUIVO PADRAO


# CSS INCLUIDO NO inc.header.php
//<link href="css/reset.css" rel="stylesheet" />
$include_css = <<<end
     <link rel="stylesheet" type="text/css" href="${rp}js/jGrowl-1.2.4/jquery.jgrowl.css"/>
     <link rel="stylesheet" href="${rp}js/bettertip/jquery.bettertip.css" type="text/css" />
     <style>
       div.growlUI { 
	background: url(${rp}images/warning.png) no-repeat;
	height:auto;
       } div.growlUI h1, div.growlUI h2 {
	color: white;
	padding: 5px 5px 5px 60px;
	text-align: left;
	font-family:'Tahoma';
       }     </style>
end;


# JS INCLUIDO NO inc.header.php, também pode conter codigo js <script>alert();</script>
/*
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.tipTip.js"></script>
*/
$include_js = <<<end
    <script type="text/javascript" src="${rp}js/bettertip/jquery.bettertip.js"></script>
    <script type="text/javascript" src="${rp}js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="${rp}js/jGrowl-1.2.4/jquery.jgrowl.js"></script>
    <script type="text/javascript" src="${rp}js/jquery.validate.min.js"></script>
    
    

<script>
  $(function(){
      // validação do formulario, todos os campos com a classe
      // class="required" serao validados
	var container = $('div.container-error');
	// validate the form when it is submitted
	var validator = $(".form").validate({
		errorContainer: container,
		errorClass: 'error-validate',
		errorLabelContainer: $("ol", container),
		wrapper: 'li',
		meta: "validate"
	});
      



	/* APAGA VIDEO/ARQUIVO
	************************************/
	$(".trash-video").click(function(event){
	 event.preventDefault();
  	 var id_trash = $(this).attr('id');
  	 var href_trash = $(this).attr('href');

	  $.blockUI({
	   message: "<p>Tem certeza que deseja remover?</p><br><input type='submit' value='sim' id='trash-video-sim'> <input type='button' value='não' id='trash-makingoff-nao'>"
	  });

	// ACAO AO CLICAR EM NaO
	     $("#trash-video-nao").click(function(){
	      $.unblockUI();
	      return false;
	     });


	// ACAO AO CLICAR EM SIM
	     $("#trash-video-sim").click(function(){

		// BOX DE CARREGAMENTO
		$.blockUI({
		 message: "<img src='images/loading.gif'>",
		 css: { 
                   top:  ($(window).height()-24)/2+'px', 
                   left: ($(window).width()-24)/2+'px', 
		   width: '24px' 
            	 } 
		});

		$.ajax({
			type: "POST",
			url: href_trash,
			success: function(data){
			 $.unblockUI();
			 $.growlUI('Remoção',data);  
       setTimeout("self.location.reload();",3000);
			}
		});

	     });



	});
	/* FIM: APAGA*/




   /* LISTAGEM */


	/* STATUS 
	************************************/
	$(".status").click(function(event){
	 event.preventDefault();
  	 var id_status = $(this).attr('id');
  	 var texto_status = $(this).text();
  	 var href_status  = $(this).attr('href');
  	 var nome_status  = $(this).attr('name');

		// BOX DE CARREGAMENTO
		$.blockUI({
		 message: "<img src='images/loading.gif'>",
		 css: { 
                   top:  ($(window).height()-24)/2+'px', 
                   left: ($(window).width()-24)/2+'px', 
		   width: '24px' 
            	 } 
		});

		$.ajax({
			type: "POST",
			url: href_status,
			success: function(data){
			 $.unblockUI();
			 $.growlUI('Status',data);  

			 if(texto_status=='Ativo')
			   $('.status'+id_status).html('<font color="#999999">Não está exibindo na home</font>');

			   else
			    $('.status'+id_status).html('<font color="#000000">Exibindo na home</font>');
			}
		});


	});
	/* FIM: STATUS*/



	/* MOSTRA AS ACOES AO PASSAR O MOUSE SOBRE A TR DO ÍTEM DA TABELA*/
	$('.list tr').bind('mouseenter',function(){
	 $(this).find('.row-actions').css('visibility','visible');
	}).bind('mouseleave',function(){
	 $(this).find('.row-actions').css('visibility','hidden');
	});
  });
</script>
end;

?>
