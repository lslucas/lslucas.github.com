<?php

  foreach($_POST as $chave=>$valor) {
   $res[$chave] = $valor;
  }


  $res['data'] = datept2en('/',$res['data']);
# include de mensagens do arquivo atual
 include_once 'inc.exec.msg.php';


 ## verifica se existe um titulo/nome/email com o mesmo nome do que esta sendo inserido
 $sql_valida = "SELECT ${var['pre']}_titulo FROM ".TABLE_PREFIX."_${var['path']} WHERE ${var['pre']}_titulo=?";
 $qry_valida = $conn->prepare($sql_valida);
 $qry_valida->bind_param('s', $res['titulo']); 
 $qry_valida->execute();
 $qry_valida->store_result();

  #se existe um titulo/nome/email assim nao passa
  if ($qry_valida->num_rows<>0 && $act=='insert') {
   echo $msgDuplicado;
   $qry_valida->close();


  #se nao existe faz a inserção
  } else {

     #autoinsert
     include_once $rp.'inc.autoinsert.php';


     $sql= "UPDATE ".TABLE_PREFIX."_${var['path']} SET

  		  ${var['pre']}_titulo=?,
  		  ${var['pre']}_cli_id=?,
  		  ${var['pre']}_data=?,
  		  ${var['pre']}_descricao=?,
  		  ${var['pre']}_site=?
	";
     $sql.=" WHERE ${var['pre']}_id=?";
     $qry=$conn->prepare($sql);
     $qry->bind_param('sssssi',$res['titulo'], $res['cli_id'], $res['data'], txt_bbcode($res['descricao']), $res['site'], $res['item']); 
     $qry->execute();


   if ($qry==false) echo $msgExiste;
    else {
     
     $qry->close();
     #insere as fotos/galeria do artigo
     include_once 'mod.exec.imagem.php';

     #relaciona as categorias
     include_once 'mod.exec.categoria.php';

     echo $msgSucesso;

    }

 }
