  <div class='error container-error'><div class='error-icon'>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<li><label for="cli_id" class="error-validate">Selecione um cliente</label></li> 
		<li><label for="cat_id" class="error-validate">Selecione uma categoria</label></li> 
		<li><label for="imagem" class="error-validate">Imagem do trabalho</label></li> 
		<li><label for="titulo" class="error-validate">Informe o título</label></li> 
		<li><label for="data" class="error-validate">Entre com uma data válida</label></li> 
		<li><label for="makingoff" class="error-validate">Informe um arquivo flv válido</label></li> 
		<li><label for="descricao" class="error-validate">Descrição do trabalho</label></li> 
		<li><label for="site" class="error-validate">Informe uma url válida</label></li> 
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
	  <label>Cliente *<span class='small'>Selecione o cliente</span></label>
      <select name='cli_id' id='cli_id' class='required'/>
        <option value=''>Selecione</option>
        <?php
          $statusCat=1;
          $sql_cli = "SELECT cli_id, cli_nome, cli_contato
                        FROM ".TABLE_PREFIX."_cliente 
                        WHERE cli_status=?";

          $qry_cli = $conn->prepare($sql_cli);
          $qry_cli->bind_param('i', $statusCat);
          $qry_cli->execute();
          $qry_cli->bind_result($cli_id, $cli_nome, $cli_contato);


            $i=0;
            while ($qry_cli->fetch()) {

             if ($act=='update') {
              $selected = ($val['cli_id']==$cli_id)?' selected':'';

              } else $selected = '';


            $cli_contato = empty($cli_contato)?'':' - '.$cli_contato;

        ?>
	        <option value='<?=$cli_id?>'<?=$selected?>> <?=$cli_nome.$cli_contato?></option>
        <?php 

            $i++;
            } 
           $qry_cli->close();
        ?>
    </select>
	</li>


	<li>	
	  <label>Categoria *<span class='small'>Categorias do trabalho</span></label>
	  <?php
	    $statusCat=1;


		if($act=='insert') 
		  $sql_categoria = "SELECT cat_id, 
								   cat_titulo
								   
			  						FROM ".TABLE_PREFIX."_categoria 
        						WHERE cat_status=?";

		  else
			$sql_categoria = "SELECT cat_id, 
									 cat_titulo,
									 (SELECT COUNT(rpc_id) FROM ".TABLE_PREFIX."_r_port_categoria WHERE rpc_cat_id=cat_id and rpc_port_id='".$val['id']."') checked
									 
									  FROM ".TABLE_PREFIX."_categoria 
						        WHERE cat_status=?";

	    $qry_categoria = $conn->prepare($sql_categoria);
	    $qry_categoria->bind_param('i', $statusCat);
	    $qry_categoria->execute();

		 if($act=='insert')
	       $qry_categoria->bind_result($id, $nome);

		   else $qry_categoria->bind_result($id, $nome, $checked);




	      $i=0;
	      while ($qry_categoria->fetch()) {

	       if ($act=='update') {
	        $check[$id] = ($checked>0)?' checked':''; 

	        } else $check[$id] = '';


	       if ($i<>0) echo '<br>';
	  ?>

	        <input type='radio' class='required' name='cat_id' id='cat_id' value='<?=$id?>'<?=$check[$id]?>> <?=$nome?> 

	  <?php 

	    $i++;
	    } 
	   $qry_categoria->close();
	  ?>
	   
	</li>



	<li>	
	  <label>Imagens *<span class='small'><a href='javascript:void(0);' class='addImagem' id='min'>adicionar + imagens</a></span></label>
	  <?php
		  
	    if ($act=='update') {
				  
		    $sql_gal = "SELECT rpi_id,rpi_imagem,rpi_pos FROM ".TABLE_PREFIX."_r_${var['pre']}_imagem WHERE rpi_${var['pre']}_id=? AND rpi_imagem IS NOT NULL ORDER BY rpi_pos ASC;"; 
		    $qr_gal = $conn->prepare($sql_gal);
		    $qr_gal->bind_param('s',$_GET['item']);
		    $qr_gal->execute();
		    $qr_gal->bind_result($r_id,$r_imagem,$r_pos);
		    $i=0;

		      echo '<table id="posImagem" cellspacing="0" cellpadding="2">';
		      while ($qr_gal->fetch()) {
	  ?>
		<tr id="<?=$r_id?>">
		  <td width='20px' title='Clique e arraste para mudar a posição da foto' class='tip'></td>

		  <td class='small'>
		    [<a href='?p=<?=$p?>&delete_imagem&item=<?=$r_id?>&prefix=r_<?=$var['pre']?>_imagem&pre=rpi&col=imagem&folder=<?=$var['imagem_folderlist']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-imagem' style="cursor:pointer;" id="<?=$r_id?>">remover</a>]
		  </td>

		  <td>

		    <a href='$imagThumb<?=$i?>?width=100%' id='imag<?=$i?>' class='betterTip'>
		     <img src='images/lupa.gif' border='0' style='background-color:none;padding-left:10px;cursor:pointer'></a>

			 <div id='imagThumb<?=$i?>' style='float:left;display:none;'>
			 <?php 
			 
			    if (file_exists(substr($var['path_thumb'],0)."/".$r_imagem))
			     echo "<img src='".substr($var['path_thumb'],0)."/".$r_imagem."'>";

			       else echo "<center>imagem não existe.</center>";
			  ?>
			 </div>

		  </td>
		</tr>

	      <?php
		      $i++;	

			}
		   echo '</table><br>';

	       }
	       ?>


		 <div class='divImagem'>

		   <input class="imagem <?php if ($act=='insert') echo ' required';?>" type='file' name='imagem0' id='imagem' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px;">
		   <br><span class='small'>- JPEG, PNG ou GIF;<?=$var['imagemWidth_texto'].$var['imagemHeight_texto']?></span>

		 </div>
		 </p>

  </li>


	<li>	
	  <label>Making of<span class='small'>Making off do projeto</span></label>
      <?php

        if ($act=='update' && !empty($val['makingoff'])) {
      ?>
		    [<a href='?p=<?=$p?>&delete_makingoff&item=<?=$_GET['item']?>&prefix=portfolio&pre=port&col=makingoff&folder=<?=$var['makingoff_folderlist']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-makingoff' style="cursor:pointer;" id="<?=$_GET['item']?>">remover</a>]

       <a href='<?=$var['path_makingoff']?>/<?=$val['makingoff']?>' target='_blank' style='display:inline;padding-left:10px'>
        <img src='images/lupa.gif' border='0' style='background-color:none;'>
       </a>

      <?php

        } else {

      ?>

		   <input class="makingoff" type='file' name='makingoff' id='makingoff' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px;">
		   <br><span class='small'>- flv; máximo <?=ini_get('post_max_size')?></span>


      <?php 

        } 

      ?>
	</li>


	<li>	
	  <label>Título *<span class='small'>Digite o título do projeto</span></label>
	  <input type='text' name='titulo' id='titulo' class='required' value='<?=$val['titulo']?>'>
	</li>



	<li>
	  <label>Data *<span class='small'>Entre com a data</span></label>
	  <input type='text' id='data' name='data' class='required highlight-days-67 range-low-<?=date('Y-m-d',strtotime('-2 year'))?> range-high-<?=date('Y-m-d',strtotime('+5 month'))?> split-date' size='10' value='<?=dateen2pt('-',$val['data'],'/')?>'>
	</li>


	<li>	
	  <label>URL<span class='small'>Endereço do projeto</span></label>
	  <input type='text' name='site' id='site' class='url' value='<?=$val['site']?>'>
	</li>


	<li>
	  <label>Descrição<span class='small'>Descrição do projeto</span></label>
	  <textarea name='descricao' id='descricao' cols='80' rows='4'><?=$val['descricao']?></textarea>
	</li>



</ol>



    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>


