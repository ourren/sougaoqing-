<?php
$hash = trim($_GET['hash']);


function format_bytes($size) { 
    $units = array(' B', ' KB', ' MB', ' GB', ' TB'); 
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024; 
        return round($size, 2).$units[$i]; 
}

include "config.php"; 

$stmt = $conn->prepare("SELECT * FROM movie_hash WHERE `hash` = :hash"); 
$stmt->bindValue(':hash', $hash); 
$stmt->execute();

$row = $stmt -> fetch()
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content="高清电影,最新电影,免费电影,BT下载,迅雷下载,种子下载">
<meta name="description" content="<?php echo($row['name']);?>下载,种子下载，迅雷下载地址">

    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title><?php echo($row['name']);?> - 搜高清 最新、最快、最全、最清晰的视频搜索网站</title>
    <!-- Bootstrap -->
    <link href="../static/css/bootstrap.min.css"  rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../static/css/sgq.css" />
    <script type="text/javascript">
    


    function SetHome(obj,url){
      try{
        obj.style.behavior='url(#default#homepage)';
        obj.setHomePage(url);
      }catch(e){
        if(window.netscape){
         try{
           netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
         }catch(e){
           alert("抱歉，此操作被浏览器拒绝！\n\n请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]设置为'true'");
         }
        }else{
        alert("抱歉，您所使用的浏览器无法完成此操作。\n\n您需要手动将【"+url+"】设置为首页。");
        }
     }
	}
      
    function AddFavorite(title, url) {
     try {
       window.external.addFavorite(url, title);
     }
    catch (e) {
       try {
        window.sidebar.addPanel(title, url, "");
      }
       catch (e) {
         alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请进入新网站后使用Ctrl+D进行添加");
       }
     }
	}
</script>

  </head>
  <body>
    
<form class="x-sform" method="get" action="/">
<nav class="navbar navbar-inverse " role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a title="最全的高清免费电影" alt="sougaoqing" class="navbar-brand" href="/" >搜高清</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php include "nav.php";?>
                <li ><a href="javascript:void(0);" onClick="AddFavorite('搜高清','http://www.maopian.link')">加入收藏</a></li>
                <li><a href="javascript:void(0;" onClick="SetHome(this,'http://www.maopian.link');">设为首页</a></li>
            </ul> 
            <div class="navbar-form x-searchbar navbar-left">
                <div class="input-group">
                    <input type="text" autocomplete="off" class="form-control x-kw" name="keyword" value="">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div><!-- /input-group -->
            </div>
        </div>
    </div>
</nav>
</form>

  
<div class="container">
    
      <h4><?php echo($row['name']);?></h4>
      <table>
        <tbody>
          <tr>
            <th class="col-lg-2">创建时间</th>
            <td><?php echo($row['createtime']);?></td>
          </tr>
          <tr>
            <th class="col-lg-2">更新时间</th>
            <td><?php echo($row['updatetime']);?></td>
          </tr>
          <tr>
            <th class="col-lg-2">文件大小</th>
            <td><?php echo(format_bytes($row['filesize']));?></td>
          </tr>
          <tr>
            
          </tr>
          <tr>
            <th class="col-lg-2">请求数</th>
            <td><?php echo($row['reqtimes']);?></td>
          </tr>
         
          <tr>
            <th class="col-lg-2">下载地址</th>
            <td><a class="title" href="http://torcache.net/torrent/<?php echo(strtoupper($hash));?>.torrent"><span class="glyphicon glyphicon-magnet"></span>下载种子</a> &nbsp; &nbsp; <a class="title" href="magnet:?xt=urn:btih:<?php echo($row['hash']);?>&amp;dn=<?php echo($row['name']);?>"><span class="glyphicon glyphicon-magnet"></span> 迅雷下载</a></td>
          </tr>
        </tbody>
      </table>

      <h4>内容</h4>
      <div class="files">
        <ul>
          <li><?php echo($row['name']);?>  <?php echo(format_bytes($row['filesize']));?></li>
        </ul>
      </div>
      <h4>下载资源</h4>
      <div> 如果您想下载 <?php echo($row['name']);?>BT种子文件或数据，请使用迅雷、QQ旋风、uTorrent等BT工具下载。<br>
        <a rel="nofollow" href="http://www.haosou.com/s?q=<?php echo($row['name']);?>&src=sougaoqing&ie=utf-8" alt="<?php echo($row['name']);?>" target="_blank">点击这里搜索《<?php echo($row['name']);?>》</a> </div>

         <div style="margin-top:20px;">
        <p>下载后的种子文件，可以使用迅雷进行下载，如果您没有安装迅雷，可以<a href="http://down.sandai.net/thunder7/Thunder_dl_7.9.40.5006.exe">点击此处下载</a></p>
<p>如果想要播放影片，推荐您使用迅雷看看播放器（迅雷影音）进行播放，迅雷看看播放器下载地址可以<a href="http://xmp.down.sandai.net/kankan/XMPSetup_5.1.25.4252-dl.exe">点击此处下载</a></p>
      </div>
</div>


<?php include "footer.php";?>
  </body>
</html>