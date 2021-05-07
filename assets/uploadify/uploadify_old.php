<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
$pattern = '/^'.addcslashes("http://(www\.)?profcerto.com.br".$urlsite."candidato/testeoral/index/[0-9]*").'/';
if(!preg_match($pattern, $_SERVER["HTTP_REFERER"])){
	echo 'Upload não autorizado';
	exit;
}
// Define a destination
$urlsite = (isset($_REQUEST["urlsite"]) ? $_REQUEST["urlsite"] : '');
$tutorial = $urlsite.'assets/img/tutorial_conversao.pdf';
$targetFolder = $urlsite.'uploads/'; // Relative to the root
$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$ext_tmp = explode('.', $_FILES['Filedata']['name']);
	$ext = end($ext_tmp);
	do {
		$filename = strtolower(random('alnum', 20)).'.'.strtolower($ext);
	} while (file_exists($targetPath . $filename));

	// Validate the file type
	$fileTypes = array('flv','mp4','mov'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		$targetFile = $targetFolder . $filename;
		try {
			$file = save($_FILES['Filedata'], $filename, $targetPath);
			echo '
			<input type="hidden" name="filename" value="'.$filename.'" />
			<div class="dv_myresult" id="player" style="width:450px;height:340px;text-align:center;line-height:290px;border:1px solid #c0c0c0;background:#fff;float:left;">
				<img class="button" src="'.$urlsite.'assets/img/showme.png" /></a>
			</div>
			<div style="float: left; margin: 10px 20px; background: #fff; width:350px; padding: 10px;">
				Caso o seu vídeo não seja reproduzido corretamente, siga o <a href="'.$tutorial.'" style="text-decoration: underline;" target="_blank">tutorial de conversão</a> e tente novamente. <br />
				Ao obter o resultado desejado, clique no botão "GRAVAR" abaixo do vídeo para concluir o teste.
			</div>
			<div class="clear"></div>
			<input type="submit" name="gravar" class="uploadify-button" value="GRAVAR" style="width: 150px; height: 30px;" />
			<script>
			$(function(){
				flowplayer("player", "http://releases.flowplayer.org/swf/flowplayer-3.2.12.swf", {
					// this will enable pseudostreaming support
					plugins: {
						pseudo: {
							url: "http://releases.flowplayer.org/swf/flowplayer.pseudostreaming-3.2.9.swf"
						}
					},

					// clip properties
					clip: {
						// our clip uses pseudostreaming
						provider: \'pseudo\',
						url: \'http://profcerto.com.br'.$targetFile.'\'
					}
				});
			});
			</script>';
		} catch (Exception $e){
			echo '<p class="p_error">'.$e->getMessage().'</p>';
		}
	} else {
		echo '<p class="p_error">O arquivo deve ser de uma das seguintes extensões: .FLV, .MP4 ou .MOV</p>';
	}
}


function random($type = NULL, $length = 8)
{
	if ($type === NULL)
	{
		// Default is to generate an alphanumeric string
		$type = 'alnum';
	}

	$utf8 = FALSE;

	switch ($type)
	{
		case 'alnum':
			$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		break;
		case 'alpha':
			$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		break;
		case 'hexdec':
			$pool = '0123456789abcdef';
		break;
		case 'numeric':
			$pool = '0123456789';
		break;
		case 'nozero':
			$pool = '123456789';
		break;
		case 'distinct':
			$pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
		break;
		default:
			$pool = (string) $type;
			$utf8 = ! UTF8::is_ascii($pool);
		break;
	}

	// Split the pool into an array of characters
	$pool = ($utf8 === TRUE) ? UTF8::str_split($pool, 1) : str_split($pool, 1);

	// Largest pool key
	$max = count($pool) - 1;

	$str = '';
	for ($i = 0; $i < $length; $i++)
	{
		// Select a random character from the pool and add it to the string
		$str .= $pool[mt_rand(0, $max)];
	}

	// Make sure alnum strings contain at least one letter and one digit
	if ($type === 'alnum' AND $length > 1)
	{
		if (ctype_alpha($str))
		{
			// Add a random digit
			$str[mt_rand(0, $length - 1)] = chr(mt_rand(48, 57));
		}
		elseif (ctype_digit($str))
		{
			// Add a random letter
			$str[mt_rand(0, $length - 1)] = chr(mt_rand(65, 90));
		}
	}

	return $str;
}

function save(array $file, $filename = NULL, $directory = NULL, $chmod = 0644)
{
	if ( ! isset($file['tmp_name']) OR ! is_uploaded_file($file['tmp_name']))
	{
		// Ignore corrupted uploads
		return FALSE;
	}
	if ( ! is_dir($directory) OR ! is_writable(realpath($directory)))
	{
		throw new Exception("Directory $directory must be writable");
	}

	// Make the filename into a complete path
	$filename = realpath($directory).'/'.$filename;

	if (move_uploaded_file($file['tmp_name'], $filename))
	{
		if ($chmod !== FALSE)
		{
			// Set permissions on filename
			chmod($filename, $chmod);
		}

		// Return new file path
		return $filename;
	}
	return FALSE;
}

?>