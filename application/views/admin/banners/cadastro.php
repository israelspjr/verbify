<h2><?=$title;?></h2>
<form action="<?=URL::site('admin/banners/cadastro');?>" method="post" enctype="multipart/form-data" id="frm-banner">
  <?php if(!empty($errors)) { ?>
  <div class="msg error">
    <ul>
    <?php foreach($errors as $error) {
      echo '<li>'.$error.'</li>';
    } ?>
    </ul>
  </div>
  <?php } elseif($success != '') { ?>
  <div class="msg success">
    <?=$success;?>
  </div>
  <?php } ?>
	<table>
		<tr>
			<td><label for="order">Idioma: </label></td>
			<td>
				<select name="language" id="language">
					<option value="pt">Português</option>
					<option value="en">Inglês</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for="banner">Banner: </label></td>
			<td><input type="file" id="banner" name="banner" /></td>
		</tr>
		<tr>
			<td><label for="link">Link: </label></td>
			<td><input type="text" id="link" name="link" value="" /></td>
		</tr>
		<tr>
			<td><label for="order">Ordem: </label></td>
			<td><input type="text" id="order" name="sort" value="0" style="width: 40px; text-align: right;" /></td>
		</tr>
	</table><br />
	<div class="dv_btn">
		<input type="submit" name="salvar" value="salvar" />
		<input type="button" name="cancelar" value="voltar" onClick="window.open('<?=URL::site('admin/banners')?>', '_top')" />
	</div>
</form>