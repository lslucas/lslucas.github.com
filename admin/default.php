<?php 

  if(empty($_SESSION['user']['tipo'])) { 
 
 ?>
Bem-vindo(a) <b><?=$_SESSION['user']['nome']?></b>!
<p class='header'></p>

<?php 

   } else { 

?>

Bem-vindo(a) <b><?=$_SESSION['user']['nome']?></b>, confira as últimas notícias:
<p class='header'></p>
<link rel="stylesheet" href="<?=$rp?>js/bettertip/jquery.bettertip.css" type="text/css" />
<script type="text/javascript" src="<?=$rp?>js/bettertip/jquery.bettertip.js"></script>
<?php

  #QUERY DAS CATEGORIAS
 $id_usuario  = $_SESSION['user']['id'];
 $sql_cat = "SELECT rnc_not_id, 
		    cat_titulo,
		    cat_id

	   
		FROM ".TABLE_PREFIX."_r_not_categoria 
		 INNER JOIN ".TABLE_PREFIX."_categoria
		  ON cat_id=rnc_cat_id

		WHERE rnc_not_id IS NOT NULL
		  AND cat_status=1
		  AND EXISTS(SELECT null FROM ".TABLE_PREFIX."_r_adm_categoria 
			     WHERE cat_id=rac_cat_id AND rac_adm_id=$id_usuario) 
		  OR rnc_not_id IS NOT NULL
		  AND cat_status=1
		  AND rnc_send_adm_id=$id_usuario
	    ";

 if (!$qry_cat = $conn->prepare($sql_cat)) {
   echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql_cat.'</p><hr>';
   #$categoria[$id] = 'Sem categoria';

  } else {

    #$sql->bind_param('s', $data); 
    $qry_cat->execute();
    $qry_cat->bind_result($adm_id, $cat, $cat_id);
    $categoria = '';
    

       while($qry_cat->fetch()) {

	if(!isset($categoria[$adm_id]))
	 $categoria[$adm_id] = $cat;

	  else 
	    $categoria[$adm_id] .= ', '.$cat;

       }

    $qry_cat->close();


   } 






$sql = "SELECT  not_id,
		not_titulo,
		not_status,
		not_data data_en,
		DATE_FORMAT(not_data,'%d/%m/%y') data,
		(SELECT rni_imagem FROM ".TABLE_PREFIX."_r_not_imagem WHERE rni_not_id=not_id ORDER BY rni_pos ASC LIMIT 1) imagem,
		rnc_cat_id
		
		FROM ".TABLE_PREFIX."_noticia 
		
		  INNER JOIN ".TABLE_PREFIX."_r_not_categoria
		    ON rnc_not_id=not_id


		   WHERE not_status=1
		   AND EXISTS(SELECT NULL FROM ".TABLE_PREFIX."_r_adm_categoria WHERE rac_cat_id=rnc_cat_id AND rac_adm_id=$id_usuario)
		   OR not_status=1
		   AND rnc_send_adm_id=$id_usuario

		   GROUP BY not_id

		ORDER BY not_data DESC";
 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';
  echo $conn->error;

  } else {

    #$sql->bind_param('s', $data); 
    $qry->execute();
    $qry->store_result();
    $num = $qry->num_rows;
    $qry->bind_result($id, $nome, $status, $data_en, $data, $imagem, $cat_id);



    if($num==0) {
     echo 'Nenhuma notícia até o momento.';

    } else {
?>
<!--<h1>Últimas notícias</h1>
<p class='header'></p>
-->
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

    $var['path_thumb'] = PATH_IMG.'/noticia/thumb';


    $j=0;
    // Para cada resultado encontrado...
    while ($qry->fetch()) {
?>


      <tr id="tr<?=$id?>">
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
	
	<a href="?p=noticia&view&item=<?=$id?>" title='Ver notícia' class='tip edit'><?=$nome?></a>
	<!--<?php if (!empty($categoria[$id])) echo '<br/><i>'.$categoria[$id].'</i>'; ?>-->
	<div class='row-actions'><?=$row_actions?></div></td>

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

 } 


}
?>
