<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friends extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('friend');
	}
	public function index()
	{
		if($this->session->userdata('email') == null)
		{
			$this->load->view('loginView');
		}
		else
		{
			$friends = $this->friend->getMyFriends($this->session->userdata['id']);
			$notfriends = $this->friend->getnotFriends($this->session->userdata['id']);
			$notfriends = $this->getnotFriends($friends, $notfriends);
			$passit['myfriends'] = $friends;
			$passit['notfriends'] = $notfriends;
			$this->load->view('welcomeView',$passit);
		}
	}
	public function login()
	{
		$post = $this->input->post();
		$dataget = $this->friend->getUserRow($post['email']);
		if($dataget != null)
		{
			if($post['password'] == $dataget->password)
			{
				$this->session->set_userdata('name', $dataget->name);
				$this->session->set_userdata('alias', $dataget->alias);
				$this->session->set_userdata('email', $dataget->email);
				$this->session->set_userdata('id', $dataget->id);
			}
			else
			{
				$this->session->set_flashdata('loginemail', $this->input->post('email'));
				$this->session->set_userdata('usernamenotfound', true);	
			}
		}
		else
		{
			$this->session->set_flashdata('loginemail', $this->input->post('email'));
			$this->session->set_userdata('usernamenotfound', true);
		}
		redirect('/');	
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}
	public function register()
	{
		$this->form_validation->set_rules('name','Name','trim|required|min_length[3]');
		$this->form_validation->set_rules('alias','Alias','trim|required|min_length[3]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|min_length[3]');
		$this->form_validation->set_rules('password','Password','required|min_length[8]|matches[Confirm_Password]');
		$dateofbirth = $this->dategetter($this->input->post('dateofbirth'));
		$today = $this->getToday();
		$hiredtodayorearlier = $this->isdateAafterdateB($today, $dateofbirth);
		if(!$this->form_validation->run() || !$hiredtodayorearlier)
		{	
			$this->session->set_flashdata('errors', validation_errors());
			$this->session->set_flashdata('name', $this->input->post('name'));
			$this->session->set_flashdata('alias', $this->input->post('alias'));
			$this->session->set_flashdata('registeremail', $this->input->post('email'));
			$this->session->set_flashdata('dateofbirth', $this->input->post('dateofbirth'));
			if(!$hiredtodayorearlier)
			{
				$this->session->set_flashdata('dateofbirthbad', 'You must have been born at least last night!');
			}
			redirect('/');
		}
		else
		{
			$post = $this->input->post();
			$dataget = $this->friend->getUserInfo(trim($post['email']));
			if($dataget == null)
			{
				$this->friend->insertNewUser($post);
				$this->session->set_userdata('name',trim($post['name']));
				$this->session->set_userdata('alias',trim($post['alias']));
				$this->session->set_userdata('email',trim($post['email']));
				$this->session->set_userdata('id',$this->db->insert_id());
				redirect('/');
			}
			else
			{
				$this->session->set_flashdata('errors', 'The email ' . $post['email'] . ' already exists, please choose a different one');
				$this->session->set_flashdata('mailalreadyexists', $this->input->post('email'));
				redirect('/');
			}
		}
	}
	public function userinfo($id)
	{
		$passit['userinfo'] = $this->friend->getUserInfo($id);
		$this->load->view('userinfoView', $passit);
	}
	public function addFriend()
	{
		$this->friend->addFriend(intval($this->input->post('id')));
		redirect('/');
	}
	public function removeFriend($id)
	{
		$this->friend->removeFriend($id);
		redirect('/');
	}
	public function getToday()
	{
		$thisyear = date('Y');
		$thismonth = date('m');
		$thisday = date('d');
		$today['year'] = date('Y');
		$today['month'] = date('m');
		$today['day'] = date('d');
		return $today;
	}
	public function dategetter($date)
	{

		$i = 0;
		$newdate = $date;
		while($newdate[$i] != '-')
		{
			++$i;
		}
		$newyear = substr($newdate,0,$i);
		++$i;
		$j = $i;
		while($newdate[$j] != '-')
		{
			++$j;
		}
		$k = $j - $i;
		$newmonth = substr($newdate,$i,$k);
		++$j;
		$i = $j;
		while($i < strlen($newdate))
		{
			++$i;
		}
		$k = $i - $j;
		$newday = substr($newdate,$j,$k);
		$returndate['year'] = $newyear;
		$returndate['month'] = $newmonth;
		$returndate['day'] = $newday;
		return $returndate;
	}
	public function isdateAafterdateB($dateA, $dateB)
	{
		if(intval($dateA['year']) > intval($dateB['year']))
		{
			return true;
		}
		else if(intval($dateA['year']) < intval($dateB['year']))
		{
			return false;
		}
		else
		{
			if(intval($dateA['month']) > intval($dateB['month']))
			{
				return true;
			}
			else if(intval($dateA['month']) < intval($dateB['month']))
			{
				return false;
			}
			else
			{
				if(intval($dateA['day']) > intval($dateB['day']))
				{
					return true;
				}
			}
		}
		return false;
	}
	public function getnotFriends($friends, $notfriends)
	{
		// var_dump($friends);
		// var_dump($notfriends);
		if($friends == null)
		{
			return $notfriends;
		}
		$add = true;
		$temp = array();
		foreach($notfriends as $friend)
		{
			foreach($friends as $friend2)
			{

				if($friend['friend_id'] == $friend2['friend_id'])
				{
					$add = false;
					break;
				}
			}
			if($add == true)
			{
				$temp[] = array('friend_id'=>$friend['friend_id'],'friend_alias'=>$friend['friend_alias']);
			}
			$add = true;
		}
		return $temp;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */