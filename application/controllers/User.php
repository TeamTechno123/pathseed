<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{
  public function __construct(){
    parent::__construct();
    $this->load->model('User_Model');
    // $this->load->model('Transaction_Model');
  }

  public function logout(){
    $this->session->sess_destroy();
    header('location:'.base_url().'User');
  }

/**************************      Login      ********************************/
  public function index(){
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');
    if ($this->form_validation->run() == FALSE) {
    	$this->load->view('User/login');
    } else{
      $email = $this->input->post('email');
      $password = $this->input->post('password');

      $login = $this->User_Model->check_login($email, $password);
      // print_r($login);
      if($login == null){
        $this->session->set_flashdata('msg','login_error');
        header('location:'.base_url().'User');
      } else{
        // echo 'null not';
        $this->session->set_userdata('path_user_id', $login[0]['user_id']);
        $this->session->set_userdata('path_company_id', $login[0]['company_id']);
        $this->session->set_userdata('path_roll_id', $login[0]['roll_id']);
        header('location:'.base_url().'User/dashboard');
      }
    }
  }

/**************************      Dashboard      ********************************/
  public function dashboard(){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
    $this->load->view('Include/head');
    $this->load->view('Include/navbar');
    $this->load->view('User/dashboard');
    $this->load->view('Include/footer');
  }

/**************************      Company Information      ********************************/

  // Company List...
  public function company_information_list(){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }

    $data['company_list'] = $this->User_Model->get_list($path_company_id,'company_id','ASC','company');
    $this->load->view('Include/head', $data);
    $this->load->view('Include/navbar', $data);
    $this->load->view('User/company_information_list', $data);
    $this->load->view('Include/footer', $data);
  }

  // Edit Company...
  public function edit_company($company_id){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }

    $this->form_validation->set_rules('company_name', 'company_name', 'trim|required');
    $this->form_validation->set_rules('company_address', 'company_address', 'trim|required');
    if ($this->form_validation->run() != FALSE) {
      $up_data = array(
        'company_name' => $this->input->post('company_name'),
        'company_address' => $this->input->post('company_address'),
        'company_city' => $this->input->post('company_city'),
        'company_state' => $this->input->post('company_state'),
        'company_district' => $this->input->post('company_district'),
        'company_statecode' => $this->input->post('company_statecode'),
        'company_mob1' => $this->input->post('company_mob1'),
        'company_mob2' => $this->input->post('company_mob2'),
        'company_email' => $this->input->post('company_email'),
        'company_website' => $this->input->post('company_website'),
        'company_pan_no' => $this->input->post('company_pan_no'),
        'company_gst_no' => $this->input->post('company_gst_no'),
        'company_lic1' => $this->input->post('company_lic1'),
        'company_lic2' => $this->input->post('company_lic2'),
        'company_start_date' => $this->input->post('company_start_date'),
        'company_end_date' => $this->input->post('company_end_date'),
      );
      $this->User_Model->update_info('company_id', $company_id, 'company', $up_data);
      $this->session->set_flashdata('update_success','success');
      header('location:'.base_url().'User/company_information_list');
    }
    $company_info = $this->User_Model->get_info('company_id', $company_id, 'company');
    if($company_info){
      foreach($company_info as $info){
        $data['update'] = 'update';
        $data['company_id'] = $info->company_id;
        $data['company_name'] = $info->company_name;
        $data['company_address'] = $info->company_address;
        $data['company_city'] = $info->company_city;
        $data['company_state'] = $info->company_state;
        $data['company_district'] = $info->company_district;
        $data['company_statecode'] = $info->company_statecode;
        $data['company_mob1'] = $info->company_mob1;
        $data['company_mob2'] = $info->company_mob2;
        $data['company_email'] = $info->company_email;
        $data['company_website'] = $info->company_website;
        $data['company_pan_no'] = $info->company_pan_no;
        $data['company_gst_no'] = $info->company_gst_no;
        $data['company_lic1'] = $info->company_lic1;
        $data['company_lic2'] = $info->company_lic2;
        $data['company_start_date'] = $info->company_start_date;
        $data['company_end_date'] = $info->company_end_date;
      }
      $this->load->view('Include/head', $data);
      $this->load->view('Include/navbar', $data);
      $this->load->view('User/company_information', $data);
      $this->load->view('Include/footer', $data);
    }
  }

/**************************************************************************************/
/*******                                Master Forms                          *********/
/**************************************************************************************/


/*******************************    User Information      ****************************/

  // Add New User....
  public function add_user(){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
    $this->form_validation->set_rules('user_name', 'First Name', 'trim|required');
    if ($this->form_validation->run() != FALSE) {
      $save_data = array(
        'company_id' => $path_company_id,
        'user_name' => $this->input->post('user_name'),
        'user_mobile' => $this->input->post('user_mobile'),
        'user_email' => $this->input->post('user_email'),
        'user_city' => $this->input->post('user_city'),
        'user_password' => $this->input->post('user_password'),
        'user_addedby' => $path_user_id,
      );
      $this->User_Model->save_data('user', $save_data);
      $this->session->set_flashdata('save_success','success');
      header('location:'.base_url().'User/user_list');
    }
    $this->load->view('Include/head');
    $this->load->view('Include/navbar');
    $this->load->view('User/user');
    $this->load->view('Include/footer');
  }

  // User List....
  public function user_list(){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
    $data['user_list'] = $this->User_Model->user_list($path_company_id);
    $this->load->view('Include/head',$data);
    $this->load->view('Include/navbar',$data);
    $this->load->view('User/user_list',$data);
    $this->load->view('Include/footer',$data);
  }

  // Edit User....
  public function edit_user($user_id){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
    $this->form_validation->set_rules('user_name', 'First Name', 'trim|required');
    if ($this->form_validation->run() != FALSE) {
      $update_data = array(
        'user_name' => $this->input->post('user_name'),
        'user_mobile' => $this->input->post('user_mobile'),
        'user_email' => $this->input->post('user_email'),
        'user_city' => $this->input->post('user_city'),
        'user_password' => $this->input->post('user_password'),
        'user_addedby' => $path_user_id,
      );
      $this->User_Model->update_info('user_id', $user_id, 'user', $update_data);
      $this->session->set_flashdata('update_success','success');
      header('location:'.base_url().'User/user_list');
    }

    $user_info = $this->User_Model->get_info('user_id', $user_id, 'user');
    if($user_info == ''){ header('location:'.base_url().'User/user_list'); }
    foreach($user_info as $info){
      $data['update'] = 'update';
      $data['user_name'] = $info->user_name;
      $data['user_mobile'] = $info->user_mobile;
      $data['user_email'] = $info->user_email;
      $data['user_city'] = $info->user_city;
      $data['user_password'] = $info->user_password;
    }
    $this->load->view('Include/head',$data);
    $this->load->view('Include/navbar',$data);
    $this->load->view('User/user',$data);
    $this->load->view('Include/footer',$data);
  }

  // Delete User....
  public function delete_user($user_id){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
    $this->User_Model->delete_info('user_id', $user_id, 'user');
    $this->session->set_flashdata('delete_success','success');
    header('location:'.base_url().'User/user_list');
  }
/**********************      Blog Information      *****************************/


  // public function blog_list(){
  //   $path_user_id = $this->session->userdata('path_user_id');
  //   $path_company_id = $this->session->userdata('path_company_id');
  //   $path_roll_id = $this->session->userdata('path_roll_id');
  //   if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
  //   $data['blog_list'] = $this->User_Model->user_list($path_company_id);
  //   $this->load->view('Include/head',$data);
  //   $this->load->view('Include/navbar',$data);
  //   $this->load->view('User/blog_list',$data);
  //   $this->load->view('Include/footer',$data);
  // }
  //
  //
  // public function blog(){
  //   $path_user_id = $this->session->userdata('path_user_id');
  //   $path_company_id = $this->session->userdata('path_company_id');
  //   $path_roll_id = $this->session->userdata('path_roll_id');
  //   if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
  //   $this->load->view('Include/head');
  //   $this->load->view('Include/navbar');
  //   $this->load->view('User/blog');
  //   $this->load->view('Include/footer');
  // }


  public function blog(){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
    $this->form_validation->set_rules('blog_name', 'First Name', 'trim|required');
    if ($this->form_validation->run() != FALSE) {
      $save_data = array(
        'company_id' => $path_company_id,
        'blog_name' => $this->input->post('blog_name'),
        'blog_description' => $this->input->post('blog_description'),
        'blog_addedby' => $path_user_id,
      );

    $blog_id = $this->User_Model->save_data('blog', $save_data);

      if(isset($_FILES['blog_image']['name'])){
       $time = time();
       $image_name = 'blog_'.$blog_id.'_'.$time;
       $config['upload_path'] = 'assets/images/blog/';
       $config['allowed_types'] = 'png|jpg';
       $config['file_name'] = $image_name;
       $filename = $_FILES['blog_image']['name'];
       $ext = pathinfo($filename, PATHINFO_EXTENSION);
       // $this->load->library('upload', $config);
       $this->upload->initialize($config);
       if ($this->upload->do_upload('blog_image')){
         $up_image = array(
           'blog_image' => $image_name.'.'.$ext,
         );
         $this->User_Model->update_info('blog_id', $blog_id, 'blog', $up_image);
       }
       else{
      echo   $error = $this->upload->display_errors();
         $this->session->set_flashdata('status',$this->upload->display_errors());
       }
     }

      $this->session->set_flashdata('save_success','success');
      header('location:'.base_url().'User/blog_list');
    }
    $this->load->view('Include/head');
    $this->load->view('Include/navbar');
    $this->load->view('User/blog');
    $this->load->view('Include/footer');
  }

  // User List....
  public function blog_list(){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
    $data['blog_list'] = $this->User_Model->get_list($path_company_id,'company_id','ASC','blog');
    $this->load->view('Include/head',$data);
    $this->load->view('Include/navbar',$data);
    $this->load->view('User/blog_list',$data);
    $this->load->view('Include/footer',$data);
  }

  // Edit User....
  public function edit_blog($blog_id){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
    $this->form_validation->set_rules('blog_name', 'First Name', 'trim|required');
    if ($this->form_validation->run() != FALSE) {
      $update_data = array(
        'blog_name' => $this->input->post('blog_name'),
        'blog_description' => $this->input->post('blog_description'),
        'blog_image' => $this->input->post('blog_image'),
        'blog_status' => $this->input->post('blog_status'),
        'blog_addedby' => $path_user_id,
      );
        $this->User_Model->update_info('blog_id', $blog_id, 'blog', $update_data);
      if(isset($_FILES['blog_image']['name'])){
       $time = time();
       $image_name = 'blog_'.$blog_id.'_'.$time;
       $config['upload_path'] = 'assets/images/blog/';
       $config['allowed_types'] = 'png|jpg';
       $config['file_name'] = $image_name;
       $filename = $_FILES['blog_image']['name'];
       $ext = pathinfo($filename, PATHINFO_EXTENSION);
       // $this->load->library('upload', $config);
       $this->upload->initialize($config);
       if ($this->upload->do_upload('blog_image')){
         $up_image = array(
           'blog_image' => $image_name.'.'.$ext,
         );
         $this->User_Model->update_info('blog_id', $blog_id, 'blog', $up_image);
       }
       else{
      echo   $error = $this->upload->display_errors();
         $this->session->set_flashdata('status',$this->upload->display_errors());
       }
     }

      $this->session->set_flashdata('update_success','success');
      header('location:'.base_url().'User/blog_list');
    }

    $blog_info = $this->User_Model->get_info_arr('blog_id', $blog_id, 'blog');
    if($blog_info == ''){ header('location:'.base_url().'User/blog_list'); }
    $data['blog_info']=$blog_info[0];
    $this->load->view('Include/head',$data);
    $this->load->view('Include/navbar',$data);
    $this->load->view('User/blog',$data);
    $this->load->view('Include/footer',$data);
  }

  // Delete User....
  public function delete_blog($blog_id){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
    $this->User_Model->delete_info('blog_id', $blog_id, 'blog');
    $this->session->set_flashdata('delete_success','success');
    header('location:'.base_url().'User/blog_list');
  }

/**********************     country Information      **********************/


  public function country_list(){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
    $data['country_list'] = $this->User_Model->user_list($path_company_id);
    $this->load->view('Include/head',$data);
    $this->load->view('Include/navbar',$data);
    $this->load->view('User/country_list',$data);
    $this->load->view('Include/footer',$data);
  }


  public function country(){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
    $this->load->view('Include/head');
    $this->load->view('Include/navbar');
    $this->load->view('User/country');
    $this->load->view('Include/footer');
  }

/*******************************  service Information  ****************************/
  public function service_list(){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
    $data['service_list'] = $this->User_Model->user_list($path_company_id);
    $this->load->view('Include/head',$data);
    $this->load->view('Include/navbar',$data);
    $this->load->view('User/service_list',$data);
    $this->load->view('Include/footer',$data);
  }


  public function service(){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
    $this->load->view('Include/head');
    $this->load->view('Include/navbar');
    $this->load->view('User/service');
    $this->load->view('Include/footer');
  }

  /*******************************  stream Information  ****************************/
    public function stream_list(){
      $path_user_id = $this->session->userdata('path_user_id');
      $path_company_id = $this->session->userdata('path_company_id');
      $path_roll_id = $this->session->userdata('path_roll_id');
      if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
      $data['stream_list'] = $this->User_Model->user_list($path_company_id);
      $this->load->view('Include/head',$data);
      $this->load->view('Include/navbar',$data);
      $this->load->view('User/stream_list',$data);
      $this->load->view('Include/footer',$data);
    }


    public function stream(){
      $path_user_id = $this->session->userdata('path_user_id');
      $path_company_id = $this->session->userdata('path_company_id');
      $path_roll_id = $this->session->userdata('path_roll_id');
      if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
      $this->load->view('Include/head');
      $this->load->view('Include/navbar');
      $this->load->view('User/stream');
      $this->load->view('Include/footer');
    }

    /*******************************  testimonial Information  ****************************/
      public function testimonial_list(){
        $path_user_id = $this->session->userdata('path_user_id');
        $path_company_id = $this->session->userdata('path_company_id');
        $path_roll_id = $this->session->userdata('path_roll_id');
        if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
        $data['testimonial_list'] = $this->User_Model->user_list($path_company_id);
        $this->load->view('Include/head',$data);
        $this->load->view('Include/navbar',$data);
        $this->load->view('User/testimonial_list',$data);
        $this->load->view('Include/footer',$data);
      }


      public function testimonial(){
        $path_user_id = $this->session->userdata('path_user_id');
        $path_company_id = $this->session->userdata('path_company_id');
        $path_roll_id = $this->session->userdata('path_roll_id');
        if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
        $this->load->view('Include/head');
        $this->load->view('Include/navbar');
        $this->load->view('User/testimonial');
        $this->load->view('Include/footer');
      }


/*******************************  university Information  ****************************/
  public function university_list(){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
    $data['university_list'] = $this->User_Model->user_list($path_company_id);
    $this->load->view('Include/head',$data);
    $this->load->view('Include/navbar',$data);
    $this->load->view('User/university_list',$data);
    $this->load->view('Include/footer',$data);
  }


  public function university(){
    $path_user_id = $this->session->userdata('path_user_id');
    $path_company_id = $this->session->userdata('path_company_id');
    $path_roll_id = $this->session->userdata('path_roll_id');
    if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
    $this->load->view('Include/head');
    $this->load->view('Include/navbar');
    $this->load->view('User/university');
    $this->load->view('Include/footer');
  }


  /*******************************  organization Information  ****************************/
    public function organization_list(){
      $path_user_id = $this->session->userdata('path_user_id');
      $path_company_id = $this->session->userdata('path_company_id');
      $path_roll_id = $this->session->userdata('path_roll_id');
      if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
      $data['organization_list'] = $this->User_Model->user_list($path_company_id);
      $this->load->view('Include/head',$data);
      $this->load->view('Include/navbar',$data);
      $this->load->view('User/organization_list',$data);
      $this->load->view('Include/footer',$data);
    }


    public function organization(){
      $path_user_id = $this->session->userdata('path_user_id');
      $path_company_id = $this->session->userdata('path_company_id');
      $path_roll_id = $this->session->userdata('path_roll_id');
      if($path_user_id == '' && $path_company_id == ''){ header('location:'.base_url().'User'); }
      $this->load->view('Include/head');
      $this->load->view('Include/navbar');
      $this->load->view('User/organization');
      $this->load->view('Include/footer');
    }

/*******************************  Check Duplication  ****************************/
  public function check_duplication(){
    $column_name = $this->input->post('column_name');
    $column_val = $this->input->post('column_val');
    $table_name = $this->input->post('table_name');
    $company_id = '';
    $cnt = $this->User_Model->check_dupli_num($company_id,$column_val,$column_name,$table_name);
    echo $cnt;
  }


}
?>
