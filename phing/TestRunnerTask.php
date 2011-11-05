<?php
require_once "phing/Task.php";

/**
 * Runs the unit tests
 *
 * @package phing.tasks.ext
 */
class TestRunnerTask extends Task {

	protected $url = NULL;

	public function init() { }

	/**
	 * Invoking this task will cause the unit tests to be executed.
	 */
	public function main()
	{
		if (empty($this->url) || filter_var($this->url, FILTER_VALIDATE_URL) === FALSE) {
			throw new BuildException('Invalid URL: You must specify a valid URL.');
		}

		echo "Running unit tests...\n";

		$testResults = $this->doPOST($this->url, 'all', '1');

		if ($testResults == NULL || $testResults == '' || !isset($testResults))
		{
			throw new BuildException('No results page returned from POST request on $url');
		}

		/* Check if there is the string 'FAILED' anywhere in the output - if not, we've succeeded. */
		if (strpos($testResults, 'FAILED') != FALSE)
		{
			throw new BuildException("There were test case failures - build terminated.");
		}
		else
		{
			echo "\n ----- all tested PASSED ----- \n";
		}

		return;
	}

	public function setURL($url)
	{
		$this->url = $url;
	}

	function doPOST($url, $key, $value)
	{
		$context = stream_context_create(array(
			'http' => array(
			'method'  => 'POST',
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'content' => http_build_query(array($key => $value)),
		)));

		$ret = file_get_contents($url, false, $context);

		return $ret;
	}
}
