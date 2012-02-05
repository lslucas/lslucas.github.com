<?php

$sql = "SELECT  ${var['pre']}_id,
                ${var['pre']}_video,
                ${var['pre']}_status

		FROM ".TABLE_PREFIX."_${var['path']}";


 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';
  echo $conn->error;

  } else {

    #$sql->bind_param('s', $data); 
    $qry->execute();
    $qry->bind_result($id, $video, $status);
?>
<h1><?=$var['mono_plural']?></h1>
<p class='header'></p>


<table class="list">
   <thead> 
      <tr>
        <th width="5px"></th>
        <th>Título</th>
      </tr>
   </thead>  
   <tbody>
<?php

    $j=0;
    // Para cada resultado encontrado...
    while ($qry->fetch()) {
# | <a href='$base/$p?item=$id' title="Veja no site" class='tip view' style="cursor:pointer;">Ver</a>
$row_actions = <<<end
<a href="?p=$p&update&item=1" title='Clique para trocar o vídeo de introdução' class='tip edit'>Mudar vídeo de introdução</a>
end;

$row_actions .= <<<end
 | <a href="?p=${p}&status&item=1&noVisual" title="Clique para alterar o status" class="tip status status1" style="cursor:pointer;" id="1" name="Vídeo de Introdução">
end;

   if ($status==1)
     $row_actions .= '<font color="#000000">Exibindo na home</font>'; 
     
     else $row_actions .= '<font color="#999999">Não está exibindo na home</font>';


$row_actions .= '</a>';

?>
      <tr id="tr<?=$id?>">
        <td></td>
        <td>
	
            <a href='<?=$var['path_video'].'/'.$video?>' target='_blank'>Vídeo de introdução</a>
            <div class='row-actions'><?=$row_actions?></div>

        </td>

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

