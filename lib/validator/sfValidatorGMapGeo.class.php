<?php

class sfValidatorGMapGeo extends sfValidatorBase
{
  /**
   * Configures the current validator.
   * This method allows each validator to add options and error messages during validator creation.
   * Available error codes:
   *  * invalid
   *
   * @param array $options   An array of options
   * @param array $messages  An array of error messages
   * @see sfValidatorBase
   */
  protected function configure($options = array(), $messages = array())
  {
    $this->setMessage('invalid', 'Please enter a valid address.');
  }
 
  /**
   * Cleans the input value.
   *
   * @param  mixed $value  The input value
   * @return mixed The cleaned value
   * @throws sfValidatorError
   */
  protected function doClean($value)
  {
    //Call Google Map Geo API to check if address is valid
    $geo = GMapGeocode::isValid($value);
    
    if (!$geo)
    {
      throw new sfValidatorError($this, 'invalid');
    }
 
    return $geo;  //clean address entered with Google Map formatted address
  }
}