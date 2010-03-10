<?php
class test_123_bug extends CodeIgniterUnitTestCase
{

	function __construct()
	{
		parent::__construct();
	}

	function setUp()
	{

    }

    function tearDown()
	{

    }
	
	function test_issue3()
	{
		// $this->dump('Just some dump data');
		$this->assertEqual(11,11);
	}
	
	function test_issue2()
	{
		$this->assertEqual(12,12);
	}
	
	function test_issue1()
	{
		$this->assertEqual(1,1, '1 equals 1');
	}
}

/* End of file test_123_bug.php */
/* Location: ./tests/bugs/test_123_bug.php */ 