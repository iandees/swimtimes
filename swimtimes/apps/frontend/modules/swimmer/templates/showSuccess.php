<?php
// auto-generated by sfPropelCrud
// date: 2006/11/29 13:15:22
?>
<table>
<tbody>
<tr>
<th>Id: </th>
<td><?php echo $swimmer->getId() ?></td>
</tr>
<tr>
<th>Name: </th>
<td><?php echo $swimmer->getName() ?></td>
</tr>
<tr>
<th>Year: </th>
<td><?php echo $swimmer->getYear() ?></td>
</tr>
<tr>
<th>Team: </th>
<td><?php echo $swimmer->getTeam() ?></td>
</tr>
</tbody>
</table>
<hr />
<?php echo link_to('edit', 'swimmer/edit?id='.$swimmer->getId()) ?>
&nbsp;<?php echo link_to('list', 'swimmer/list') ?>
