<?php

$sql = "SELECT  ${var['pre']}_id,
                ${var['pre']}_nome,
                ${var['pre']}_contato,
                ${var['pre']}_telefone,
                ${var['pre']}_celular,
                ${var['pre']}_site,
                ${var['pre']}_status
          
		FROM ".TABLE_PREFIX."_${var['path']}
		ORDER BY ${var['pre']}_nome ";


 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';
  echo $conn->error;

  } else {

    #$sql->bind_param('s', $data); 
    $qry->execute();
    $qry->bind_result($id, $nome, $contato, $telefone, $celular, $site, $status);
?>
<h1><?=$var['mono_plural']?></h1>
<p class='header'></p>


<table class="list">
   <thead> 
      <tr>
        <th width="5px"></th>
        <th>Cliente</th>
        <th width='250px'>Contato</th>
      </tr>
   </thead>  
   <tbody>
<?php

    $j=0;
    // Para cada resultado encontrado...
    while ($qry->fetch()) {

$row_actions = <<<end
<a href='?p=$p&delete&item=$id&noVisual' title="Clique para remover o ítem selecionado" class='tip trash' style="cursor:pointer;" id="${id}" name='$nome'>Remover</a> | <a href="?p=$p&update&item=$id" title='Clique para editar o ítem selecionado' class='tip edit'>Editar</a>
end;

$row_actions .= <<<end
 | <a href="?p=${p}&status&item=${id}&noVisual" title="Clique para alterar o status do ítem selecionado" class="tip status status${id}" style="cursor:pointer;" id="${id}" name="${nome}">
end;

   if ($status==1)
     $row_actions .= '<font color="#000000">Ativo</font>'; 

     else $row_actions .= '<font color="#999999">Inativo</font>';


$row_actions .= '</a>';



$permissoes='';
?>
      <tr id="tr<?=$id?>">
        <td></td>
        <td>
          <?=$nome?>
          <?php 
            if(!empty($site))
             echo "<br/><i class='small'><a href='$site' target='_blank'>$site</a></i>";
          ?>

	        <div class='row-actions'><?=$row_actions?></div></td>
        </td>
        <td>
        <?php
         echo empty($contato)?'--':$contato;

            if(!empty($telefone) || !empty($celular))
              echo '<i class="small">';

            if(!empty($telefone))
              echo '<br/>'.$telefone;

            if(!empty($celular))
              echo '<br/>'.$celular;
        ?>
       </td>

      </tr>



<?php
     $j++;
    }

    $qry->close();
?>
    </tbody>
    </table>
<?php

    }
?>
