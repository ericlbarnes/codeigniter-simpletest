# Phing Integration

Credits:
Frank Hmeidan - <http://twitter.com/frankhmeidan>

# Installation

Place the TestRunnerTask.php file in the following location: "phing/tasks/ext/TestRunnerTask.php"

Next create this in your Phing build file:

	<target name="unit_test">
		<taskdef classname="phing.tasks.ext.TestRunnerTask" name="unit-test" />
		<unit-test url="http://url_to_app/unit_test.php?all" />
	</target>