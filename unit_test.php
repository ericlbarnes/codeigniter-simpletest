<?php
/**
 * Please note this file shouldn't be exposed on a live server,
 * there is no filtering of $_POST!!!!
 */
error_reporting(0);
 
/**
 * Configure your paths here:
 */
define('MAIN_PATH', str_replace('/upload', '', realpath(dirname(__FILE__))).'/');
define('SIMPLETEST', MAIN_PATH .'do_not_upload/tests/simpletest/');
define('ROOT', MAIN_PATH .'upload/');
define('TESTS_DIR', MAIN_PATH . 'do_not_upload/tests/');
define('APP_DIR', MAIN_PATH . 'upload/includes/iclassengine/');
define('ENV', 'local');

if ( ! empty($_POST) OR ! empty($_GET)) 
{ 
	//autorun will load failed test if no tests are present to run
	require_once SIMPLETEST .'autorun.php';
	require_once SIMPLETEST .'web_tester.php';
	require_once SIMPLETEST . 'mock_objects.php';
	require_once SIMPLETEST . 'extensions/my_reporter.php';
	$test = new TestSuite();
	$test->_label = 'iClassEngine Test Suite';
	
	class CodeIgniterUnitTestCase extends UnitTestCase { 
		protected $ci;

		public function __construct() {
			parent::UnitTestCase();
			$this->_ci = CI_Base::get_instance();
		}
	}

	class CodeIgniterWebTestCase extends WebTestCase { 
		protected $_ci;

		public function __construct() {
			parent::WebTestCase();
			$this->_ci = CI_Base::get_instance();
		}
	}
}

// Because get is removed in ci we pull it out here.
$run_all = FALSE;
if (isset($_GET['all']))
{
	$run_all = TRUE;
}

function add_test($dir, $file, &$test) 
{
	$implementation = '';
	if (file_exists(TESTS_DIR . $dir .'/'. $file)) 
	{
		$test->addTestFile(TESTS_DIR . $dir .'/' . $file);
	}
	elseif (file_exists(EXTPATH . $dir .'/'. $file)) 
	{
		$test->addTestFile(EXTPATH . $dir .'/' . $file);
	}
}




//Capture CodeIgniter output, discard and load system into $CI variable
ob_start();
	include(ROOT . 'index.php');
	$CI =& get_instance();
ob_end_clean();

// This checks to see if setup needs to be ran.
if ( ! defined('ENV'))
{
	redirect('home');
}

$CI->session->sess_destroy();
$CI->load->helper('directory');

$url = base_url();

// Get all addons
foreach (directory_map(EXTPATH, TRUE) AS $addon)
{
	if (file_exists(EXTPATH . $addon .'/'.$addon.'_unit_test.php'))
	{
		$addons[] = $addon;
	}
}

// Get all main tests
function read_dir($dir)
{
	$dirs = array();
	foreach (directory_map($dir) AS $dir)
	{
		$dirs[] = $dir;
	}
	return $dirs;
}

$controllers = read_dir(TESTS_DIR . 'controllers');
$models = read_dir(TESTS_DIR . 'models');
$views = read_dir(TESTS_DIR . 'views');
$libraries = read_dir(TESTS_DIR . 'libraries');
$bugs = read_dir(TESTS_DIR . 'bugs');
$helpers = read_dir(TESTS_DIR . 'helpers');

if ($run_all OR ( ! empty($_POST) && ! isset($_POST['test'])))
{
	$run_tests = TRUE;
	if (isset($_POST['addons']) OR isset($_POST['all']) OR $run_all) 
	{
		foreach ($addons as $value) 
		{
			$file = $value.'_unit_test.php';
			add_test($value, $file, $test);
		}
	}
	
	if (isset($_POST['controllers']) OR isset($_POST['all']) OR $run_all) {
		$dirs[] = TESTS_DIR . 'controllers';
	}
	if (isset($_POST['models']) OR isset($_POST['all']) OR $run_all) {
		$dirs[] = TESTS_DIR . 'models';
	}
	if (isset($_POST['views']) OR isset($_POST['all']) OR $run_all) {
		$dirs[] = TESTS_DIR . 'views';
	}
	if (isset($_POST['libraries']) OR isset($_POST['all']) OR $run_all) {
		$dirs[] = TESTS_DIR . 'libraries';
	}
	if (isset($_POST['bugs']) OR isset($_POST['all']) OR $run_all) {
		$dirs[] = TESTS_DIR . 'bugs';
	}
	if (isset($_POST['helpers']) OR isset($_POST['all']) OR $run_all) {
		$dirs[] = TESTS_DIR . 'helpers';
	}

	if ( ! empty($dirs))
	{
		foreach ($dirs as $dir) 
		{
			$dir_files = read_dir($dir);

			foreach ($dir_files as $file) 
			{
				if (false !== strpos($file, '_controller')) {
					if (file_exists(TESTS_DIR . 'controllers/' . $file)) {
						add_test('controllers', $file, $test);
					}
				} elseif (false !== strpos($file, '_model')) {
					if (file_exists(TESTS_DIR . 'models/' . $file)) {
						add_test('models', $file, $test);
					}
				} elseif (false !== strpos($file, '_view')) {
					if (file_exists(TESTS_DIR . 'views/' . $file)) {
						add_test('views', $file, $test);
					}
				} elseif (false !== strpos($file, '_library')) {
					if (file_exists(TESTS_DIR . 'libraries/' . $file)) {
						add_test('libraries', $file, $test);
					}
				} elseif (false !== strpos($file, '_bug')) {
					if (file_exists(TESTS_DIR . 'bugs/' . $file)) {
						add_test('bugs', $file, $test);
					}
				} elseif (false !== strpos($file, '_helper')) {
					
					if (file_exists(TESTS_DIR . 'helpers/' . $file)) {
						add_test('helpers', $file, $test);
					}
				}
			}
		}
	}
}
elseif (isset($_POST['test'])) //single test
{ 
	$file = $_POST['test'];
	
	//autorun will load failed test if no tests are present to run
	require_once SIMPLETEST .'autorun.php';
	require_once SIMPLETEST .'web_tester.php';
	require_once SIMPLETEST . 'mock_objects.php';
	require_once SIMPLETEST . 'extensions/my_reporter.php';
	$test = new TestSuite();
	$test->_label = 'iClassEngine Test Suite';
	
	if (false !== strpos($file, 'addons')) 
	{
		$file = str_replace('addons/', '', $file);
		if (file_exists(EXTPATH . $file)) 
		{
			$run_tests = TRUE;
			$test->addTestFile(EXTPATH . $file);
		}
	} 
	else
	{
		if (file_exists(TESTS_DIR . $file)) 
		{
			$run_tests = TRUE;
			$test->addTestFile(TESTS_DIR . $file);
		}
	}
}

$form_url =  'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

//display the form
include(TESTS_DIR . 'test_gui.php');