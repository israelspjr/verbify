<?php defined('SYSPATH') or die('No direct script access.');

//error_reporting(E_ALL);

class Controller_Candidato_CadastroCv extends Controller_Candidato_CurriculoTemplate {



	public function action_index()

	{

		$var = array();

		$user = Session::instance()->get("talen_user", NULL);
		
//		echo "<pre>";
//		var_dump($_POST);
//		echo "</pre>";
	
		if ($_POST)

		{

			$experiencias = Arr::get($_POST, 'experiencia');
	
	
			$anos = Arr::get($_POST, 'experiencia_anos');

			$escolas = Arr::get($_POST, 'experiencia_escolas');

			$qual = Arr::get($_POST, 'experiencia_qual');



			foreach($experiencias as $key => $value){

				$m_exp = ORM::factory("experiencia", $key);

				if($m_exp->experiencia == 1 AND $value == 2){

					if($anos[$key] == ""){

						$errors['exp'.$key] = __('Preencha quantos anos de experiência você possui.');

					} elseif($m_exp->escolas == 1 AND $escolas[$key] == ""){

						$errors['exp'.$key] = __('Preencha as escolas em que atuou.');

					}

				} elseif($m_exp->yesorno == 1 AND $value==1){

					if($qual[$key] == ""){

						$errors['exp'.$key] = __('Preencha qual a experiência.');

					}

				}

			}

			if( empty($errors) ){

				$db = Database::instance();

				$db->begin();
				
				$user->delete_all_interesses();
				$valueT = "";
					if (!empty($_POST['experienciaE'])) {
						foreach($_POST['experienciaE'] as $value) {
							$valueT .= $value;
						}
					}
			$query = DB::insert('candidato_experiencia', array('candidato_id', 'experiencia_id', 'valor', 'anos', 'escolas', 'qual'))
			->values(array($user->id, 51, $valueT, 0, 0, $_POST['experiencia_qualE']))
			->execute();
			$valueT = "";
			if (!empty($_POST['experienciaP'])) {
						echo "<hr>";
						foreach($_POST['experienciaP'] as $value) {
							$valueT .= $value;
						}
						
			$query = DB::insert('candidato_experiencia', array('candidato_id', 'experiencia_id', 'valor', 'anos', 'escolas', 'qual'))
			->values(array($user->id, 52, $valueT, 0, 0, $_POST['experiencia_qualP']))
			->execute();
	
	
		}



		//		

				try

				{

					foreach($experiencias as $key => $value){
						
				//		var_dump($key);

						$candidatoexperiencia = ORM::factory("candidatoexperiencia");

						$candidatoexperiencia->candidato_id = $user->id;

						$candidatoexperiencia->experiencia_id = $key;

						$candidatoexperiencia->valor = $value;

						$candidatoexperiencia->anos = Arr::get($anos, $key);

						$candidatoexperiencia->escolas = Arr::get($escolas, $key);

						$candidatoexperiencia->qual = Arr::get($qual, $key);
						
						$candidatoexperiencia->save();
						
					//	echo "<pre>";
					//	var_dump($candidatoexperiencia);

					}

					$user->interesse = 1;

					$user->atualizastatus();

					$db->commit();

			    	$this->request->redirect('candidato/cadastrocv2');

					$var['success'] = __('Dados salvos com sucesso.');

				}

				catch (Exception $e)

				{

					$db->rollback();

					$errors["geral"] = $e->getMessage();

				}

			}

			$values = $_POST;

		} else {

			$values= array();

			$exps = $user->candidatoexperiencias->find_all();
		//	var_dump($exps);

			foreach($exps as $exp) {
				
				$values['experiencia'][$exp->experiencia_id] = $exp->valor;

				$values['experiencia_anos'][$exp->experiencia_id] = $exp->anos;

				$values['experiencia_escolas'][$exp->experiencia_id] = $exp->escolas;

				$values['experiencia_qual'][$exp->experiencia_id] = $exp->qual;

			}

		}



		$experiencias = ORM::factory("experiencia")->order_by('id', 'desc')->find_all();
		
		

		$this->template->title = __('Cadastro do Currículo').' - '.__('Interesses');

		$this->template->content = View::factory('candidato/cadastrocv', $var)

			->set('values', $values)

			->bind('experiencias', $experiencias)

			->bind('errors', $errors);
	}

}

?>

