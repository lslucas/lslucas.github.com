<?php

  foreach($_POST as $chave=>$valor) {
   $res[$chave] = $valor;
  }


#  $res['data'] = datept2en('/',$res['data']);
# include de mensagens do arquivo atual
 include_once 'inc.exec.msg.php';


 ## verifica se existe um titulo/nome/email com o mesmo nome do que esta sendo inserido
 $sql_valida = "SELECT ${var['pre']}_nome FROM ".TABLE_PREFIX."_${var['path']} WHERE ${var['pre']}_nome=?";
 $qry_valida = $conn->prepare($sql_valida);
 $qry_valida->bind_param('s', $res['nome']); 
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

  		  ${var['pre']}_nome=?,
  		  ${var['pre']}_contato=?,
  		  ${var['pre']}_email=?,
  		  ${var['pre']}_telefone=?,
  		  ${var['pre']}_celular=?,
  		  ${var['pre']}_site=?,
  		  ${var['pre']}_endereco=?
	";
     $sql.=" WHERE ${var['pre']}_id=?";
     $qry=$conn->prepare($sql);
     $qry->bind_param('sssssssi',$res['nome'], $res['contato'], $res['email'], $res['telefone'], $res['celular'], $res['site'], $res['endereco'], $res['item']);
     $qry->execute();


   if ($qry==false) echo $msgExiste;
    else {

     $qry->close();

     echo $msgSucesso;

    }

 }
