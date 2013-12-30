<?php

class Categories extends Admin_Controller {	
	
	function __construct()
	{		
		parent::__construct();
		
		remove_ssl();
		$this->auth->check_access('Admin', true);
		$this->lang->load('category');
		$this->load->model('Category_model');
	}
	
	function index()
	{
		//we're going to use flash data and redirect() after form submissions to stop people from refreshing and duplicating submissions
		//$this->session->set_flashdata('message', 'this is our message');
		
		$data['page_title']	= lang('categories');
		$data['categories']	= $this->Category_model->get_categories_tierd();
		
		$this->load->view($this->config->item('admin_folder').'/categories', $data);
	}
	
	//basic category search
	function category_autocomplete()
	{
		$name	= trim($this->input->post('name'));
		$limit	= $this->input->post('limit');
		
		if(empty($name))
		{
			echo json_encode(array());
		}
		else
		{
			$results	= $this->Category_model->category_autocomplete($name, $limit);
			
			$return		= array();
			foreach($results as $r)
			{
				$return[$r->id]	= $r->name;
			}
			echo json_encode($return);
		}
		
	}
	
	function organize($id = false)
	{
		$this->load->helper('form');
		$this->load->helper('formatting');
		
		if (!$id)
		{
			$this->session->set_flashdata('error', lang('error_must_select'));
			redirect($this->config->item('admin_folder').'/categories');
		}
		
		$data['category']		= $this->Category_model->get_category($id);
		//if the category does not exist, redirect them to the category list with an error
		if (!$data['category'])
		{
			$this->session->set_flashdata('error', lang('error_not_found'));
			redirect($this->config->item('admin_folder').'/categories');
		}
			
		$data['page_title']		= sprintf(lang('organize_category'), $data['category']->name);
		
		$data['category_products']	= $this->Category_model->get_category_products_admin($id);
		
		$this->load->view($this->config->item('admin_folder').'/organize_category', $data);
	}
	
	function process_organization($id)
	{
		$products	= $this->input->post('product');
		$this->Category_model->organize_contents($id, $products);
	}
	
	function form($id = false)
	{
		
		$config['upload_path']		= 'uploads/images/full';
		$config['allowed_types']	= 'gif|jpg|png';
		$config['max_size']			= $this->config->item('size_limit');
		$config['max_width']		= '1024';
		$config['max_height']		= '768';
		$config['encrypt_name']		= true;
		$this->load->library('upload', $config);
		
		
		$this->category_id	= $id;
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$data['categories']		= $this->Category_model->get_categories();
		$data['page_title']		= lang('category_form');
		
		//default values are empty if the customer is new
		$data['id']				= '';
		$data['name']			= '';
		$data['slug']			= '';
		$data['description']	= '';
		$data['excerpt']		= '';
		$data['sequence']		= '';
		$data['image']			= '';
		$data['seo_title']		= '';
		$data['meta']			= '';
		$data['parent_id']		= 0;
		$data['error']			= '';
		
		//create the photos array for later use
		$data['photos']		= array();
		
		if ($id)
		{	
			$category		= $this->Category_model->get_category($id);

			//if the category does not exist, redirect them to the category list with an error
			if (!$category)
			{
				$this->session->set_flashdata('error', lang('error_not_found'));
				redirect($this->config->item('admin_folder').'/categories');
			}
			
			//helps us with the slug generation
			$this->category_name	= $this->input->post('slug', $category->slug);
			
			//set values to db values
			$data['id']				= $category->id;
			$data['name']			= $category->name;
			$data['slug']			= $category->slug;
			$data['description']	= $category->description;
			$data['excerpt']		= $category->excerpt;
			$data['sequence']		= $category->sequence;
			$data['parent_id']		= $category->parent_id;
			$data['image']			= $category->image;
			$data['seo_title']		= $category->seo_title;
			$data['meta']			= $category->meta;
			
		}
		
		$this->form_validation->set_rules('name', 'lang:name', 'trim|required|max_length[64]');
		$this->form_validation->set_rules('slug', 'lang:slug', 'trim');
		$this->form_validation->set_rules('description', 'lang:description', 'trim');
		$this->form_validation->set_rules('excerpt', 'lang:excerpt', 'trim');
		$this->form_validation->set_rules('sequence', 'lang:sequence', 'trim|integer');
		$this->form_validation->set_rules('parent_id', 'parent_id', 'trim');
		$this->form_validation->set_rules('image', 'lang:image', 'trim');
		$this->form_validation->set_rules('seo_title', 'lang:seo_title', 'trim');
		$this->form_validation->set_rules('meta', 'lang:meta', 'trim');
		
		
		// validate the form
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view($this->config->item('admin_folder').'/category_form', $data);
		}
		else
		{
			
			
			$uploaded	= $this->upload->do_upload('image');
			
			if ($id)
			{
				//delete the original file if another is uploaded
				if($uploaded)
				{
					
					if($data['image'] != '')
					{
						$file = array();
						$file[] = 'uploads/images/full/'.$data['image'];
						$file[] = 'uploads/images/medium/'.$data['image'];
						$file[] = 'uploads/images/small/'.$data['image'];
						$file[] = 'uploads/images/thumbnails/'.$data['image'];
						
						foreach($file as $f)
						{
							//delete the existing file if needed
							if(file_exists($f))
							{
								unlink($f);
							}
						}
					}
				}
				
			}
			else
			{
				if(!$uploaded)
				{
					$error	= $this->upload->display_errors();
					if($error != lang('error_file_upload'))
					{
						$data['error']	.= $this->upload->display_errors();
						$this->load->view($this->config->item('admin_folder').'/category_form', $data);
						return; //end script here if there is an error
					}
				}
			}
			
			if($uploaded)
			{
				$image			= $this->upload->data();
				$save['image']	= $image['file_name'];
				
				$this->load->library('image_lib');
				
				//this is the larger image
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'uploads/images/full/'.$save['image'];
				$config['new_image']	= 'uploads/images/medium/'.$save['image'];
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 600;
				$config['height'] = 500;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();

				//small image
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'uploads/images/medium/'.$save['image'];
				$config['new_image']	= 'uploads/images/small/'.$save['image'];
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 300;
				$config['height'] = 300;
				$this->image_lib->initialize($config); 
				$this->image_lib->resize();
				$this->image_lib->clear();

				//cropped thumbnail
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'uploads/images/small/'.$save['image'];
				$config['new_image']	= 'uploads/images/thumbnails/'.$save['image'];
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 150;
				$config['height'] = 150;
				$this->image_lib->initialize($config); 	
				$this->image_lib->resize();	
				$this->image_lib->clear();
			}
			
			$this->load->helper('text');
			
			//first check the slug field
			$slug = $this->input->post('slug');
			
			//if it's empty assign the name field
			if(empty($slug) || $slug=='')
			{
				$slug = $this->input->post('name');
			}
			
			$slug	= url_title(convert_accented_characters($slug), 'dash', TRUE);
			
			//validate the slug
			$this->load->model('Routes_model');
			if($id)
			{
				$slug	= $this->Routes_model->validate_slug($slug, $category->route_id);
				$route_id	= $category->route_id;
			}
			else
			{
				$slug	= $this->Routes_model->validate_slug($slug);
				
				$route['slug']	= $slug;	
				$route_id	= $this->Routes_model->save($route);
			}
			
			$save['id']				= $id;
			$save['name']			= $this->input->post('name');
			$save['description']	= $this->input->post('description');
			$save['excerpt']		= $this->input->post('excerpt');
			$save['parent_id']		= intval($this->input->post('parent_id'));
			$save['sequence']		= intval($this->input->post('sequence'));
			$save['seo_title']		= $this->input->post('seo_title');
			$save['meta']			= $this->input->post('meta');

			$save['route_id']		= intval($route_id);
			$save['slug']			= $slug;
			
			$category_id	= $this->Category_model->save($save);
			
			//save the route
			$route['id']	= $route_id;
			$route['slug']	= $slug;
			$route['route']	= 'cart/category/'.$category_id.'';
			
			$this->Routes_model->save($route);
			
			$this->session->set_flashdata('message', lang('message_category_saved'));
			
			//go back to the category list
			redirect($this->config->item('admin_folder').'/categories');
		}
	}
	
    function sync_eelly_cate()
    {   
        $this->load->spark('restclient/2.1.0');
        $this->load->helper('array');
        $this->rest->initialize(array('server' => $this->config->item('cps_service_domain')));
        $getObject = $this->rest->get('api/mall_itemcats/get.json');
        $getArray=object_to_array($getObject);
        if($getArray['mall_itemcats.get']['success']) {
        } else {
            $this->session->set_flashdata('error', lang('request_data_error'));
        }
         $getArray=$this->mappedField($getArray['mall_itemcats.get']['data']);
         $jsondata=json_encode($getArray);
         $data['jsondata']=$jsondata;
        
        $this->load->view($this->config->item('admin_folder').'/synceellycate',$data);

    }
    
    function sync_eelly_goods($id)
    {
        $sp=$this->input->post('sp');
        $this->load->spark('restclient/2.1.0');
        $this->load->helper('array');
        $this->rest->initialize(array('server' => $this->config->item('cps_service_domain')));
        $parent_id=(int)$this->Category_model->get_category($id)->parent_id;
        $cate_name=$this->Category_model->get_category($id)->name;
        $max_id=$this->getMaxGoodsId($id);
        $requestParams=array(
            'limit'=>110,
            'sp' =>!empty($sp) ? $sp : ($max_id > 0 ? $max_id : 1)
        );
        if($parent_id>0) {
            $requestParams['cate1']=$parent_id;
            $requestParams['cate2']=$id;
        } else {
            $requestParams['cate1']=$id;
        }
        $paramLen=$this->getParamsLen($requestParams);
        
        $this->rest->http_header('Cookie', 'cpsfx');
        $this->rest->http_header('Content-Length', $paramLen);
        
        $getObject = $this->rest->post('api/mall_itemgoods/get.json',$requestParams);
        $getArray=object_to_array($getObject);
        if($getArray['mall_itemgoods.get']['success']) {
        } else {
            $this->session->set_flashdata('error', lang('request_data_error'));
        }
        if(!empty($getArray['mall_itemgoods.get']['data'])) {
           $getArray=$this->filterGoods($getArray['mall_itemgoods.get']['data']);
        }else{
            $getArray=array();
        }
        $jsondata=json_encode($getArray);
        $data['jsondata']=$jsondata;
        $data['catename']=$cate_name;
        $data['cateid']=$id;
        $data['max_goods_id']=$max_id;
        $this->load->view($this->config->item('admin_folder').'/synceellygoods',$data);
    }
    
    function add_cate()
    {
        //default values are empty if the customer is new
        $data['id']				= '';
        $data['name']			= '';
        $data['slug']			= '';
        $data['description']	= '';
        $data['excerpt']		= '';
        $data['sequence']		= '';
        $data['image']			= '';
        $data['seo_title']		= '';
        $data['meta']			= '';
        $data['parent_id']		= 0;
        $data['error']			= '';
        
        $this->load->helper('text');
        	
        //first check the slug field
        $slug = $this->input->post('slug');
        	
        //if it's empty assign the name field
        if(empty($slug) || $slug=='')
        {
            $this->load->helper('pinyin');
            $slug = get_pinyin($this->input->post('name'),false,true);
        }
        //validate the slug
        $this->load->model('Routes_model');
        	
        $slug	= url_title(convert_accented_characters($slug), 'dash', TRUE);
        
        $slug	= $this->Routes_model->validate_slug($slug);
        
        $route['slug']	= $slug;
        $route_id	= $this->Routes_model->save($route);
        $save['id']				= $this->input->post('id');
        $save['name']			= $this->input->post('name');
        $save['description']	= $this->input->post('description');
        $save['excerpt']		= $this->input->post('excerpt');
        $save['parent_id']		= intval($this->input->post('parent_id'));
        $save['sequence']		= intval($this->input->post('sequence'));
        $save['seo_title']		= $this->input->post('seo_title');
        $save['meta']			= $this->input->post('meta');
        
        $save['route_id']		= intval($route_id);
        $save['slug']			= $slug;
        	
        $category_id	= $this->Category_model->simple_save($save);
        
        //save the route
        $route['id']	= $route_id;
        $route['slug']	= $slug;
        $route['route']	= 'cart/category/'.$category_id.'';
        
        $message=array('success'=>true,'msg'=>'','data'>'');
        try {
         $this->Routes_model->save($route);
        } catch (Exception $e) {
            $message['success']=false;
            $message['msg']=$e->getMessage();
        }
        echo json_encode($message);
    }
    
	function delete($id)
	{
		
		$category	= $this->Category_model->get_category($id);
		//if the category does not exist, redirect them to the customer list with an error
		if ($category)
		{
			$this->load->model('Routes_model');
			
			$this->Routes_model->delete($category->route_id);
			$this->Category_model->delete($id);
			
			$this->session->set_flashdata('message', lang('message_delete_category'));
			redirect($this->config->item('admin_folder').'/categories');
		}
		else
		{
			$this->session->set_flashdata('error', lang('error_not_found'));
		}
	}
	
	private function mappedField($rows)
	{
		$return=array();
		$this->load->helper('pinyin');
		$existcates=$this->db->get('categories')->result_array();
		function tmp_call($v){return (int)$v['id'];};
		$existscateis=array_map("tmp_call", $existcates);
		
		foreach($rows as $k=>$v)
		{
		    if(in_array($v['cateid'],$existscateis)) {
		    	continue;
		    }
		    $return[$k]['id']=$v['cateid'];
		    $return[$k]['name']=$v['catename'];
		    $return[$k]['description']=$v['catename'];
		    $return[$k]['excerpt']=$v['catename'];
		    $return[$k]['parent_id']=0;
		    if(!empty($v['parent'])) {
		        $return[$k]['parent_id']=$v['parent']['cateid'];
		    }
		    $return[$k]['sequence']=0;
		    $return[$k]['seo_title']=$this->config->item('company_name').'->'.$v['catename'];
		    $return[$k]['slug']=get_pinyin($v['catename'],false,true);
		    $return[$k]['meta']='<meta name="request" content="-app-absearch-category-'.$v['cateid'].'" /><meta name="description" content="衣联网'.$v['catename'].'价格最低，款式最多，促销活动一目了然，让你省钱又放心！" /><meta name="keywords" content="'.$v['catename'].'" /><meta name="author" content="www.eelly.com" />';
		}
		return $return;
	}
	
	private function filterGoods($rows)
	{   
	    $return=array();
	    function tmp_call($v){return (int)$v['id'];};
	    $searchGoodsId=array_map("tmp_call", $rows);
	    
	      $searchGoodsId=array_unique($searchGoodsId);
	    
	      $products= $this->db->from('products')
	        ->where_in('id',$searchGoodsId)
	        ->get()->result_array();
	      
	    $existsids=array_map("tmp_call", $products);
	    
	    foreach($rows as $k=>$v)
	    {
	        if(!empty($existsids) && in_array($v['id'],$existsids)) {
	            continue;
	        }
	        $return[$k]['goods_id']=$v['id'];
	        $return[$k]['cate1']=$v['cate1'];
	        $return[$k]['cate2']=$v['cate2'];
	        $return[$k]['title']=$v['title'];
	    }
	    return $return;
	}
	
	private function getParamsLen($params)
	{
		$leng=0;
		foreach($params as $k=>$v)
		{   
		    $leng+=(strlen($k)+strlen($v));
		}
		$leng+=2*count($params)-1;
		return $leng;
	}
	private function getMaxGoodsId($id)
	{
	    $result=$this->db->select_max('product_id')
	           ->where('category_id',$id)
	            ->get('category_products')->result_array();
	    return (int)$result[0]['product_id'];
	}
}