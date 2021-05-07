<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Banners extends Controller_Admin_DefaultTemplate {
    public function action_index()
    {
      $var = array();
      $var['title'] = "Banners";
      $this->template->title = $var['title'];
      if(isset($_GET['action'])) {
        if($_GET['action'] == 'excluir') {
          $id = $_GET["id"];
          $var['msg'] = $this->excluir($id);
        }
      }

      $var['banners'] = ORM::factory('banners')->find_all();

      $this->template->content = View::factory('admin/banners/listar', $var);
    }

	public function action_cadastro()
	{
		$var = array();
		$var['title'] = "Cadastrar Banner";
		$this->template->title = $var['title'];
		$var['errors'] = array();
		$var['success'] = '';
		if($this->request->post('salvar')) {
			$fbanner = $_FILES['banner'];
			$valid_exts = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
			if($fbanner['name'] == '') {
				$var['errors'] = array_merge($var['errors'], array('Nenhum banner enviado.'));
			} else {
				if(!in_array($fbanner['type'], $valid_exts)) {
					$var['errors'] = array_merge($var['errors'], array('Extensão de arquivo inválida.'));
				}
			}
			if(empty($var['errors'])) {
				$banner_name = date('YmdHis').'_'.$fbanner['name'];
				$img = Image::factory($fbanner['tmp_name']);
				$img->resize('1000', '503', Image::NONE);
				$img->save(DOCROOT.'/uploads/banners/'.$banner_name, 100);
				$link = $this->request->post('link');
				$language = $this->request->post('language');
				$sort = $this->request->post('sort');
				$banner = ORM::factory('banners');
				$banner->banner = $banner_name;
				$banner->link = $link;
				$banner->language = $language;
				$banner->sort = $sort;
				$banner->save();
				$var['success'] = 'Banner salvo com sucesso!';
			}
		}

		$this->template->content = View::factory('admin/banners/cadastro', $var);
    }

    public function action_editar()
    {
		$id = $this->request->param("id");
		$banner = ORM::factory('banners', $id);
		$var = array();
		$var['title'] = "Editar Banner";
		$var['errors'] = array();
		$var['success'] = '';
		if($this->request->post('salvar')) {
			$banner_name = $this->request->post("banner");
			$link = $this->request->post("link");
			$language = $this->request->post('language');
			$sort = $this->request->post("sort");
			if(empty($var['errors'])) {
				$banner->banner = $banner_name;
				$banner->link = $link;
				$banner->language = $language;
				$banner->sort = $sort;
				$banner->save();
				$var['success'] = 'Banner salvo com sucesso!';
			}
		}
		$this->template->title = $var['title'];
		$var['id'] = $banner->id;
		$var['banner'] = $banner->banner;
		$var['link'] = $banner->link;
		$var['language'] = $banner->language;
		$var['sort'] = $banner->sort;

		$this->template->content = View::factory('admin/banners/editar', $var);
    }

    private function excluir($id)
    {
      $banner = ORM::factory('banners', $id);
      if($banner->banner != '') {
        $bname = DOCROOT.'/uploads/banners/'.$banner->banner;
        if(file_exists($bname) && !is_dir($bname)) {
          unlink($bname);
        }
        if($banner->delete()) {
          return 'Banner excluído com sucesso!';
        }
      }
    }
}
?>