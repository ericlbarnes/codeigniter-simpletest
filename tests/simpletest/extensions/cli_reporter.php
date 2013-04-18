<?php
/**
 *  Implements color on Simpletest cli mode
 *  @autor Maiquel Leonel
 *  @email skywishmtfk <at> gmail <dot> com
 */
class CliReporter extends TextReporter {
 
  public $esc_start;
  /**
   * Set font color 
   * @options 
   *  Regular colors:         
   *    Red   = '0;31m' 
   *    Green = '0;32m'
   *  bold:
   *    Red   = '1;31m'
   *    Green = '1;32m'
   *  background:
   *    Red   = '41m' 
   *    Green = '42m'
   *  high intensivy colors:
   *    Red   = '0;91m'
   *    Green = '0;92m'
   *  Bold High Intensity:
   *    Red   = '1;91m'
   *    Green = '1;92m'
   *  High Intensity backgrounds:
   *    Red   ='0;101m'
   *    Green ='0;102m'
   */
  public $red_color   = '1;91m';
  public $green_color = '1;92m';
  public $default     = '0;0m';

  function __construct() {
     parent::__construct();
     $this->esc_start = chr(27).'[';
  }

  function resetColors() {
     print $this->esc_start . $this->default . "\n";
  }

  function paintFooter($test_name) {
     if($this->getFailCount() + $this->getExceptionCount() == 0) {
        print $this->esc_start . $this->green_color;
        print "OK\n";
     }else{
        print $this->esc_start . $this->red_color;
        print "FAILURES!!!\n";
     }
    
     print "Test cases run: " . $this->getTestCaseProgress() .
        "/" . $this->getTestCaseCount() .
        ", Passes: " . $this->getPassCount() .
        ", Failures: " . $this->getFailCount() .
        ", Exceptions: " . $this->getExceptionCount();

      $this->resetColors();
  }
}
