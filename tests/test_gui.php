<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>CodeIgniter &rsaquo; Unit Testing &rsaquo; Index</title>
<link rel="stylesheet" type="text/css" href="tests/unit_test.css" charset="utf-8">

</head>
<body>
	<div id="header">
		<h2>CodeIgniter &rsaquo; Unit Testing &rsaquo; Index</h2>
	</div>
	
	<div id="nav">
		<?php echo form_open($form_url); ?>
			<input type="hidden" name="all" value="1" />
			<input type="submit" value="All" />
		<?php echo form_close(); ?>
		<?php echo form_open($form_url); ?>
			<input type="hidden" name="libraries" value="1" />
			<input type="submit" value="Libraries" />
		<?php echo form_close(); ?>
		<?php echo form_open($form_url); ?>
			<input type="hidden" name="controllers" value="1" />
			<input type="submit" value="Controllers" />
		<?php echo form_close(); ?>
		<?php echo form_open($form_url); ?>
			<input type="hidden" name="models" value="1" />
			<input type="submit" value="Models" />
		<?php echo form_close(); ?>
		<?php echo form_open($form_url); ?>
			<input type="hidden" name="helpers" value="1" />
			<input type="submit" value="Helpers" />
		<?php echo form_close(); ?>
		<?php echo form_open($form_url); ?>
			<input type="hidden" name="views" value="1" />
			<input type="submit" value="Views" />
		<?php echo form_close(); ?>
		<?php echo form_open($form_url); ?>
			<input type="hidden" name="bugs" value="1" />
			<input type="submit" value="Bugs" />
		<?php echo form_close(); ?>
		
		<?php
		// RT Wolf's addition: HTML select the test you just ran in drop down list in case you want to rerun it.
		// www.mind-manual.com
		if (isset($_POST['test']) && trim($_POST['test']) != "") {
			$testName = explode('/', $_POST['test']);
			$testName = $testName[1];
		}
		else {
			$testName = "";
		}
		?>
		
		<?php echo form_open($form_url); ?>
			<select name="test">
				<optgroup label="Libraries">
					<?php foreach ($libraries as $value) { ?>
						<option value="libraries/<?php echo $value ?>" <?php if ($value == $testName) { echo 'selected="selected"'; } ?>><?php echo $value; ?></option>
					<?php } ?>
				</optgroup>
				<optgroup label="Controllers">
					<?php foreach ($controllers as $value) { ?>
						<option value="controllers/<?php echo $value ?>" <?php if ($value == $testName) { echo 'selected="selected"'; } ?>><?php echo $value; ?></option>
					<?php } ?>
				</optgroup>
				<optgroup label="Models">
					<?php foreach ($models as $value) { ?>
						<option value="models/<?php echo $value ?>" <?php if ($value == $testName) { echo 'selected="selected"'; } ?>><?php echo $value; ?></option>
					<?php } ?>
				</optgroup>
				<optgroup label="Helpers">
					<?php foreach ($helpers as $value) { ?>
						<option value="helpers/<?php echo $value ?>" <?php if ($value == $testName) { echo 'selected="selected"'; } ?>><?php echo $value; ?></option>
					<?php } ?>
				</optgroup>
				<optgroup label="Views">
					<?php foreach ($views as $value) { ?>
						<option value="views/<?php echo $value ?>" <?php if ($value == $testName) { echo 'selected="selected"'; } ?>><?php echo $value; ?></option>
					<?php } ?>
				</optgroup>
				<optgroup label="Bugs">
					<?php foreach ($bugs as $value) { ?>
						<option value="bugs/<?php echo $value ?>" <?php if ($value == $testName) { echo 'selected="selected"'; } ?>><?php echo $value; ?></option>
					<?php } ?>
				</optgroup>
			</select>
			<input type="submit" value="Run" />
		<?php echo form_close(); ?>
	</div>
		
		
	<div id="report">
		<?php
		    ob_start();
		    $test_suite->run(new MyReporter());
		    ob_end_flush();
		?>
	</div>
		
</body>
</html>
