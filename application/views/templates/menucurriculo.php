<?
$user = Session::instance()->get("talen_user", NULL);
$controller = Request::initial()->controller();
?>
<ul id="menucurriculo">
	<li ><a href="<?=URL::site('candidato/meusdados')?>" class="completed <?=($controller == 'meusdados' ? 'active' : '')?>"><? echo __('Dados Pessoais'); ?></a></li>
	<li ><a href="<?=URL::site('candidato/cadastrocv')?>" class="<?=($user->interesse ==1 ? 'completed' : '')?> <?=($controller == 'cadastrocv' ? 'active' : '')?>"><? echo __('Interesses'); ?></a></li>
	<li><a href="<?=URL::site('candidato/cadastrocv2')?>" class="<?=($user->expformacao ==1 ? 'completed' : '')?> <?=($controller == 'cadastrocv2' ? 'active' : '')?>"><? echo __('Experiência / Formação'); ?></a></li>
	<li><a href="<?=URL::site('candidato/cadastrocv3')?>" class="<?=($user->disponibilidade ==1 ? 'completed' : '')?> <?=($controller == 'cadastrocv3' ? 'active' : '')?>"><? echo __('Disponibilidade'); ?></a></li>
	
</ul>
<br class="clear" />
