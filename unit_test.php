<?php
/**
 * Please note this file shouldn't be exposed on a live server,
 * there is no filtering of $_POST!!!!
 */
error_reporting(0);

/**
 * Configure your paths here:
 */
define('MAIN_PATH', realpath(dirname(__FILE__)).'/');
define('SIMPLETEST', MAIN_PATH .'tests/simpletest/'); // Directory of simpletest
define('ROOT', MAIN_PATH); // Directory of codeigniter index.php
define('TESTS_DIR', MAIN_PATH . 'tests/'); // Directory of your tests.
define('APP_DIR', MAIN_PATH . 'application/'); // CodeIgniter Application directory

//do not use autorun as it output ugly report upon no test run
require_once SIMPLETEST . 'unit_tester.php';
require_once SIMPLETEST . 'mock_objects.php';
require_once SIMPLETEST . 'collector.php';
require_once SIMPLETEST . 'web_tester.php';
require_once SIMPLETEST . 'extensions/my_reporter.php';

$test_suite = new TestSuite();
$test_suite->_label = 'CodeIgniter Test Suite';

class CodeIgniterUnitTestCase extends UnitTestCase {
	protected $ci;

	public function __construct()
	{
		parent::UnitTestCase();
		$this->_ci =& get_instance();
	}
}

class CodeIgniterWebTestCase extends WebTestCase {
	protected $_ci;

	public function __construct()
	{
		parent::WebTestCase();
		$this->_ci =& get_instance();
	}
}

// Because get is removed in ci we pull it out here.
$run_all = FALSE;
if (isset($_GET['all']) || isset($_POST['all']))
{
	$run_all = TRUE;
}



//Capture CodeIgniter output, discard and load system into $CI variable
ob_start();
	include(ROOT . 'index.php');
	$CI =& get_instance();
ob_end_clean();

$CI->load->library('session');
$CI->session->sess_destroy();

$CI->load->helper('directory');


// Get all main tests
if ($run_all OR ( ! empty($_POST) && ! isset($_POST['test'])))
{
	$test_objs = array('controllers','models','views','libraries','bugs','helpers');

	foreach ($test_objs as $obj)
	{
		if (isset($_POST[$obj]) OR $run_all)
		{
			$dir = TESTS_DIR . $obj;
			$dir_files = directory_map($dir);
			foreach ($dir_files as $file)
			{
				if ($file != 'index.html')
				{
					$test_suite->addTestFile($dir . '/' . $file);
				}
			}
		}
	}
}
elseif (isset($_POST['test'])) //single test
{
	$file = $_POST['test'];

	if (file_exists(TESTS_DIR . $file))
	{
		$test_suite->addTestFile(TESTS_DIR . $file);
	}
}

// ------------------------------------------------------------------------

/**
 * Function to map tests and strip .html files.
 *
 *
 * @param	string
 * @return 	array
 */
function map_tests($location = '')
{
	if (empty($location))
	{
		return FALSE;
	}

	$files = directory_map($location);
	$return = array();

	foreach ($files as $file)
	{
		if ($file != 'index.html')
		{
			$return[] = $file;
		}
	}
	return $return;
}

//variables for report
$controllers = map_tests(TESTS_DIR . 'controllers');
$models = map_tests(TESTS_DIR . 'models');
$views = map_tests(TESTS_DIR . 'views');
$libraries = map_tests(TESTS_DIR . 'libraries');
$bugs = map_tests(TESTS_DIR . 'bugs');
$helpers = map_tests(TESTS_DIR . 'helpers');
$form_url =  'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

//display the form
include(TESTS_DIR . 'test_gui.php');