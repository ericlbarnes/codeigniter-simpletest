<?php
class test_users_model extends CodeIgniterUnitTestCase
{
	var $rand = '';
	
	function __construct()
	{
		parent::__construct();
		
		$this->UnitTestCase('Users Model');
		
		$this->_ci =& get_instance();
		
		$this->_ci->load->model('users/users_model');
		
		$this->rand = rand(500,15000);
	}

	function setUp()
	{
		$this->_ci->db->flush_cache();
		
		$this->_ci->db->truncate('users'); 
		
		$insert_data = array(
			    'user_email' => 'demo'.$this->rand.'@demo.com',
			    'user_username' => 'test_'.$this->rand,
			    'user_password' => 'demo_'.$this->rand,
			    'user_join_date' => time(),
				'user_group'	=> 1
			);
		$user_id = $this->_ci->users_model->add_user($insert_data);
		$this->user = $this->_ci->users_model->get_user($user_id);
    }

    function tearDown()
	{
        $this->_ci->db->flush_cache();

		$this->_ci->db->truncate('users'); 
		
		$insert_data = array(
			    'user_email' => 'demo'.$this->rand.'@demo.com',
			    'user_username' => 'test_'.$this->rand,
			    'user_password' => 'demo_'.$this->rand,
			    'user_join_date' => time(),
				'user_group'	=> 1
			);
		$user_id = $this->_ci->users_model->add_user($insert_data);
		$this->user = $this->_ci->users_model->get_user($user_id);
    }

	public function test_included()
	{
		$this->assertTrue(class_exists('users_model'));
	}

	function test_add_user()
	{
		$this->_ci->db->truncate('users'); 
		
		$insert_data = array(
			    'user_email' => 'demo'.$this->rand.'@demo.com',
			    'user_username' => 'test_'.$this->rand,
			    'user_password' => 'demo_'.$this->rand,
			    'user_join_date' => time(),
				'user_group'	=> 1
			);
		$user_id = $this->_ci->users_model->add_user($insert_data);
		
		//$this->dump($user_id);
		$this->assertEqual($user_id, 1, 'user id = 1');
	}
	
	function test_get_user_by_id()
	{
		$this->_ci->db->flush_cache();
		$user = $this->_ci->users_model->get_user(1);
		$this->assertEqual($user['user_id'], 1);
	}
	
	function test_get_user_by_username()
	{
		$this->_ci->db->flush_cache();
		$user = $this->_ci->users_model->get_user('test_'.$this->rand);
		$this->assertEqual($user['user_id'], 1);
	}
	
	function test_edit_user()
	{
		$this->_ci->db->flush_cache();
		$insert_data = array(
			    'user_email' => 'edit_demo'.$this->rand.'@demo.com',			
			);
		$user = $this->_ci->users_model->edit_user(1, $insert_data);
		$this->assertTrue($user);
	}
	
	function test_delete_user()
	{
		$this->_ci->db->flush_cache();
		$user = $this->_ci->users_model->delete_user(1);
		$this->assertTrue($user);
	}
	
	function test_username_exists()
	{
		$this->_ci->db->flush_cache();
		$user = $this->_ci->users_model->username_check('test_'.$this->rand);
		$this->assertFalse($user);
	}
	
	function test_username_does_not_exists()
	{
		$this->_ci->db->flush_cache();
		$user = $this->_ci->users_model->username_check('my_super_test_'.$this->rand);
		$this->assertTrue($user);
	}
	
	function test_email_exists()
	{
		$this->_ci->db->flush_cache();
		$user = $this->_ci->users_model->email_check('demo'.$this->rand.'@demo.com');
		$this->assertFalse($user);
	}
	
	function test_email_does_not_exists()
	{
		$this->_ci->db->flush_cache();
		$user = $this->_ci->users_model->email_check('my_super_test_'.$this->rand.'@demo.com');
		$this->assertTrue($user);
	}
}

/* End of file test_users_model.php */
/* Location: ./tests/models/test_users_model.php */ 