<h2><?=$title;?></h2>
<?php if(isset($msg)) { ?>
<div class="msg success">
  <?=$msg;?>
</div>
<?php } ?>
<?php if(sizeof($banners) > 0) { ?>
<table class="tb_lista">
  <thead>
    <tr>
      <th>Banner</th>
      <th>Link</th>
      <th>Idioma</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($banners as $banner) { ?>
    <tr>
      <td><img src="<?=URL::site('uploads/banners/'.$banner->banner);?>" width="120" alt="" /></td>
      <td><?=$banner->link;?></td>
      <td><?=$banner->language;?></td>
      <td>
        <a href="<?=URL::site('admin/banners/editar/'.$banner->id);?>">Editar</a> ||
        <a href="javascript:;" onclick="r=confirm('Você tem certeza de que deseja excluir este banner?'); if(r){ window.open('<?=URL::site('admin/banners?action=excluir&id='.$banner->id);?>','_self'); }">Excluir</a>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<?php } ?>
<br />
<input type="button" value="Cadastrar Banner" onclick="window.open('<?=URL::site('admin/banners/cadastro');?>', '_self');" />