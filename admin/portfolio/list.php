<?php

$sql = "SELECT  ${var['pre']}_id,
                ${var['pre']}_titulo,
                ${var['pre']}_status,
                ${var['pre']}_data data_en,
                DATE_FORMAT(${var['pre']}_data,'%d/%m/%y') data,
                (SELECT rpi_imagem FROM ".TABLE_PREFIX."_r_${var['pre']}_imagem WHERE rpi_${var['pre']}_id=${var['pre']}_id ORDER BY rpi_pos ASC LIMIT 1) imagem 
                
		FROM ".TABLE_PREFIX."_${var['path']} 
		ORDER BY ${var['pre']}_data DESC";


 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';
  echo $conn->error;

  } else {

    #$sql->bind_param('s', $data); 
    $qry->execute();
    $qry->bind_result($id, $nome, $status, $data_en, $data, $imagem);
?>
<h1><?=$var['mono_plural']?></h1>
<p class='header'></p>

<!--
<select name='actions' class='min'>
  <option value=''>Ações</option>
  <option value='remove'>Remover</option>
  <option value='on'>Ativar</option>
  <option value='off'>Desativar</option>
</select>
<input type='button' value='aplicar' class='min'>
-->
<table class="list">
   <thead> 
      <tr>
<!--        <th width="5px"><input type='checkbox' name='check-all' value='1'></th>-->
        <th width="25px"></th>
        <th width="70px">Data</th>
        <th>Título</th>
      </tr>
   </thead>  
   <tbody>
<?php

    $j=0;
    // Para cada resultado encontrado...
    while ($qry->fetch()) {
# | <a href='$base/$p?item=$id' title="Veja no site" class='tip view' style="cursor:pointer;">Ver</a>
$delete_images = "&prefix=r_${var['pre']}_imagem&pre=rpi&col=imagem&folder=${var['imagem_folderlist']}";
$row_actions = <<<end
<a href='?p=$p&delete&item=$id${delete_images}&noVisual' title="Clique para remover o ítem selecionado" class='tip trash' style="cursor:pointer;" id="${id}" name='$nome'>Remover</a> | <a href="?p=$p&update&item=$id" title='Clique para editar o ítem selecionado' class='tip edit'>Editar</a>
end;

$row_actions .= <<<end
 | <a href="?p=${p}&status&item=${id}&noVisual" title="Clique para alterar o status do ítem selecionado" class="tip status status${id}" style="cursor:pointer;" id="${id}" name="${nome}">
end;

   if ($status==1)
     $row_actions .= '<font color="#000000">Ativo</font>'; 
     
     else $row_actions .= '<font color="#999999">Pendente</font>';


$row_actions .= '</a>';

#   $row_actions .= ' | <a href="?p=galeria&update&obr='.$id.'" title="Clique para editar ou incluir fotos para o ítem selecionado" class="tip fotos">Fotos</a>';


$permissoes='';
?>
      <tr id="tr<?=$id?>">
<!--        <td><input type='checkbox' name='check' value='1'></td>-->
        <td>
        <center>
	  <a id='ima<?=$j?>' href="$im<?=$j?>?width=100%" class="betterTip" style="cursor:pointer;">
	    <img src="images/lupa.gif">
	  </a>
	  
	  <div id="im<?=$j?>" style="float:left;display:none">
	      <?php 
	        $arquivo = substr($var['path_thumb'],0).'/'.$imagem;
		if (is_file($arquivo)) 
		  echo "<img src='{$arquivo}'>";

		  else 
		   echo 'sem imagem';
	      ?>
	  </div>
	</center>

	</td>
        <td><?=$data?></td>
        <td>
	
	<?=$nome?>
	<?php if (!empty($cat)) echo '<br/><i>'.$cat.'</i>'; ?>
	<div class='row-actions'><?=$row_actions?></div></td>

      </tr>



<?php
     $j++;
    }

    $qry->close();
?>
    <tbody>
    </table>

<?php

  }
?>

