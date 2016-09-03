<?php
$hash = trim($_GET['hash']);


function format_bytes($size) { 
    $units = array(' B', ' KB', ' MB', ' GB', ' TB'); 
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024; 
        return round($size, 2).$units[$i]; 
}


$dbhost= 'localhost';  
$user= 'root';  
$passwd = 'MysqlPass!2';
$dbname = 'dht';
$conn = new PDO("mysql:dbname=$dbname;host=$dbhost",$user,$passwd);

$conn->exec("set names utf8");

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
<meta name="keywords" content="高清电影,最新电影,免费电影,BT下载,迅雷下载">
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
                <li class="active"><a href="/" >首页</a></li>
                <li ><a href="/search/演唱会.html" title="演唱会">演唱会</a></li>
                <li ><a href="/search/喜剧.html" title="喜剧">喜剧</a></li>
                <li ><a href="/search/字幕组.html" title="字幕组">字幕组</a></li>
                <li ><a href="/search/HDTV.html" title="美剧">美剧</a></li>
                <li ><a href="/link.php" title="友情链接">链接</a></li>
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
            <td><a class="title" href="/download.php?hash=<?php echo($row['hash']);?>&name=<?php echo($row['name']);?>"><span class="glyphicon glyphicon-magnet"></span>下载种子</a> &nbsp; &nbsp; <a class="title" href="magnet:?xt=urn:btih:<?php echo($row['hash']);?>&amp;dn=<?php echo($row['name']);?>"><span class="glyphicon glyphicon-magnet"></span> 迅雷下载</a></td>
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
</div>

<nav class="navbar navbar-default nav-foot" role="navigation">
    <div class="container">
        <div class="">
            <h5>关于搜高清</h5>
            <p>搜高清以提供最新以及历史的所有免费高清电影种子。提供高质量视频种子</p> 
            <span class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_mshare" data-cmd="mshare" title="分享到一键分享"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a></span>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"找电影、视频就到搜高清[www.sougaoqing.com]","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>        
        </div>
        <div class="navbar-header">
            <div class="copyright">
            copyright &copy;  2015 www.sougaoqing.com 备用网址 <a href="http://www.maopian.link">www.maopian.link</a>
            </div>
        </div>
    </div>
</nav>
<script src="//ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.0.min.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/bootstrap/3.1.1/bootstrap.min.js"></script>
<script src="../static/js/jquery-1.11.3.min" ></script>

<script src="../static/js/bootstrap-typeahead.min.js" ></script>
<script>
    $('.x-sform').submit(function(e){
        e.preventDefault();
        var kw = $('.x-kw').val();
        if(!kw){
            $('.x-kw').focus();
            return false;
        }
        var url = '/search/' + encodeURIComponent(kw) + '.html';
        window.location = url;
        return false;
    });

    $(function(){
        $('.x-kw').focus();
    });

</script>
<div style="display:none;">
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1255999001'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1255999001' type='text/javascript'%3E%3C/script%3E"));</script></div>
  </body>
</html>