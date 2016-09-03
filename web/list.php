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


include "config.php";

$page = isset($_GET['page'])?intval($_GET['page']):1;
if($page<=1){$page=1;}
$limit = 20;
$offset = $limit * ($page-1);

include("sphinxapi.php");

$sphinx= new SphinxClient();
$sphinx->SetServer("localhost",9312);
$sphinx->SetMatchMode(SPH_MATCH_EXTENDED2);
$sphinx->SetLimits($offset,$limit,10000);//传递当前页面所需的数据条数的参数
$sphinx->SetArrayResult (true);
$sphinx->SetConnectTimeout (1);
$sphinx->SetWeights(array(100,1));
$result=$sphinx->query("$keyword","*");
if($result['total']==0){
    $total = 0;
}else{
    $total = $result['total'];
}

foreach($result['matches'] as $v) {
    $arrID[] = $v['id'];
}
$sids = join(',', $arrID);

$stmt = $conn->query("SELECT * FROM movie_hash WHERE id in(".$sids.")");  

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
<meta name="description" content="<?php echo($distitle);?> 种子下载，搜高清以提供最新以及历史的所有免费高清电影种子。提供高质量视频种子，没有广告">

    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title><?php echo($distitle );?> - 搜高清 最新、最快、最全、最清晰的视频搜索网站</title>
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


<h4>共找到 <?php echo($total);?> 条关于 <font color="red"><?php echo($distitle);?></font> 的结果 </h4> 
<table class="table">
<?php
if($stmt){
while($row = $stmt -> fetch()){
?>	

    <tr><td class="x-item">
        <div>
        <a title="<?php echo($row['name']);?>" class="title" href="http://www.sougaoqing.com/detail/<?php echo($row['hash']);?>.html" target="_blank"><?php echo(str_replace($distitle,"<font color=red>$distitle</font>",$row['name']));?> </a></div>
        <div class="files">
            <ul>
                
                    
                        <li><?php echo(str_replace($distitle,"<font color=red>$distitle</font>",$row['name']));?>  文件大小：<?php echo(format_bytes($row['filesize']));?>  </li>
                
            </ul>
        </div>
        <div class="tail">
             <a class="title" href="http://torcache.net/torrent/<?php echo(strtoupper($row['hash']));?>.torrent" target="_blacnk"title="<?php echo($row['name']);?>"><span class="glyphicon glyphicon-magnet"></span> 下载种子</a>
            &nbsp; &nbsp;
          <a class="title" href="magnet:?xt=urn:btih:<?php echo($row['hash']);?>&amp;dn=<?php echo($row['name']);?>"><span class="glyphicon glyphicon-magnet"></span> 迅雷下载</a>
            &nbsp; &nbsp;
            
        </div>
    </td></tr>
    <?php }
        }
?>
</table>
<ul class="pagination">
    <?php
        if ($page != 1) { //页数不等于1
            $disable = "";
        }else{$disable = "disabled";}    
        ?>
    <li class="<?php echo($disable);?>"><a href="<?php echo($distitle);?>-<?php echo($page-1);?>.html">&larr;  Previous</a></li>  
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
        <li class="<?php echo($disable);?>"><a href="<?php echo($distitle);?>-<?php echo($i);?>.html"> <?php echo($i); echo($distag);?> </a></li>

    <?php
        }
        if ($page<$pagenum) { //
            $disable = "";
        }else{$disable = "disabled";}    
    ?>
    <li><a href="<?php echo($distitle);?>-<?php echo($page+1);?>.html" $disable> Next &rarr; </a></li>
</ul>


</div>

<?php include "footer.php";?>
  </body>
</html>


