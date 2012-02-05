<?php

   /*
    *cabeçalho para funcoes,variaveis e conexao com a base
    */
   $rp = './admin/';
   include_once $rp.'_inc/global.php';
   //require_once $rp.'_inc/db.php';
   include_once $rp.'_inc/global_function.php';
   $host = $_SERVER['HTTP_HOST'];


   foreach($_POST as $key=>$val) {
	   $f[$key] = $val;
   }

	$msg = null;
	$f['email'] = validaEmail($f['email']);
	if(!$f['email']) $msg .='Entre com um <b>email</b> válido!<br/>';
	if(empty($f['nome'])) $msg .= 'É necessário preencher <b>Nome</b>!<br/>';
	if(empty($f['mensagem'])) $msg .= 'É necessário preencher <b>Mensagem</b>!<br/>';

	if(!is_null($msg)) die($msg);




	$mensagem = empty($f['mensagem']) ? null : '<br/><b>Mensagem</b><br>'.nl2br($f['mensagem']);

	/*
	 *variaveis para o envio de email
	 */
	$subject = utf8_decode($f['nome'].', formulário de contato');
	$fromEmail = $f['email'];
	$fromName = utf8_decode($f['nome']);
	$toEmail = 'lslucas@gmail.com';
	$toName = 'Lucas Serafim';

$message = "<center><h1>Lucas Serafim</h1></center><p><br/></p>";
$message.= <<<EMAIL
Formulário de contato.
<p>
 <h4>Dados</h4>
 <b>Nome:</b> {$f['nome']}
 <br/><b>Email:</b> {$f['email']}

{$mensagem}
</p>
EMAIL;
$message = utf8_decode($message);


	/*
	 *envio de email
	 */
	if( $host=='localhost' ) ini_set('include_path', '.:/Users/lucasserafim/Sites/Zend/library');
	else ini_set('include_path', '.:/home/content/98/8229398/html/Zend:/usr/local/Zend/share/pear');

    require_once 'Zend/Loader/Autoloader.php';
    Zend_Loader_Autoloader::getInstance();


	$config = array('auth' => 'login',
	                'username' => 'no-reply@lucasserafim.com.br',
					'password' => 'noreply#',
					'ssl'  =>'tls',
					'port' => 587);
	$transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
	Zend_Mail::setDefaultTransport($transport);


	$mail = new Zend_Mail();
	$mail->setSubject($subject);
	$mail->setFrom($fromEmail, $fromName);
	$mail->addTo($toEmail, $toName);
	$mail->setBodyHtml($message);


	if($mail->send()) {
		echo '<b>Concluído!</b> Sua mensagem foi enviada!';

	} else echo 'Houve um erro ao enviar sua mensagem, envie manualmente para '.$toEmail;
