  <div class='error container-error'><div class='error-icon'>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:</div>
	<ol> 
		<li><label for="nome" class="error-validate">Informe o nome do cliente</label></li>
		<li><label for="data" class="error-validate">Entre com uma data válida</label></li>
		<li><label for="contato" class="error-validate">Pessoa responsável</label></li>
		<li><label for="email" class="error-validate">Informe um e-mail válido</label></li>
		<li><label for="telefone" class="error-validate">Telefone do cliente</label></li>
		<li><label for="celular" class="error-validate">Celular do cliente</label></li>
		<li><label for="site" class="error-validate">Site do cliente</label></li>
		<li><label for="endereco" class="error-validate">Endereço</label></li>
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
	  <label>Nome do Cliente *<span class='small'>Nome/empresa do cliente</span></label>
	  <input type='text' name='nome' id='nome' class='required' value='<?=$val['nome']?>'>
	</li>

<!--
	<li>
	  <label>Data *<span class='small'>Entre com a data para ordenação</span></label>
	  <input type='text' id='data' name='data' class=' highlight-days-67 range-low-<?=date('Y-m-d',strtotime('-2 year'))?> range-high-<?=date('Y-m-d',strtotime('+5 month'))?> split-date' size='10' value='<?=dateen2pt('-',$val['data'],'/')?>'>
	</li>
-->

	<li>	
	  <label>Contato<span class='small'>Responsável</span></label>
	  <input type='text' name='contato' id='contato' class='' value='<?=$val['contato']?>'>
	</li>


	<li>	
	  <label>Telefone<span class='small'>Telefone para contato</span></label>
	  <input type='text' name='telefone' id='telefone' class='' value='<?=$val['telefone']?>'>
	</li>


	<li>	
	  <label>Celular<span class='small'>Celular para contato</span></label>
	  <input type='text' name='celular' id='celular' class='' value='<?=$val['celular']?>'>
	</li>


	<li>	
	  <label>E-mail<span class='small'>Email para contato</span></label>
	  <input type='text' name='email' id='email' class='email' value='<?=$val['email']?>'>
	</li>

	<li>	
	  <label>Website <span class='small'>Site da empresa</span></label>
	  <input type='text' name='site' id='site' class='url' value='<?=$val['site']?>'>
	</li>


	<li>
	  <label>Endereço <span class='small'>Endereço/local da empresa</span></label>
	  <textarea name='endereco' id='endereco' class='' cols='80' rows='5'><?=$val['texto']?></textarea>
	</li>



    </ol>



    <br>
    <p align='center'>
    <input type='submit' value='ok' class='first'><input type='button' id='form-back' value='voltar'></p>
    <div class='spacer'></div>


</form>
