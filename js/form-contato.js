		$(function() {

			/*
			 *Inicio contato
			 */
			$('.enviaContato').click(function() {
				var msg = '<div style="margin-top:10px;"></div>';
				var msgm = '';

				if($('[name="nome"]').val()=='')
					msgm += '<div style="display:block;">O campo <b>Nome</b> não pode estar vazio!</div>';	
				if($('[name="email"]').val()=='')
					msgm += '<div style="display:block;">O campo <b>Email</b> não pode estar vazio!</div>';	
				if($('textarea[name="mensagem"]').val()=='')
					msgm += '<div style="display:block;">O campo <b>Mensagem</b> não pode estar vazio!</div>';	

				$(this).find('span').text('Aguarde...');

				if (msgm!='') {
					$('#contatoRetorno').html(msg+msgm);
					$(this).find('span').text('Enviar');
					return false;
				}

				var form = $('form[name="contato"]');
				$.ajax({
				 type: "POST",
				 url: form.attr('action'),
				 data: form.serialize(),
				 success: function(data) {
					data = '<div style="margin-top:20px"></div>'+data;
					$('#contatoRetorno').html(data);

					$('#contatoRetorno').delay(5000).hide('slow');
					$('.enviaContato').find('span').text('Mensagem enviada, enviar outra?');

					$('form#contato :input').val('');
					$('form#contato :textarea').val('');
				 }
				});

			});
			/*
			 *FIM contato 
			 */

		});
