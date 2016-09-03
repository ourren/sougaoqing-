<?php
$hash = $_GET['hash'];
$name = $_GET['name'];
$url = "http://torcache.net/torrent/".strtoupper($hash).".torrent";
?>
<iframe src=<?php echo($url);?> width="100%" height="100%" border=0 frameborder=0  style="position: absolute; top: -450px; "></iframe>