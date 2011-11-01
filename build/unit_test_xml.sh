#!/bin/bash

php ../unit_test_xml.php > results.xml
xsltproc simpletest_to_junit.xsl results.xml > results-1.xml
