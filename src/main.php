<style>
<?=file_get_contents('Client/main.css')?>
<?=file_get_contents('Client/cmenu.css')?>
<?=file_get_contents('Client/form.css')?>
</style>
<script>
<?=file_get_contents('Client/popup.js')?>
</script>
<ul class="cmenu"><script><?=file_get_contents('Client/cmenu.js');?></script></ul>
<div class="frame"></div>
<?=file_get_contents('Client/menu')?>
<?=file_get_contents('Client/links')?>
<?=file_get_contents('Client/footer')?>
