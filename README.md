# CodeIgniter with SimpleTest

Updates:

April 25, 2011 - The CodeIgniter core is now being converted to using phpUnit and as such I can't see myself updating this in the future. It will be left here
for anyone to use and I will gladly pull in any changes but no new features will be added by me directly. 

## Overview

This has been adopted from:
[jamieonsoftware](http://jamieonsoftware.com/blog/entry/setting-up-the-perfect-codeigniter-tdd-environment "CodeIgniter TDD")

With help from:
John S. - <http://github.com/juven14>

Design From:
Istvan Pusztai - <http://codeigniter.com/forums/viewthread/129253/P10/#697201>

## Installation

The unit_test.php file should go in your CodeIgniter root. The same place as index.php

You should open that file and alter your paths at the top.

The tests directory can be moved any where you want but they are setup to be in the root as well.

All test files need to be named `test_name_folder.php`. For example:

	test_whatever_bug.php
	test_string_helper.php
	test_auth_library.php
	test_core_model.php


I have included a full download of simpletest and the only customization I have made is to the `simpletest/extensions/my_reporter.php`.

### NOTES:

Inside the "tests" directory I include two example test files. The test_users_model.php will not run on its own because your application would not include the same users model as the example file. It is supplied just as a guide.

This version is now compatible with PHP 5.3

## Credits

  * Joe Tsui - <http://www.joetsuihk.com/>
  * Jamie Rumbelow - [jamieonsoftware](http://jamieonsoftware.com/blog/entry/setting-up-the-perfect-codeigniter-tdd-environment "CodeIgniter TDD")
  * RT Wolf - <http://www.mind-manual.com>
  * John S. - <http://github.com/juven14>
  * Istvan Pusztai - <http://codeigniter.com/forums/viewthread/129253/P10/#697201>
  * Oliver Smith <http://github.com/chemicaloliver>
