<?php
 if (!isset($res)) {

      foreach($_GET as $chave=>$valor) {
       $res[$chave] = $valor;
      }
      $res['ref'] = '_id';

 } else $res['ref'] = '_'.$var['pre'].'_id';




 $sql_field = $res['pre'].'_'.$res['col'];
 $sql_guarda = "SELECT ${res['pre']}_id id,$sql_field field FROM ".TABLE_PREFIX."_${res['prefix']} WHERE ${res['pre']}${res['ref']}=?";

 if($qry_guarda = $conn->prepare($sql_guarda)) {

     $qry_guarda->bind_param('i',$res['item']);
     $qry_guarda->execute();
     $qry_guarda->store_result();
     $qry_guarda->bind_result($id, $arq);
     $num = $qry_guarda->num_rows();
     $qry_guarda->fetch();
     $qry_guarda->close();


 } else echo $conn->error;




 if(isset($_GET['verifica'])) {

	echo $num;


  } elseif ($num<>0) {

     #variaveis de contagem de arquivos apagados ou nao
     $apagado = $nao_apagado = $erro_apagar = 0;



     $sql_rem = "UPDATE ".TABLE_PREFIX."_${res['prefix']} SET ${sql_field}='' WHERE ${res['pre']}_id=?";
     if($qry_rem = $conn->prepare($sql_rem)) {

       $qry_rem->bind_param('i', $id);
	     $qry_rem->execute();
	     $qry_rem->close();


		     $folder = explode(',',$res['folder']);
		     for($j=0;$j<count($folder);$j++) {
		      $arquivo = $folder[$j].'/'.$arq;

            if (!empty($folder[$j]) && is_file($arquivo)) {
             unlink($arquivo);
             $unlink_ok = 1;
            } else $unlink_no = 1;

         }

		   if(isset($unlink_ok)) $apagado=$apagado+1;
	 	   if(isset($unlink_no)) $nao_apagado = $nao_apagado+1;


		} else
		  $erro_apagar = $erro_apagar+1;




      if($apagado==1)
       echo "vídeo apagada!<br>";
       elseif($apagado>1) echo $apagado." vídeo apagados!<br>";


      if($nao_apagado==1)
       echo "vídeo <b>não</b> já não existe!<br>";
       elseif($nao_apagado>1) echo $nao_apagado." vídeos já não existem!<br>";


      if($erro_apagar==1)
       echo "Erro ao tentar apagar!<br>";
       elseif($erro_apagar>1) echo $erro_apagar." erros ao tentar apagar!<br>";





 } else {
   echo "Não foi possível remover o arquivo!<br>";
 }

