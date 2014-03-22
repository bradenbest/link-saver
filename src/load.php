<?php
session_start();
?>
<script>
storage = <?=$_SESSION['data']?>;
localStorage.removeItem('Link Saver');
localStorage['Link Saver'] = JSON.stringify(storage);
location.href = './';
</script>