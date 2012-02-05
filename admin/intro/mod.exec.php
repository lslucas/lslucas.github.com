<?php

  foreach($_POST as $chave=>$valor) {
   $res[$chave] = $valor;
  }


# include de mensagens do arquivo atual
 include_once 'inc.exec.msg.php';



     #insere as fotos/galeria do artigo
     include_once 'mod.exec.video.php';

     echo $msgSucesso;

