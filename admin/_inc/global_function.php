<?php
/*
 *Mostra a quanto tempo foi feito/postado
 */
/* Works out the time since the entry post, takes a an argument in unix time (seconds) */
function time_since($original) {
    // array of time period chunks
    $chunks = array(
        array(60 * 60 * 24 * 365 , 'ano'),
        array(60 * 60 * 24 * 30 , 'mese'),
        array(60 * 60 * 24 * 7, 'semana'),
        array(60 * 60 * 24 , 'dia'),
        array(60 * 60 , 'hora'),
        array(60 , 'minuto'),
    );
    
    $today = time(); /* Current unix time  */
    $since = $today - $original;
    
    // $j saves performing the count function each time around the loop
    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        
        // finding the biggest chunk (if the chunk fits, break)
        if (($count = floor($since / $seconds)) != 0) {
            // DEBUG print "<!-- It's $name -->\n";
            break;
        }
    }
    
    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
    
    if ($i + 1 < $j) {
        // now getting the second item
        $seconds2 = $chunks[$i + 1][0];
        $name2 = $chunks[$i + 1][1];
        
        // add second item if it's greater than 0
        if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) !== 0) {
            $print .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
        } 
    }

    if($print=='0 minutos')
     return 'agora pouco';

     else return $print;
}



/*
 *valida email 
 */
function validaEmail($email) {


  //Run the email through an email validation filter.
  if( filter_var($email, FILTER_VALIDATE_EMAIL) ){
    return $email;


   } else {

      $good = filter_var($email, FILTER_SANITIZE_EMAIL);
      if(filter_var($good, FILTER_SANITIZE_EMAIL))
       return $good;

       else return '[email inválido]';

   }

  return $email;
}


 /*
  *REMOVE ACENTOS
  */
function limpaString($var) {

# $var = ereg_replace("[^a-zA-Z0-9 ]", "", strtr($var, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC "));

	// lowercase
	$var = ereg_replace("[áàâã]","a",$var);	
	$var = ereg_replace("[éèê]","e",$var);	
	$var = ereg_replace("[óòôõº]","o",$var);	
	$var = ereg_replace("[íìî]","i",$var);
	$var = ereg_replace("[úùûü]","u",$var);	
	$var = str_replace("ç","c",$var);
/*
	// uppercase
	$var = eregi_replace("[ÁÀÂÃ]","A",$var);	
	$var = eregi_replace("[ÉÈÊ]","E",$var);	
	$var = eregi_replace("[ÓÒÔÕ]","O",$var);	
	$var = eregi_replace("[ÍÌÎ]","I",$var);
	$var = eregi_replace("[ÚÙÛÜ]","U",$var);	
	$var = str_replace("Ç","C",$var);

	//especiais
	$var = str_replace("'\"","",$var);
*/
	return $var;
}


/*
 *CALCULA IDADE
 */
 function diferencaAnos($var,$ref) {

  $var = explode('-',$var);
  $ref = explode('-',$ref);

  list($ano,$mes,$dia)=$var;
  list($ano_atual,$mes_atual,$dia_atual)=$ref;

 if (!checkdate($mes, $dia, $ano) || !checkdate($mes_atual, $dia_atual, $ano_atual)) {
  echo '[data inválida]';
 #  echo "A data que você informou está errada <b>[ ${var[0]}/${var[1]}/${var[2]} ou ${ref[0]}/${ref[1]}/${ref[2]}]</b>";

  } else { 

   $dif = $ano_atual-$ano;

   if ($mes_atual<$mes) {
    $dif=$dif-1;

   } elseif ($mes==$mes_atual && $dia_atual<$dia) {
    $dif=$dif-1;
   } 

  return $dif;
  }

}

/*
 *REMOVE TUDO QUE NAO É NÚMERO
 */
 function apenasNumeros($var){

  return ereg_replace('^[0-9]+$','',$var);

 }

/*
 *RETORNA TIMESTAMP DA DATA EM INGLES
 */
 function en2timestamp($date,$sep='-') {


   $date = explode($sep,$date);
   $unix = mktime(0,0,0,$date[1],$date[2],$date[0]);


   return $unix;

 }



/*
 *RETORNA O DIA DA SEMANA
 */
 function date_diasemana($date,$type='') {

  if (!empty($date)) {

   #pega informações da data
   $date = en2timestamp($date);
   $wday = getdate($date);
   $wday = $wday['wday']; #usa apenas o dia da semana em números de 0 a 6

     switch($wday) {
	 case 0: $s_min = 'dom'; $s_nor = 'domingo';
       break;
	 case 1: $s_min = 'seg'; $s_nor = 'segunda';
       break;
	 case 2: $s_min = 'ter'; $s_nor = 'terça';
       break;
	 case 3: $s_min = 'qua'; $s_nor = 'quarta';
       break;
	 case 4: $s_min = 'qui'; $s_nor = 'quinta';
       break;
	 case 5: $s_min = 'sex'; $s_nor = 'sexta';
       break;
	 case 6: $s_min = 'sab'; $s_nor = 'sábado';
       break;
     }

     $return = empty($type)?$s_nor:$s_min;

   return $return;

  }

 }


function date_mes($mes, $type='') {

     switch ($mes){

	  case 1: $mes = "Janeiro"; $mes_min='Jan'; 
	    break;

	  case 2: $mes = "Fevereiro"; $mes_min='Fev';
	    break;

	  case 3: $mes = "Março"; $mes_min = 'Mar';
	    break;

	  case 4: $mes = "Abril"; $mes_min='Abr';
	    break;

	  case 5: $mes = "Maio"; $mes_min='Mai';
	    break;

	  case 6: $mes = "Junho"; $mes_min='Jun';
	    break;

	  case 7: $mes = "Julho"; $mes_min='Jul';
	    break;

	  case 8: $mes = "Agosto"; $mes_min='Ago';
	    break;

	  case 9: $mes = "Setembro"; $mes_min='Set';
	    break;

	  case 10: $mes = "Outubro"; $mes_min='Out';
	    break;

	  case 11: $mes = "Novembro"; $mes_min='Nov';
	    break;

	  case 12: $mes = "Dezembro";  $mes_min='Dez';
	    break;

     }


    if($type=='min')
     return $mes_min;
     
     else return $mes;

}


/*
 *CASO O TEXTO SEJA DE BBCODE ELE CONVERTE
 */
function txt_bbcode($var) {

 $txt = utf8_encode(html_entity_decode($var));

 return $txt;
}


# GERA PASSWORD
###############
function gera_senha($numL) {
    $chars = "?abcdefghijkmnopqrstuvwxyz023456789#";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;

     while ($i <= $numL) {
        $num = rand() % 36;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
      }

    return $pass;

}
# //GERA PASSWORD
###



# CONVERTE A DATA DO PORTUGUES PARA INGLES
##########################################
function datept2en($sep,$date,$nsep='-') {

 if (!empty($date)) {

   $date = explode($sep,$date);
   return $date[2].$nsep.$date[1].$nsep.$date[0];

 }

}

#// CONVERTE A DATA DO PORTUGUES PARA INGLES
###

# CONVERTE A DATA DO INGLES PARA PORTUGUES
##########################################
function dateen2pt($sep,$date,$nsep='-') {

 if (!empty($date)) {

   $date = explode($sep,$date);
   return $date[2].$nsep.$date[1].$nsep.$date[0];

 }

}

#// CONVERTE A DATA DO PORTUGUES PARA INGLES
###



## debug do session
function debug($var) {
	echo '<pre>'. print_r($var, 1) .'</pre>';
}



## LOG
#COMPUTA TUDO NA TABELA DE LOG
###############################
function logquery() {
 global $conn;

 if (!isset($_SESSION['user'])) {
     $userdata = array(
      'id' => '',
      'nome' => '',
      'email' => '',
      'senha' => '',
      'ip' => $_SERVER['REMOTE_ADDR'],
      'host' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
      'useragent' => $_SERVER['HTTP_USER_AGENT']
     );
     
     foreach($userdata as $k=>$v) {
      $log[$k]=$v;
     }


 } else {

     foreach($_SESSION['user'] as $k=>$v) {
      $log[$k]=$v;
     }

 }


  #computa variaveis para o log
     $server = array(
      'php_self' => $_SERVER['PHP_SELF'],
      'query_string' => $_SERVER['QUERY_STRING'],
      'request_uri' => $_SERVER['REQUEST_URI'],
      'request_time' => $_SERVER['REQUEST_TIME'],
      'http_referer' => isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:''
     );

     foreach($server as $k=>$v) {
      $slog[$k]=$v;
     }



  $sql_log = "INSERT INTO ".TABLE_PREFIX."_log 
  		(
  		 log_adm_id,
		 log_nome,
		 log_email,
		 log_senha,
		 log_php_self,
		 log_query_string,
		 log_request_uri,
		 log_request_time,
		 log_http_referer,
		 log_ip,
		 log_host,
		 log_useragent
		) VALUES (
		 ?,?,?,?,?,?,?,?,?,?,?,?
		)
	  ";
  if(($qr_log = $conn->prepare($sql_log))==false) {
   echo $conn->error();

   } else {

    $qr_log->bind_param('isssssssssss', $log['id'], $log['nome'], $log['email'], $log['senha'], $slog['php_self'], $slog['query_string'], $slog['request_uri'], $slog['request_time'], $slog['http_referer'], $log['ip'], $log['host'],$log['useragent']);
    $qr_log->execute();
    $qr_log->close();

  }

}
## //LOG
#####


## DEBUG
# grava todo tipo de erro numa tabela e pode enviar para o administrador
########
 function debuglog($numero,$texto,$errfile, $errline){
  global $conn;


  if(DEBUG==1) {

    ## VARIAVEIS DE CONFIG
     if (!isset($_SESSION['user'])) {
	 $userdata = array(
	  'id' => '',
	  'nome' => '',
	  'ip' => $_SERVER['REMOTE_ADDR'],
	  'useragent' => $_SERVER['HTTP_USER_AGENT']
	 );
	 
	 foreach($userdata as $k=>$v) {
	  $log[$k]=$v;
	 }

     } else {

	 foreach($_SESSION['user'] as $k=>$v) {
	  $log[$k]=$v;
	 }

     }




      # se DEBUG_LOG nao for vazio vai gravar no arquivo de log
      if (DEBUG_LOG<>'') {

	/*
	if(!file_exists(DEBUG_LOG)) {
	 mkdir(DEBUG_LOG,0777,true);
	}
	*/

	$ddf = fopen(DEBUG_LOG,'a');
	fwrite($ddf,"".date("r").": [$numero] $texto $errfile $errline \r\n [$log[id]]$log[nome] - $log[ip], $log[useragent] \r\n\r\n");
	fclose($ddf);

      }



      $sql_dlog = "INSERT INTO ".TABLE_PREFIX."_debuglog 
		    (
		     del_adm_id,
		     del_nome,
		     del_useragent,
		     del_ip,
		     del_err_number,
		     del_err,
		     del_err_file,
		     del_err_line
		    ) VALUES (
		     ?,?,?,?,?,?,?,?
		    )
	      ";

      if(($qr_dlog = $conn->prepare($sql_dlog))==false) {
   	echo 'erro '.$sql_dlog;
	$qr_dlog->close();
      }
     
       else { 
	$qr_dlog->bind_param('isssissi',$log['id'],$log['nome'],$log['ip'],$log['useragent'],$numero,$texto,$errfile, $errline);
	$qr_dlog->execute();
	$qr_dlog->close();
      }
 }

}
 if (DEBUG==1) 
  set_error_handler('debuglog'); 
## //DEBUG
#####
?>
