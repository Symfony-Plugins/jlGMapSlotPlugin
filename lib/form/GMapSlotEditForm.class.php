<?php    
class GMapSlotEditForm extends BaseForm
{
  // Ensures unique IDs throughout the page
  protected $id;
  public function __construct($id, $defaults = array(), $options = array(), $CSRFSecret = null)
  {
    $this->id = $id;
    parent::__construct($defaults, $options, $CSRFSecret);
  }
  public function configure()
  {
    $this->setWidgets(array('Name' => new sfWidgetFormInput(),
				    'Address' => new sfWidgetFormTextarea(),
				    'Map Type' => new sfWidgetFormSelect(array('choices' => dmArray::valueToKey($this->getMapTypeIds()))),
				    'Zoom' => new sfWidgetFormSelect(array('choices' => dmArray::valueToKey($this->getZooms()))),
				    'Show Marker' => new sfWidgetFormInputCheckbox(),
				    'Dynamic Map' => new sfWidgetFormInputCheckbox(),
				    'Navigation Control' => new sfWidgetFormInputCheckbox(),
				    'Map Type Control' => new sfWidgetFormInputCheckbox(),
				    'Scale Control' => new sfWidgetFormInputCheckbox(),
				    'StreetView Control' => new sfWidgetFormInputCheckbox()));
    $this->setValidators(array('Name' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
					 'Address' => new sfValidatorAnd(array(new sfValidatorString(array('required' => true, 'max_length' => 100)),
                                                                     new sfValidatorGMapGeo())),
					 'Map Type' => new sfValidatorChoice(array('choices' => $this->getMapTypeIds())),
					 'Zoom' => new sfValidatorChoice(array('choices' => $this->getZooms())),
					 'Show Marker' => new sfValidatorBoolean(),
					 'Dynamic Map' => new sfValidatorBoolean(),
					 'Navigation Control' => new sfValidatorBoolean(),
					 'Map Type Control' => new sfValidatorBoolean(),
					 'Scale Control' => new sfValidatorBoolean(),
					 'StreetView Control' => new sfValidatorBoolean()));
    
    // Ensures unique IDs throughout the page. Hyphen between slot and form to please our CSS
    $this->widgetSchema->setNameFormat('slot-form-' . $this->id . '[%s]');
    
    // You don't have to use our form formatter, but it makes things nice
    $this->widgetSchema->setFormFormatterName('aAdmin');
  }
  protected function getMapTypeIds()
  {
    //Available map types
    return array('roadmap', 'satellite', 'hybrid', 'terrain');
  }
  protected function getZooms()
  {
    //Available zoom levels
    return range(2, 20);
  }
}
