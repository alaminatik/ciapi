<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends CI_Controller {

	/**
	 * User Login controller.
	 */

	function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$data =$this->load->view('Frontend/common/header',TRUE);
		$data =$this->load->view('Frontend/home',TRUE);
		$data =$this->load->view('Frontend/common/footer',TRUE);
		echo json_encode($data);
	}

	public function Sign_up()
	{
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

		$data = $this->load->view('Frontend/signup',TRUE);
		$data = $this->load->view('Frontend/common/header',TRUE);
		// $data = 'sdsdsd';
		echo json_encode($data);

		// $this->load->view('Frontend/common/header');
	}

	public function user_reg_save()
	{
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

		$name = $this->input->post('name');
		$user_name=$this->input->post('user_name');
		$user_email=$this->input->post('email');
		$password=sha1($this->input->post('password'));
		$user_phone=$this->input->post('phone');
		$user_national_id=$this->input->post('national_id');
	    $user_confirm_password=sha1($this->input->post('con_password'));

		if ($password == $user_confirm_password) {
			$password = $password;
		}

		$data = array(
			'name' 	    	=>  $name,
			'user_name' 	=> 	$user_name,
			'email' 		=>  $user_email,
			'password' 		=>  $password,
			'phone' 		=>  $user_phone,
			'national_id' 	=> 	$user_national_id,
		);

		$data=$this->Sign_up_model->user_reg_save($data);

		if($data){
			
			$this->session->set_userdata('user', $data);
			$output['message'] = 'Registration Successfully Completed';
		}
		else{

			$output['error'] = true;
			$output['message'] = 'Registration Invalid. User Cant Not be Empty';
			// echo base_url()."dashboard/";  
		}
		
    	echo json_encode($output);

	}


	public function log_in()
	{

        // echo 'ddd';
        // exit;
		$data = $this->load->view('api/login',TRUE);
		echo json_encode($data);
	}

	public function log_in_submit()
	{
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

		$output = array('error' => false);

		// $email = 'alaminmia1000@gmail.com';
		$email = $_POST['email'];
		$password = $_POST['password'];
		$data = $this->Login_model->login($email, $password);

		// echo json_encode($data);
        // print_r($email);
        // die;

		if($data){
			
			
            
			$output = $this->session->set_userdata('user', $data);
			$output['message'] = 'Logging in. Please wait...';
			$output['id'] = $data['id'];
			$output['name'] = $data['name'];
			// $output['all_data'] = $data;
		}
		else{
			$output['error'] = true;
			$output['message'] = 'Login Invalid. User not found';
			// echo base_url()."dashboard/";  
		}

		echo json_encode($output); 
	}

	public function user_r()
	{
		$user_data = array(
			'email' => $_POST['email'],
			'password' => $_POST['password'],
			'name' => $_POST['name'],
		);
		// $data = $this->Login_model->get_data('users','','');
		$this->Register_model->user_reg_save($user_data);
		$data['message'] = 'Registration Successfully Completed';
		echo json_encode($data);
	}

	public function user_dashboard(){

		// header("Access-Control-Allow-Origin: *");
		// header("Content-Type: application/json; charset=UTF-8");
		// header("Access-Control-Allow-Methods: POST");
		// header("Access-Control-Max-Age: 3600");
		// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        // if (!$this->session->userdata('id')) {

        //     redirect('userlogin');
        // }

		$output =$this->load->view('api/home',TRUE);

		// $output['message'] = 'User dashboard';
		echo json_encode($output); 
		// return $output; 
	}
	
	public function logout(){

		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	//load session library
	$this->load->library('session');
	$this->session->unset_userdata('user');
	$output['message'] = 'User Logout';
			echo json_encode($output); 

	}

	
	public function profile()
	{

		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

		$id = $this->input->get('user_id');
		//echo $data;
		$where = array('id'=>$id);
	
	$data=$this->Admin_model->get_data('users','',$where);
	if ($data) {
		$output['id']= $data[0]['id'];
		$output['name']= $data[0]['name'];
		$output['email']= $data[0]['email'];
		$output['user_name']= $data[0]['user_name'];
		$output['phone']= $data[0]['phone'];
		$output['user_image']= $data[0]['user_image'];
	}
		echo json_encode($output);

	}

	public function update_profile()
	{

		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

		$id = $this->input->post('user_id');
		$name = $this->input->post('name');
		$user_name = $this->input->post('user_name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$where = array('id'=>$id);

	// $data=$this->Admin_model->get_data('users','',$where);
	// if ($data) {
	// 	$output['id']= $data[0]['id'];
	// 	$output['name']= $data[0]['name'];
	// 	$output['email']= $data[0]['email'];
	// 	$output['user_name']= $data[0]['user_name'];
	// 	$output['phone']= $data[0]['phone'];
	// }

            $userfilename = $_FILES['image']['name'];
            
            if (!empty($userfilename)) {

                $file_name =$_FILES['image']['name'];

                    $config = array(
                        'upload_path' => "./Frontend/images/",
                        'allowed_types' => "gif|jpg|png|jpeg",
                        'file_name' => $file_name,
                    );

                    $this->load->library('upload',$config);


                     if($this->upload->do_upload("image")){
            $data = array('upload_data' => $this->upload->data());
 
             $data=array(
					 'name'=>$name,
					 'user_name'=>$user_name,
					 'email'=>$email,
					 'phone'=>$phone,
					 'user_image'=>$file_name,
					);
             
                $img_up_result = $this->Admin_model->updater($where,'users', $data);
                  if ($img_up_result > 0) {

                    $output['message'] = 'User  Successfully Updated';
                } else {
                   $output['message']  = 'User  Successfully Updated';
                    $output['message'] =true;
                }
        }
                   
                    // return print_r($file_data);
              
            }
            else{

            	$data=array(
					 'name'=>$name,
					 'user_name'=>$user_name,
					 'email'=>$email,
					 'phone'=>$phone
					);
             
                $without_image = $this->Admin_model->updater($where,'users', $data);
                  if ($without_image > 0) {

                    $output['message'] = 'User  Successfully Updated';
                } else {
                   $output['message']  = 'User  Successfully Updated';
                    $output['message'] ='User Field Empty';
                }

            }
           

		echo json_encode($output);

	}

	public function update_password() {
		
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $user_id = $this->input->post('user_id');


        $sdata = array(
            'password' => sha1($new_password)
        );
        $where = array(
            'id' => $user_id
        );
        $wheres = array(
            'id' => $user_id,
            'password' => sha1($old_password)
        );
        $old_p = $this->Admin_model->get_data('users', '', $wheres);

        if (!empty($old_p)) {
            $this->Admin_model->updater($where, 'users', $sdata);
            $output['message'] = 'Password Update Successfully';
        } else {

            $output['error'] = true;
            $output['message'] = 'Old Password Invalid.';
            // echo base_url()."dashboard/";  
        }

        echo json_encode($output);
    }

}
