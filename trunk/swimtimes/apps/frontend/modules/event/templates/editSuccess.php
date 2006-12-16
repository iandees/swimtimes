<?php
// auto-generated by sfPropelCrud
// date: 2006/11/29 13:34:22
?>
<?php use_helper('Object') ?>

<?php echo form_tag('event/update') ?>

<?php echo object_input_hidden_tag($event, 'getId') ?>

<table>
<tbody>
<tr>
  <th>Name:</th>
  <td><?php echo object_input_tag($event, 'getName', array (
  'size' => 20,
)) ?></td>
</tr>
<tr>
  <th>Distance:</th>
  <td><?php echo object_input_tag($event, 'getDistance', array (
  'size' => 7,
)) ?></td>
</tr>
</tbody>
</table>
<hr />
<?php echo submit_tag('save') ?>
<?php if ($event->getId()): ?>
  &nbsp;<?php echo link_to('delete', 'event/delete?id='.$event->getId(), 'post=true&confirm=Are you sure?') ?>
  &nbsp;<?php echo link_to('cancel', 'event/show?id='.$event->getId()) ?>
<?php else: ?>
  &nbsp;<?php echo link_to('cancel', 'event/list') ?>
<?php endif; ?>
</form>
