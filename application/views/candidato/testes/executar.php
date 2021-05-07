<h2 class="h2_subtitle"><?=$teste->nome?></h2>
<?=(isset($error) ? $error : '');?>
<form method="post">
	<input type="hidden" name="count" value="<?=count($questions)?>" />
	<div id="showcase" class="showcase">
		<?
		$i = 1;
		$resposta = Arr::get($_POST, "resposta");
		foreach($questions as $row){
			echo '
			<div class="showcase-slide">
				<div class="showcase-content">
					<div class="showcase-content-wrapper dv_questao">
						'.FormTestes::getHtmlCandidatoShowQuestion($row, $i, Arr::get($resposta, $row->id)).'
					</div>
				</div>
			</div>';
			$i++;
		}
		?>
	</div>
	<div class="clear"></div>
	<div>
		<div style="text-align: center; margin: 20px 0;">
			<!-- <input type="submit" class="btn_start" name="concluir" value="concluir teste"> -->
			<input type="submit" name="concluir" value="concluir teste" />
		</div>
	</div>
	<div class="clear"></div>
</form>
<script type="text/javascript">

$(document).ready(function()
{
	$("#showcase").awShowcase(
	{
		content_width:			700,
		content_height:			470,
		fit_to_parent:			false,
		auto:					false,
		interval:				3000,
		continuous:				false,
		loading:				true,
		tooltip_width:			200,
		tooltip_icon_width:		32,
		tooltip_icon_height:	32,
		tooltip_offsetx:		18,
		tooltip_offsety:		0,
		arrows:					true,
		buttons:				true,
		btn_numbers:			true,
		keybord_keys:			true,
		mousetrace:				false, /* Trace x and y coordinates for the mouse */
		pauseonover:			true,
		stoponclick:			false,
		transition:				'hslide', /* hslide/vslide/fade */
		transition_delay:		0,
		transition_speed:		500,
		show_caption:			'onload', /* onload/onhover/show */
		thumbnails:				false,
		thumbnails_position:	'outside-last', /* outside-last/outside-first/inside-last/inside-first */
		thumbnails_direction:	'vertical', /* vertical/horizontal */
		thumbnails_slidex:		1, /* 0 = auto / 1 = slide one thumbnail / 2 = slide two thumbnails / etc. */
		dynamic_height:			true, /* For dynamic height to work in webkit you need to set the width and height of images in the source. Usually works to only set the dimension of the first slide in the showcase. */
		speed_change:			true, /* Set to true to prevent users from swithing more then one slide at once. */
		viewline:				false, /* If set to true content_width, thumbnails, transition and dynamic_height will be disabled. As for dynamic height you need to set the width and height of images in the source. */
		custom_function:		null /* Define a custom function that runs on content change */
	});
});

</script>	