<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
    {
        parent::__construct();
        $params = array('server_key' => 'your_server_key', 'production' => false);
		$this->load->library('veritrans');
		$this->veritrans->config($params);
		$this->load->helper('url');
		
    }

	public function index()
	{
		echo 'test notification handler';
		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result, 'true');

		$order_id = $result['order_id'];

		require_once('connection.php');
		$payment = $conn -> query("SELECT * FROM payment WHERE order_id='$order_id'") -> fetch_assoc();

		if ($payment['status_code'] != 999) {
			if ($result['status_code'] == 200){
				//
				$data = [
					'status_code' => $result['status_code'],
					'transaction_status' => "settlement"
				];
				$this->db->update('payment', $data, array('order_id'=>$order_id));
			}
			else if ($result['status_code'] == 202){
				$data = [
					'status_code' => $result['status_code'],
					'transaction_status' => "expire"
				];
				$this->db->update('payment', $data, array('order_id'=>$order_id));
			}
		}

	}
}
