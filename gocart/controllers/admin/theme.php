<?php

class Theme extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        remove_ssl();
        
        $this->auth->check_access('Admin', true);
        $this->lang->load('theme');
    }
    
    function index()
    {   
        $this->load->view($this->config->item('admin_folder').'/theme');
    }

    function modify_theme()
    {
        $subfolder = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\') . '/';
        $this->load->helper('file');
        $theme = $this->input->post('theme');
        $output=array('success'=>true,'messgae'=>'','data'=>'');
        
        $gocartconfig = $_SERVER['DOCUMENT_ROOT'] . $subfolder . 'gocart/config/gocart.php';
        $gocartconfigbak = $_SERVER['DOCUMENT_ROOT'] . $subfolder . 'gocart/config/gocart.bak.php';
        if (file_exists($gocartconfigbak)) {
            unlink($gocartconfigbak);
        }
        if (file_exists($gocartconfig)) {
            copy($gocartconfig, $gocartconfigbak);
            $content = file_get_contents($gocartconfig);
            $content = preg_replace('/\$config\[[\'|\"]theme[\'|\"]\].*;/', '$config["theme"]			= "' . $theme . '";', $content);
            try {
                unlink($gocartconfig);
                write_file($gocartconfig, $content);
                $output['data']=$theme;
                echo json_encode($output);
            } catch (Exception $e) {
                $output['sucess']=false;
                $output['messgae']=$e->getMessage();
                echo json_encode($output);
            }
        }
    }
}