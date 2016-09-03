<?php

$keyword = trim($_GET['keyword']);


if(empty($keyword)){
    $keyword = "合集";
}

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


$page = isset($_GET['page'])?intval($_GET['page']):1;
if($page<=1){$page=1;}
$limit = 20;
$offset = $limit * ($page-1);
$stmtc = $conn->prepare("select count(*) from movie_hash where name like :keyword"); 
$stmtc->bindValue(':keyword', "%$keyword%"); 
$stmtc->execute();

//$stmtc = $conn->query($query_count);
$fetch_count = $stmtc->fetch();
$total = $fetch_count[0];

/*
$sc = new SphinxClient();
$sc->setServer('localhost', 9312);
$sc->SetArrayResult ( true );
$sc->SetLimits(0,$offset,1000);
$sc->SetMaxQueryTime(10);
$sc->AddQuery($keyword, 'main');
//$sc->RunQuries();
$res = $sc->query($keyword, 'main');
//print_r($res);
$ids    = array_keys($res['matches']); // 获取主键
$ids = join(',', $ids);
*/
$stmt = $conn->prepare("SELECT * FROM movie_hash WHERE `name` like :keyword limit $offset,$limit"); 
$stmt->bindValue(':keyword', "%$keyword%"); 
$stmt->execute();

$pagenum=ceil($total/$limit);

$distitle = htmlspecialchars($keyword);
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content="高清电影,最新电影,免费电影,BT下载,迅雷下载">
<meta name="description" content="<?php echo($distitle);?> 搜高清以提供最新以及历史的所有免费高清电影种子。提供高质量视频种子">

    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title><?php echo($distitle );?> - 搜高清</title>
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
                <li ><a href="javascript:void(0);" onclick="AddFavorite('搜高清','http://www.maopian.link')">加入收藏</a></li>
                <li><a href="javascript:void(0;" onclick="SetHome(this,'http://www.maopian.link');">设为首页</a></li>
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
</nav>
</form>


    
<div class="container">

    <div class="div-ads" style="margin-top: -10px; ">
    </div>


<h4>共找到 <?php echo($total);?> 条关于 <font color="red"><?php echo($distitle);?></font> 的结果</h4>
<p>
    </p>
<table class="table">
<?php
while($row = $stmt -> fetch()){
?>	

    <tr><td class="x-item">
        <div>
        <a title="" class="title" href="download.php?hash=<?php echo($row['hash']);?>&name=<?php echo($row['name']);?>" ><?php echo(str_replace($distitle,"<font color=red>$distitle</font>",$row['name']));?> </a></div>
        <div class="files">
            <ul>
                
                    
                        <li><?php echo(str_replace($distitle,"<font color=red>$distitle</font>",$row['name']));?>  文件大小：<?php echo(format_bytes($row['filesize']));?>  </li>
                
            </ul>
        </div>
        <div class="tail">
             <a class="title" href="download.php?hash=<?php echo($row['hash']);?>&name=<?php echo($row['name']);?>"><span class="glyphicon glyphicon-magnet"></span> 下载种子</a>
            &nbsp; &nbsp;
          <a class="title" href="magnet:?xt=urn:btih:<?php echo($row['hash']);?>&amp;dn=<?php echo($row['name']);?>"><span class="glyphicon glyphicon-magnet"></span> 迅雷下载</a>
            &nbsp; &nbsp;
            
        </div>
    </td></tr>
    <?php }?>
</table>
<ul class="pagination">
    <?php
        if ($page != 1) { //页数不等于1
            $disable = "";
        }else{$disable = "disabled";}    
        ?>
    <li class="<?php echo($disable);?>"><a href="./?p=<?php echo($i);?>">&larr;  Previous</a></li>  
    <?php 
    for ($i=1;$i<=$pagenum;$i++) {  //循环显示出页面
        if($i==$page){
            $disable = "active";
            $distag = "<span class=\"sr-only\">(current)</span>";
        }else
        {
           $disable = "";
           $distag = "";
        }
    ?>
        <li class="<?php echo($disable);?>"><a href="./?p=<?php echo($i);?>"> <?php echo($i); echo($distag);?> </a></li>

    <?php
        }
        if ($page<$pagenum) { //
            $disable = "";
        }else{$disable = "disabled";}    
    ?>
    <li><a href="./?p=<?php echo($i);?>" $disable> Next &rarr; </a></li>
</ul>


</div>

<nav class="navbar navbar-default nav-foot" role="navigation">
    <div class="container">
        <div class="">
            <h5>关于搜高清</h5>
            <p>搜高清以提供最新以及历史的所有免费高清电影种子。提供高质量视频种子</p>         
        </div>
        <div class="navbar-header">
            <div class="copyright">
            copyright &copy;  2015 www.maopian.link
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
        var url = '/search/' + encodeURIComponent(kw) + '/';
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


