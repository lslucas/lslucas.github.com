<?php
# (SELECT rci_imagem FROM ".TABLE_PREFIX."_r_${var['pre']}_imagem WHERE rci_${var['pre']}_id=${var['pre']}_id ORDER BY rci_pos ASC LIMIT 1) imagem 
$sql = "SELECT  ${var['pre']}_id,
		${var['pre']}_titulo,
		(SELECT mod_nome FROM ".TABLE_PREFIX."_modulo WHERE mod_id=${var['pre']}_area) area,
		${var['pre']}_status
		
		FROM ".TABLE_PREFIX."_${var['path']} 
		ORDER BY ${var['pre']}_area,${var['pre']}_titulo ASC";


 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';
  echo $conn->error;

  } else {

    #$sql->bind_param('s', $data); 
    $qry->execute();
    $qry->bind_result($id, $nome, $area, $status);
?>
<h1><?=$var['mono_plural']?></h1>
<p class='header'></p>

<table class="list">
   <thead> 
      <tr>
        <th width="5px"></th>
        <th>Título</th>
        <th width="55px"></th>
      </tr>
   </thead>  
   <tbody>
<?php

    $j=0;
    // Para cada resultado encontrado...
    while ($qry->fetch()) {
# | <a href='$base/$p?item=$id' title="Veja no site" class='tip view' style="cursor:pointer;">Ver</a>
#$delete_images = "&prefix=r_${var['pre']}_imagem&pre=rci&col=imagem&folder=${var['imagem_folderlist']}";
$row_actions = <<<end
<a href='?p=$p&delete&item=$id&noVisual' title="Clique para remover o ítem selecionado" class='tip trash' style="cursor:pointer;" id="${id}" name='$nome'>Remover</a> | <a href="?p=$p&update&item=$id" title='Clique para editar o ítem selecionado' class='tip edit'>Editar</a>
end;

$permissoes='';
?>
      <tr id="tr<?=$id?>">
        <td></td>
        <td><?=$nome?>
          <div class='row-actions'><?=$row_actions?></div>
        </td>

        <td align='center'><a href='?p=<?=$p?>&status&item=<?=$id?>&noVisual' title="Clique para alterar o status do ítem selecionado" class='tip status status<?=$id?>' style="cursor:pointer;" id="<?=$id?>" name='<?=$nome?>'><?php if ($status==1) echo'<font color="#000000">Ativo</font>'; else echo '<font color="#999999">Pendente</font>'; ?></a></td>
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

