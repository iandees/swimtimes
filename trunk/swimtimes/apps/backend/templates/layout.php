<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php echo include_http_metas() ?>
<?php echo include_metas() ?>

<?php echo include_title() ?>

<link rel="shortcut icon" href="/favicon.ico" />

<style>
#menu li {
  display: inline;
  list-style-display: none;
}
</style>

</head>
<body>

<ul id="menu">
  <li><?php echo link_to('swimmer', 'swimmer/list') ?></li>
  <li><?php echo link_to('meet', 'meet/list') ?></li>
  <li><?php echo link_to('pool', 'pool/list') ?></li>
  <li><?php echo link_to('time', 'time/list') ?></li>
</ul>

<?php echo $sf_data->getRaw('sf_content') ?>

</body>
</html>
