<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Candidato_TesteOral extends Controller_Candidato_DefaultTemplate {

    public function action_index()
    {
		$user = Session::instance()->get("talen_user", NULL);
		$var = array();
		$id = $this->request->param("id");
		// se teste existe
		$this->verificaTeste($id);
		$teste = ORM::factory("teste", $id);

		// se já realizado
		$testeexec = ORM::factory("testeexecutado")
			->where("teste_id", "=", $teste->id)
			->where("candidato_id", "=", $user->id)
			->find();
		if($testeexec->loaded()){
			$this->request->redirect("candidato/testes/jarealizado");
		}
		$videotmp = ORM::factory("videotmp")
			->where("candidato_id", "=", $user->id)
			->where("teste_id", "=", $teste->id)
			->find();
		if($videotmp->loaded()){
			$this->request->redirect("candidato/testeoral/videoconversao/".$videotmp->id);
		}
		$this->template->title = 'Teste Oral';
		// se nao foi convidado, e não foi comprado ainda
		$convites = $user->convites->where("teste_id", "=", $id)->count_all();
		$comprado = $user->conta->testeExecComprado($id);
		$custo = $teste->getConsumoProfessor($user);
		if($convites == 0 AND !$comprado AND $custo > 0){
			// avisa consumo e debita
			$alert = Session::instance()->get("alertteste[$id]", NULL);
			if(is_null($alert)){
				$this->request->redirect("candidato/testes/avisaconsumo/$id");
			}
			try {
				$user->conta->compraTesteExec($id);
			} catch(exception $e){
				$this->template->content = '<p class="p_error">'.$e->getMessage().'</p>';
				return;
			}
		}
		$var["teste"] = $teste;
		$var["lang"] = $this->lang;
		$this->template->content = View::factory('candidato/testes/oral', $var);
		$this->template->styles = array('assets/uploadify/uploadify.css' => 'screen');
		$this->template->scripts = array('assets/uploadify/jquery.uploadify-3.1.min.js');
    }

	public function action_videoconversao()
	{
		$id = $this->request->param("id");
		$video = ORM::factory("videotmp", $id);
		if(!$video->loaded()){
			$this->request->redirect("candidato/testes/notfound");
		}
		if($video->status == 0 OR $video->status == 2){
			// buscar porcentagem
			$this->template->title = $video->teste->nome;
			$this->template->content = '<p class="p_warning">Aguarde a conversão do vídeo. <br />
			Esta ação pode demorar vários minutos. Você receberá um email quando a ação for concluída.</p>
			<div class="dv_btn">
				<input type="button" value="atualizar" onClick="window.open(\''.URL::site("candidato/testeoral/index/".$video->teste->id).'\', \'_top\')" />
				<input type="button" value="cancelar" onClick="window.open(\''.URL::site("candidato/testeoral/descartar/".$video->id).'\', \'_top\')" />
			</div>';
		} else {
			$var = array();
			$var["video"] = $video;
			$var["teste"] = $video->teste;
			$var["filename"] = HeyWatch::getConvertedName($video->url);
			$var["targetFile"] = HeyWatch::getUploadTmpFolder().'/'.$var["filename"];
			$this->template->title = $video->teste->nome;
			$this->template->content = View::factory("candidato/testes/oral2", $var);
		}
	}

	public function action_descartar()
	{
		$id = $this->request->param("id");
		$video = ORM::factory("videotmp", $id);
		if(!$video->loaded()){
			$this->request->redirect("candidato/testes/notfound");
		} else {
			$teste_id = $video->teste->id;
			$filename = HeyWatch::getUploadFolder().'/'. basename($video->url,'.'.end(explode(".", $video->url)));
			if(file_exists($filename))
				unlink($filename);
			$video->delete();
			$this->request->redirect("candidato/testeoral/index/".$teste_id);
		}
	}

	public function action_upload()
    {
		$error_message = NULL;
		$filename = NULL;

		$id = $this->request->param("id");
		$user = Session::instance()->get("talen_user", NULL);

		// se teste existe
		$this->verificaTeste($id);
		$teste = ORM::factory("teste", $id);

		// se já realizado
		$testeexec = ORM::factory("testeexecutado")
			->where("teste_id", "=", $teste->id)
			->where("candidato_id", "=", $user->id)
			->find();
		if($testeexec->loaded()){
			$this->request->redirect("candidato/testes/jarealizado");
		}

		$this->template->title = 'Teste Oral';

		if (isset($_POST["gravar"]))
		{
			try {
				$filename = (isset($_POST["filename"]) ? $_POST["filename"] : '');
				$updir    = $_SERVER["DOCUMENT_ROOT"].HeyWatch::getUploadFolder();
				$updirtmp = $_SERVER["DOCUMENT_ROOT"].HeyWatch::getUploadTmpFolder();
				if(file_exists($updirtmp.'/'.$filename)) {
				  rename("$updirtmp/$filename", "$updir/$filename");
					$testeex = ORM::factory("testeexecutado");
					$testeex->teste_id = $teste->id;
					$testeex->candidato_id = $user->id;
					$testeex->divulgar = 0;
					$testeex->save();
					$video = ORM::factory("video");
					$video->testeex_id = $testeex->id;
					$video->url = $filename;
					$video->save();
					$this->request->redirect("candidato/testeoral/terminado/".$id);
				} else {
					//throw new Exception("Arquivo não encontrado" . $updirtmp.'/'.$filename);
					throw new Exception("Arquivo não encontrado");
				}
			} catch(exception $e){
				$this->template->content = '<p class="p_error">'.$e->getMessage().'</p>';
				$filename = false;
			}
    } elseif(isset($_POST["converter"])) {
			$filename = (isset($_POST["filename"]) ? $_POST["filename"] : '');
			$updir = $_SERVER["DOCUMENT_ROOT"].HeyWatch::getUploadTmpFolder();
			$db = Database::instance();
			$db->begin();
			try {
				if(file_exists($updir.'/'.$filename)){
					// envia para conversao
					$video = ORM::factory("videotmp");
					$video->teste_id = $teste->id;
					$video->candidato_id = $user->id;
					$video->url = $filename;
					$video->save();
					$xml = HeyWatch::converter($video);
					$db->commit();
					$this->request->redirect("candidato/testeoral/index/".$id);
				} else {
					throw new Exception("Arquivo não encontrado");
				}
			} catch(exception $e){
				$db->rollback();
				$this->template->content = '<p class="p_error">'.$e->getMessage().': '. $e->getLine().'</p>';
				$filename = false;
			}
		}
    }

	public function action_terminado()
	{
		$var = array();
		$user = Session::instance()->get("talen_user", NULL);
		$id = $this->request->param("id");
		$testeex = $user->testesexecutados->where("teste_id", "=", $id)->find();
		if($testeex->loaded()){
			$var["teste"] = $testeex;
			$var["html"] = $this->htmlResultados($testeex);
			$this->template->title = 'Teste Concluído';
			$this->template->content = View::factory('candidato/testes/concluido', $var);
		} else {
			$this->request->redirect("candidato/testes");
		}
	}

	public static function htmlResultados($testeex)
	{
		if($testeex->teste->tipo == 2){
			$video = $testeex->video;
			if($video->loaded()){
				$html = '
				<style>
					#player{
						width:450px;
						height:340px;
						text-align:center;
						line-height:290px;
						border:1px solid #c0c0c0;
						background: url('.HeyWatch::getFinalThumb($video->url).') no-repeat;
						background-size:450px 340px;
						-moz-background-size:450px 340px;
					}
				</style>
				<div class="dv_myresult" id="player">
					<img class="button" src="'.URL::site("assets/img/showme.png").'" /></a>
				</div>
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
							url: \'http://profcerto.com.br'.HeyWatch::getFinalName($video->url).'\'
						}
					});
				});
				</script>';
				return $html;
			}
		}
	}

	public function verificaTeste($id)
	{
		// se teste existe
		$teste = ORM::factory("teste")
			->where("id", "=", $id)
			->where("active", "=", "1")
			->where("publicado", "=", "1")
			->find();
		if(!$teste->loaded()){
			//$this->request->redirect("candidato/testes/notfound");
		}
	}

}