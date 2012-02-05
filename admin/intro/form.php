  <div class='error container-error'><div class='error-icon'>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<li><label for="video" class="error-validate">Informe um arquivo flv válido</label></li> 
	</ol> 
  </div>



<form method='post' action='?<?=$_SERVER['QUERY_STRING']?>' id='form_<?=$p?>' class='form cmxform' enctype="multipart/form-data">
 <input type='hidden' name='act' value='<?=$act?>'>
<?php
  if ($act=='update')
    echo "<input type='hidden' name='item' value='1'>";
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
	  <label>Vídeo<span class='small'>Vídeo de introdução</span></label>
      <?php

        if ($act=='update' && !empty($val['video'])) {
      ?>
		    [<a href='?p=<?=$p?>&delete_video&item=<?=$_GET['item']?>&prefix=intro&pre=intro&col=video&folder=<?=$var['video_folderlist']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-video' style="cursor:pointer;" id="<?=$_GET['item']?>">remover</a>]

       <a href='<?=$var['path_makingoff']?>/<?=$val['makingoff']?>' target='_blank' style='display:inline;padding-left:10px'>
        <img src='images/lupa.gif' border='0' style='background-color:none;'>
       </a>

      <?php

        } else {

      ?>

		   <input class="" type='file' name='video' id='video' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px;">
		   <br><span class='small'>- flv; máximo <?=ini_get('post_max_size')?></span>


      <?php 

        } 

      ?>
	</li>




</ol>



    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>


