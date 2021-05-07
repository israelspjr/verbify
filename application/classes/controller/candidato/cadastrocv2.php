<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Candidato_CadastroCv2 extends Controller_Candidato_CurriculoTemplate {

	public function action_index()
	{
		$var = array();
		$user = Session::instance()->get("talen_user", NULL);

		if(isset($_POST["salvar"])){
			$db = Database::instance();
			$db->begin();

			$user->delete_all_viagens();
			$var["viagens"] = array();
			if(isset($_POST["vordem"])) {
				foreach($_POST["vordem"] as $i) {
					try {
						$viagens = ORM::factory("candidatoviagem");
						$viagens->candidato_id = $user->id;
						$viagens->pais_id = $_POST["pais"][$i];
						$viagens->dtde = Helper::format_date_db($_POST["dt_partida"][$i]);
						$viagens->dtate = Helper::format_date_db($_POST["dt_volta"][$i]);
						$viagens->atividade = (isset($_POST["atividade"][$i]) ? $_POST["atividade"][$i] : '');
						$viagens->descricao = $_POST["txt_desc"][$i];
						$viagens->save();
					} catch (ORM_Validation_Exception $e) {
						$errors['viagem'][$i] = $e->errors('models/candidato');
					}
					$var["viagens"][] = $viagens;
				}
			}

			$user->delete_all_certificacoes();
			$var["certificacoes"] = array();
			if(isset($_POST["cordem"])){
				foreach($_POST["cordem"] as $i) {
					try {
						$certs = ORM::factory("candidatocertificacao");
						$certs->candidato_id = $user->id;
						$certs->descricao = $_POST["cert_descricao"][$i];
						$certs->ano = $_POST["cert_ano"][$i];
						$certs->tipo = $_POST["cert_tipo"][$i];
						$certs->idioma_id = $_POST["cert_idioma"][$i];
						$certs->save();
					} catch (ORM_Validation_Exception $e) {
						$errors['certi'][$i] = $e->errors('models/candidato');
					}
					$var["certificacoes"][] = $certs;
				}
			}

			$user->delete_all_graduacoes();
			$var["graduacoes"] = array();
			if(isset($_POST["gordem"])) {
				foreach($_POST["gordem"] as $i) {
					try {
						$grads = ORM::factory("candidatograduacao");
						$grads->candidato_id = $user->id;
						$grads->grauescolar_id = $_POST["escolaridade"][$i];
						$grads->curso_id = $_POST["curso"][$i];
						$grads->situacao = (isset($_POST["situacao"][$i]) ? $_POST["situacao"][$i] : '');
						$grads->dt_inicio = (isset($_POST["grad_dtini"][$i]) ? Helper::format_month_to_datedb($_POST["grad_dtini"][$i]) : '');
						$grads->dt_conclusao = (isset($_POST["grad_dtfim"][$i]) ? Helper::format_month_to_datedb($_POST["grad_dtfim"][$i]) : '0');
						$grads->instituicao = $_POST["instituicao"][$i];
						$grads->save();
					} catch (ORM_Validation_Exception $e) {
						$errors['gradu'][$i] = $e->errors('models/candidato');
					}
					$var["graduacoes"][] = $grads;
				}
			}

			$user->delete_all_expidiomas();
			$var["experiencias_idiomas"] = array();
			if(isset($_POST["epordem_idioma"])){
				foreach($_POST["epordem_idioma"] as $i) {
					try {
						$eprof = ORM::factory("candidatoexpidioma");
						$eprof->candidato_id = $user->id;
						$eprof->funcao = $_POST["funcao_idioma"][$i];
						$eprof->dt_inicio = (isset($_POST["exp_dtinicio_idioma"][$i]) ? Helper::format_month_to_datedb($_POST["exp_dtinicio_idioma"][$i]) : '');
						$eprof->dt_fim = (isset($_POST["exp_dtfim_idioma"][$i]) ? Helper::format_month_to_datedb($_POST["exp_dtfim_idioma"][$i]) : '');
						$eprof->atualidade = (isset($_POST["atual_idioma"][$i]) ? $_POST["atual_idioma"][$i] : '0');
						$eprof->save();
					} catch (ORM_Validation_Exception $e) {
						$errors['eprof_idioma'][$i] = $e->errors('models/candidato');
					}
					$var["experiencias_idiomas"][] = $eprof;
				}
			}

			$user->delete_all_expprofissionais();
			$var["experiencias"] = array();
			if(isset($_POST["epordem"])){
				foreach($_POST["epordem"] as $i) {
					try {
						$eprof = ORM::factory("candidatoexpprofissional");
						$eprof->candidato_id = $user->id;
						$eprof->funcao = $_POST["funcao"][$i];
						$eprof->dt_inicio = (isset($_POST["exp_dtinicio"][$i]) ? Helper::format_month_to_datedb($_POST["exp_dtinicio"][$i]) : '');
						$eprof->dt_fim = (isset($_POST["exp_dtfim"][$i]) ? Helper::format_month_to_datedb($_POST["exp_dtfim"][$i]) : '');
						$eprof->atualidade = (isset($_POST["atual"][$i]) ? $_POST["atual"][$i] : '0');
						$eprof->save();
					} catch (ORM_Validation_Exception $e) {
						$errors['eprof'][$i] = $e->errors('models/candidato');
					}
					$var["experiencias"][] = $eprof;
				}
			}

			$user->delete_all_cursos();
			$var["cursoslivres"] = array();
			if(isset($_POST["cursoordem"])){
				foreach($_POST["cursoordem"] as $i) {
					try {
						$cursos = ORM::factory("candidatocursoslivres");
						$cursos->candidato_id = $user->id;
						$cursos->curso = $_POST["cursolivre"][$i];
						$cursos->instituicao = $_POST["cl_instituicao"][$i];
						$cursos->ano = $_POST["cl_ano"][$i];
						$cursos->save();
					} catch (ORM_Validation_Exception $e) {
						$errors['curso'][$i] = $e->errors('models/candidato');
					}
					$var["cursoslivres"][] = $cursos;
				}
			}
			if(isset($errors)) {
				$db->rollback();
			} else {
				$user->expformacao = 1;
				$user->atualizastatus();
				$db->commit();
				$var['success'] = __('Dados salvos com sucesso.');
				$this->request->redirect('candidato/cadastrocv3');
			}
		} else {
			$var["viagens"] = $user->viagens->order_by('dtde', 'DESC')->find_all();
			$var["certificacoes"] = $user->certificacoes->order_by('ano', 'DESC')->find_all();
			$var["graduacoes"] = $user->graduacoes->order_by('dt_inicio', 'DESC')->find_all();
			$var["experiencias"] = $user->expprofissionais->order_by('dt_inicio', 'DESC')->find_all();
			$var["experiencias_idiomas"] = $user->expidiomas->order_by('dt_inicio', 'DESC')->find_all();
			$var["cursoslivres"] = $user->candidatocursos->order_by('ano', 'DESC')->find_all();
		}

		$var["paises"] = ORM::factory("pais")->order_by("name", "ASC")->find_all();
		$var["grauescolar"] = ORM::factory("grauescolar")->order_by("ordem", "ASC")->find_all();
		$var["cursos"] = ORM::factory("curso")->order_by("descricao", "ASC")->find_all();
		$var["idiomas"] = ORM::factory("idioma")->where("active", "=", "1")->order_by("descricao", "ASC")->find_all();

		$this->template->title = __('Cadastro do Currículo').' - '.__('Experiência / Formação');
		$this->template->content = View::factory('candidato/cadastrocv2', $var)
			->set('values', $_POST)
			->bind('pais', $pais)
			->bind('errors', $errors);
	}
}