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

		if ($result['status_code'] == 200){
			$data = [
				'status_code' => $result['status_code'],
				'transaction_status' => "settlement"
			];
			$this->db->update('payment', $data, array('order_id'=>$order_id));
			// $_SESSION['notif'] = [
			// 	'status' => 'success',
			// 	'order_id' => $order_id
			// ];
			require_once("../controller/connection.php");

			$stmt = $conn->prepare("SELECT * FROM payment WHERE order_id=$order_id");
			$stmt->execute();
			$payment = $stmt->get_result()->fetch_assoc();

			$id_payment = $payment['id'];

			$stmt = $conn->prepare("SELECT * FROM order_details WHERE payment_id=$id_payment");
			$stmt->execute();
			$od = $stmt->get_result()->fetch_assoc();

			$id_user = $od['user_id'];
			
            $active = 1;
            $transaction_status = "settlement";
			$stmt = $conn->prepare("INSERT INTO notification_handler(status, order_id, id_user, active) VALUES(?,?,?,?)");
			$stmt->bind_param("siii", $transaction_status, $order_id, $id_user, $active);
			$return = $stmt->execute();
		}
		else if ($result['status_code'] == 202){
			$data = [
				'status_code' => $result['status_code'],
				'transaction_status' => "expire"
			];
			$this->db->update('payment', $data, array('order_id'=>$order_id));
			// $_SESSION['notif'] = [
			// 	'status' => 'expired',
			// 	'order_id' => $order_id
			// ];
			require_once("../controller/connection.php");

			$stmt = $conn->prepare("SELECT * FROM payment WHERE order_id=$order_id");
			$stmt->execute();
			$payment = $stmt->get_result()->fetch_assoc();

			$id_payment = $payment['id'];

			$stmt = $conn->prepare("SELECT * FROM order_details WHERE payment_id=$id_payment");
			$stmt->execute();
			$od = $stmt->get_result()->fetch_assoc();

			$id_user = $od['user_id'];
			
            $active = 1;
            $transaction_status = "expire";
			$stmt = $conn->prepare("INSERT INTO notification_handler(status, order_id, id_user, active) VALUES(?,?,?,?)");
			$stmt->bind_param("siii", $transaction_status, $order_id, $id_user, $active);
			$return = $stmt->execute();
		}

	}
}
