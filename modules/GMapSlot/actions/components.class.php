<?php
class GMapSlotComponents extends BaseaSlotComponents
{
  public function executeEditView()
  {
    // Must be at the start of both view components
    $this->setup();
    
    // Careful, don't clobber a form object provided to us with validation errors
    // from an earlier pass
    if (!isset($this->form))
    {
      $this->form = new GMapSlotEditForm($this->id, $this->slot->getArrayValue());
    }
  }
  public function executeNormalView()
  {
    $this->setup();

    $width = $this->getOption('width', 500);
    $height = $this->getOption('height', 400);
    $options = array_merge($this->slot->getArrayValue(), array('id'=>'gmap-'.$this->id, 'Width'=>$width, 'Height'=>$height));

    $this->gmap = new jlGMap($options);
  }
}
