<table width="100%" border="0">
<?php 
$nSwimmersToShow = 3;
// Get the meet's events
$events = $meet->getEvents();
$swimmers = $meet->getSwimmers();
// For each of the meet's events,
foreach ($events as $event): ?>
<tr >
  <td style="background:#eeccaa;padding:2px;margin:2px;" colspan="4"><?php echo $event->getName(); ?></td>
</tr>
  <?php 
  $nSplits = $event->getNumSplits();
  for ($nSwimmer = 0; $nSwimmer < $nSwimmersToShow; $nSwimmer++) :
  ?>
    <tr><td width="70%" style="background:#eeeeee;padding:2px;margin:2px;">Group <?php echo $nSwimmer; ?></td>
    <td width="10%" style="background:#eeeeee;padding:2px;margin:2px;"><small><em>Time</em></small></td>
    <td width="10%" style="background:#eeeeee;padding:2px;margin:2px;"><small><em>Place</em></small></td>
    <td width="10%" style="background:#eeeeee;padding:2px;margin:2px;"><small><em>Points</em></small</td></tr>
  <?php for ($nSplit = 0; $nSplit < $nSplits; $nSplit++) :
  $fId = $event->getId().'.'.$nSwimmer.'.'.$nSplit;
  ?>
      <tr><td style="padding:2px;margin:2px;">
  <?php echo select_tag($fId.'.swimmer', objects_for_select($swimmers, 'getId', 'getName', 1), 'style=width:250px'); ?>
  </td><td style="padding:2px;margin:2px;">
  <?php echo input_tag($fId.'.time', '00:00.00', 'style=width:100px'); ?>
  </td><td style="padding:2px;margin:2px;">
  <?php echo input_tag($fId.'.place', '0', 'style=width:15px'); ?>
  </td><td style="padding:2px;margin:2px;">
  <?php echo input_tag($fId.'.points', '0', 'style=width:15px'); ?>
  <?php endfor; ?>
    </td></tr>
  <?php endfor; ?>
</tr>
<?php endforeach; ?>
</table>
