<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {

	/**
	 * Auth controller.
	 */

    public function index()
	{

        echo 'ddd';
        exit;
		$data = $this->load->view('api/login',TRUE);
		echo json_encode($data);
	}

    public function token()
	{
        header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $jwt = new JWT();

        $jwtsecretkey = "Mykey";

        $email = $_POST['email'];
		$password = $_POST['password'];
		$user_data = $this->Login_model->login($email, $password);

        // echo '<pre>';
        // print_r($user_data['id']);
        // exit;

        if($user_data){
			
			$data = array(
                'id' => $user_data['id'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
    
            );
            
            $token = $jwt->encode($data,$jwtsecretkey,'HS256');

			// $output = $this->session->set_userdata('user', $data);
			$output['message'] = 'Logging in';
			$output['id'] = $user_data['id'];
			$output['token'] = $token;
			// $output['all_data'] = $data;
		}
		else{
			$output['error'] = true;
			$output['message'] = 'Login Invalid. User not found';
			// echo base_url()."dashboard/";  
		}

        

        // $data = array(
        //     'email' => 'alamin@gmail.com',
        //     'password' => '123456',

        // );
        
        // $edata = array();
		// $edata['token'] = $token;
		// $edata['status'] = 'ok';
        
        echo json_encode($output);

	}

    public function decode_token($token = NULL)
	{

        header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $this->load->helper('url');

        // $token = $this->uri->segment(3);

        // $token = 'bhbb';

        // print_r($product_id);
        // exit;

        $jwt = new JWT();

        $jwtsecretkey = "Mykey";

        $decode_token = $jwt->decode($token,$jwtsecretkey,'HS256');

        // echo '<pre>';
        // print_r($decode_token);
        // exit;

        $token1 = $jwt->jsonEncode($decode_token);

        echo json_encode($token1);
        // echo $token1;
	}
}