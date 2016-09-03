<?php
$hash = $_GET['hash'];
$name = $_GET['name'];
$name = htmlspecialchars($name);
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="keywords" content="搜高清,高清电影，最新电影，免费电影">
<meta name="description" content="搜高清以提供最新以及历史的所有免费高清电影种子。提供高质量视频种子">

    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title><?php echo($name);?>- 搜高清视频,最新、最快、最全、最清晰的视频搜索网站</title>

    <!-- Bootstrap -->
    <link href="static/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="static/css/sgq.css" />


    <link rel="chrome-webstore-item" >
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
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
    <div class="container">
        <div class="navbar-header">
            <a title="最全的高清免费电影" class="navbar-brand" href="/" >搜高清</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php include "nav.php";?>
                <li ><a href="javascript:void(0);" onclick="AddFavorite('搜高清','http://maopian.link')">加入收藏</a></li>
                <li><a href="javascript:void(0;" onclick="SetHome(this,'http://maopian.link');">设为首页</a></li>
                
            </ul> 
            <div class="navbar-form x-searchbar navbar-left">
                <div class="input-group">
                    <input type="text" autocomplete="off" class="form-control x-kw" name="keyword" value="<?php echo($distitle );?>">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div><!-- /input-group -->
            </div>         
        </div>
    </div>
</div>
</div>
</form>

<form class="x-sform">
<div class="container">
    <div class="div-search-box col-lg-12">
        <div>
          
          <?php
$url = "http://torcache.net/torrent/".strtoupper($hash).".torrent";
?>
<h4 style="color:red;">种子文件 <?php echo($name);?> 马上就要开始下载，请您耐心等待几秒，如果几秒钟后没有出现下载，则请刷新下该页面。如果仍然不能下载，请选择使用迅雷下载。谢谢！</h4>
<p>如果您没有安装迅雷，可以<a href="http://down.sandai.net/thunder7/Thunder_dl_7.9.40.5006.exe">点击此处下载</a></p>
<p>如果想要播放影片，推荐您使用迅雷看看播放器（迅雷影音）进行播放，迅雷看看播放器下载地址可以<a href="http://xmp.down.sandai.net/kankan/XMPSetup_5.1.25.4252-dl.exe">点击此处下载</a></p>
<iframe src=<?php echo($url);?> width="100%" height="100%" border=0 frameborder=0  style="position: absolute; top: -450px; "></iframe>
        </div>
        
    </div>
</div>
</form>

<?php include "footer.php";?>
  </body>
</html>

