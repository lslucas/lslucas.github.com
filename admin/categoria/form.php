  <div class='error container-error'><div class='error-icon'>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<!--<li><label for="imagem" class="error-validate">Envia a imagem da categoria</label></li> -->
		<li><label for="titulo" class="error-validate">Informe o título</label></li> 
		<!--<li><label for="area" class="error-validate">Selecione algum módulo para definir a área da categoria</label></li> -->
	</ol> 
  </div>



<form method='post' action='?<?=$_SERVER['QUERY_STRING']?>' id='form_<?=$p?>' class='form cmxform' enctype="multipart/form-data">
 <input type='hidden' name='act' value='<?=$act?>'>
<?php
  if ($act=='update')
    echo "<input type='hidden' name='item' value='${_GET['item']}'>";
?>

<h1>
<?php 
  if ($act=='insert') echo $var['insert'];
   else echo $var['update'];
?>
</h1>
<p class='header'>Todos os campos com <b>- * -</b> são obrigatórios.</p>



    <ol>


	<li>	
	  <label>Título *<span class='small'>Digite o título da obra</span></label>
	  <input type='text' name='titulo' id='titulo' class='required' value='<?=$val['titulo']?>'>
	</li>

	<input type='hidden' name='area' value=''>
	<!--
	<li>
	<label>Área *<span class='small'>Em qual módulo será disponível essa categoria</span></label>
	  <?php

	    $sql_mod = "SELECT mod_id,mod_nome, mod_path FROM ".TABLE_PREFIX."_modulo WHERE mod_status=1 AND mod_private=0";
	    $qry_mod = $conn->prepare($sql_mod);
	    $qry_mod->bind_result($id, $nome, $path);
	    $qry_mod->execute();
	   

	   $i=0;
	   while ($qry_mod->fetch()) {

	    if ($act=='update' && $val['area']==$id) {
	      $check = ' checked'; 

	    } else $check = '';


	    if ($i<>0) echo '<br>';
	  ?>
	   <input type='radio' class='required' name='area' id='area' value='<?=$id?>'<?=$check?>> <?=$nome?> 
	  <?php 
	    
	    $i++;
	    } 
	   $qry_mod->close();

	  ?>
	   
	</li>
	-->




    </ol>



    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>


