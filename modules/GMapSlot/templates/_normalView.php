<?php use_helper('JavascriptBase') ?>

<?php include_partial('a/simpleEditWithVariants', array('pageid' => $page->id, 'name' => $name, 'permid' => $permid, 'slot' => $slot, 'page' => $page)) ?>

<?php if ($gmap->isValid()): ?>
  <?php if ($gmap->isDynamic()): ?>
    <div id="<?php echo $gmap->getId() ?>" style="width:<?php echo $gmap->getWidth() ?>px; height:<?php echo $gmap->getHeight() ?>px;">
    </div>
    <?php echo javascript_tag($sf_data->getRaw('gmap')->displayDynamic()) ?>
  <?php else: ?>
    <div id=<?php echo $gmap->getId() ?>>
      <?php echo image_tag($sf_data->getRaw('gmap')->displayStatic()) ?>
    </div>
  <?php endif ?>
<?php else: ?>
  <p class="GMapSelect"><?php echo 'Click Edit to configure Google Map.' ?></p>
<?php endif ?>
