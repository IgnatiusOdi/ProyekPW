<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
class Snap extends CI_Controller {

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
        $params = array('server_key' => 'SB-Mid-server-9cCMZPpK6GbrSgIRglu4CQE7', 'production' => false);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->helper('url');	
    }

    public function index()
    {
    	$this->load->view('checkout_snap');
    }

    public function token()
    {
        // Required
        $transaction_details = array(
            'order_id' => rand(),
            'gross_amount' => (int)$this->input->post('amount'), // no decimal allowed for creditcard
        );

        $cart_item = json_decode($this->input->post('cart_item'), TRUE);
        // echo "<pre>";
        // var_dump($cart_item);
        // var_dump($this->input->post('amount'));
        // echo "</pre>";
        $item_details = array ();
        foreach($cart_item as $key => $value){
            $item1_details = array(
                'id' => ($key+1),
                'price' => (int)$value['price'],
                'quantity' => (int)$value['quantity'],
                'name' => $value['name']
            );

            $item_details[] = $item1_details;
        }

        $user = json_decode($this->input->post('user'), TRUE);

        // Optional
        $customer_details = array(
          'first_name'    => $user['nama_user'],
          'last_name'     => '',
          'email'         => $user['email_user']
        );

        // Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O",$time),
            'unit' => 'minute', 
            'duration'  => 5
        );

        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

        error_log(json_encode($transaction_data));
        $snapToken = $this->midtrans->getSnapToken($transaction_data);

        error_log($snapToken);
        echo $snapToken;
    }

    public function finish()
    {
		$result = json_decode($this->input->post('result_data')); 
		$userid = $this->input->post('userid'); 
		// echo "<pre>";
		// print_r($result);
		// echo "</pre>";	
		if (isset($result->va_numbers[0]->bank)){
			$bank = $result->va_numbers[0]->bank;
		}
		else{
			$bank = '-';
		}
		
		if (isset($result->va_numbers[0]->va_number)){
			$va_number = $result->va_numbers[0]->va_number;
		}
		else{
			$va_number = '-';
		}

		if (isset($result->bill_key)){
			$bill_key = $result->bill_key;
		}
		else{
			$bill_key = '-';
		}
		
		if (isset($result->biller_code)){
			$biller_code = $result->biller_code;
		}
		else{
			$biller_code = '-';
		}

		$data = [
			'status_code' => $result->status_code,
			'status_message' => $result->status_message,
			'transaction_id' => $result->transaction_id,
			'order_id' => $result->order_id,
			'gross_amount' => $result->gross_amount,
			'payment_type' => $result->payment_type,
			'transaction_time' => $result->transaction_time,
			'transaction_status' => $result->transaction_status,
			'bank' => $bank,
			'va_number' => $va_number,
			'fraud_status' => $result->fraud_status,
			'pdf_url' => $result->pdf_url,
			'finish_redirect_url' => $result->finish_redirect_url,
			'bill_key' => $bill_key,
			'biller_code' => $biller_code,
		];
		$simpan = $this->db->insert('payment', $data);
		
		$user = json_decode($this->input->post('user'), TRUE);

		require_once('connection.php');
		$idUser = $_SESSION['user'] + 1;

		//ADD HTRANS
		$sql = "SELECT id, transaction_time, gross_amount FROM payment ORDER BY id DESC LIMIT 1";
		$q = $conn -> query($sql) -> fetch_assoc();
		$tanggal = $q['transaction_time'];
		$total = $q['gross_amount'];
		$id_payment = $q['id'];

		$sql = "INSERT INTO `htrans`(`tanggal_transaksi`, `id_users`, `total`, `id_payment`) VALUES (?,?,?,?)";
		$q = $conn -> prepare($sql);
		$q -> bind_param("siii", $tanggal, $idUser, $total, $id_payment);
		$q -> execute();

		//ADD DTRANS
		$sql = "SELECT * FROM cart WHERE id_users='$idUser'";
		$listCart = $conn -> query($sql) -> fetch_all(MYSQLI_ASSOC);
		foreach ($listCart as $key => $value) {
			$idBarang = $value['id_barang'];
			$jumlah = $value['jumlah'];
			$sql = "INSERT INTO `dtrans`(`id_htrans`, `id_barang`, `jumlah`, `id_users`) VALUES (?,?,?,?)";
			$q = $conn -> prepare($sql);
			$q -> bind_param("iiii", $id_payment, $idBarang, $jumlah, $idUser);
			$q -> execute();
		}
		
		//HAPUS CART
		$sql = "DELETE FROM `cart` WHERE id_users='$idUser'";
		$q = $conn -> prepare($sql);
		$q -> execute();

		echo "<script>alert('Please Pay Soon ASAP')</script>";
    	$this->data['finish'] = json_decode($this->input->post('result_data')); 
		// $this->load->view('transaction');
		echo "<script>window.location = '../../../php/history.php';</script>";
    }
}
