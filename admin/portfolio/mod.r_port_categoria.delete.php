<?php
 if (!isset($res)) {

  foreach($_GET as $chave=>$valor) {
   $res[$chave] = $valor;
  }

 }

 
     $apagado=$erro_apagar=$nao_apagado=0;
     $sql_rem = "DELETE FROM ".TABLE_PREFIX."_r_port_categoria WHERE rpc_port_id=?";
     $qry_rem = $conn->prepare($sql_rem);
     $qry_rem->bind_param('i',$res['item']);
     $qry_rem->execute();


		if ($qry_rem) {

		   $apagado=$apagado+1;

		} else
		  $erro_apagar = $erro_apagar+1;


      if($apagado==1)
       echo "categoria apagada!<br>";
       elseif($apagado>1) echo $apagado." categorias apagadas!<br>";


      if($nao_apagado==1)
       echo "categorias <b>não</b> já não existe!<br>";
       elseif($nao_apagado>1) echo $nao_apagado." categorias já não existem!<br>";


      if($erro_apagar==1)
       echo "Erro ao tentar apagar!<br>";
       elseif($erro_apagar>1) echo $erro_apagar." erros ao tentar apagar!<br>";


     $qry_rem->close();




?>
