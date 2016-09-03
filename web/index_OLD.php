<?php
$dbhost= 'localhost';  
$user= 'root';  
$passwd = 'MysqlPass!2';
$dbname = 'dht';
$conn = new PDO("mysql:dbname=$dbname;host=$dbhost",$user,$passwd);

$conn->exec("set names utf8");

//function genClass($Classstr){
    //print("SELECT * FROM movie_hash WHERE `name` like '%$Classstr%' order by rand() limit 5");
/*
    $sql = "SELECT * FROM movie_hash WHERE `name` like '%$Classstr%' order by rand() limit 5";
    //print($sql);
    $stmt = $conn->query($sql);
    echo "<a href=\"list.php?name=\"$Classstr\" >$Classstr</a> &nbsp;&nbsp;&nbsp;&nbsp;"; 
    while($row = $stmt -> fetch()){
        echo "<a href=\"list.php?keyword=".$row['name']."\" > ".$row['name']."</a> &nbsp;&nbsp;&nbsp;&nbsp;";
    }
  */
//}
//$distitle = htmlspecialchars($keyword);

    function glkeyword($name,$key){
      $reg="/.*?$key/";
      //print($reg);
      preg_match_all ($reg,  $name,$out, PREG_PATTERN_ORDER); 
      //var_dump($out);
      $retstr = $out[0][0];
      $retstr=str_replace("【","",$retstr);
      $retstr=str_replace("】","",$retstr);
      $retstr=str_replace("《","",$retstr);
      $retstr=str_replace("》","",$retstr);
      $retstr=str_replace("[","",$retstr);
      $retstr=str_replace("]","",$retstr);
      $retstr = preg_replace("/www\..*?\.[a-z]{2,4}/is", "", $retstr);
      //echo $out[0][0];

      return $retstr;
    }
    //glkeyword("【周华健演唱会】2005","演唱会");
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="keywords" content="高清电影，最新电影，免费电影">
<meta name="description" content="搜高清以提供最新以及历史的所有免费高清电影种子。提供高质量视频种子">

    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>搜高清</title>

    

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
    
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
    <div class="container">
        <div class="navbar-header">
            <a title="最全的高清免费电影" class="navbar-brand" href="/" >搜高清</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/" >首页</a></li>
                <li ><a href="javascript:void(0);" onclick="AddFavorite('搜高清','http://maopian.link')">加入收藏</a></li>
                <li><a href="javascript:void(0;" onclick="SetHome(this,'http://maopian.link');">设为首页</a></li>
                
            </ul>          
        </div>
    </div>
</div>
</div>
    
<form class="x-sform" action="list.php">
<div class="container">
    <div class="div-search-box col-lg-offset-2 col-lg-8">
        <div class="logo">
            <img src="static/logo.jpg"  />
        </div>
        <div>
            <div class="input-group">
                <input placeholder="搜索电影、电视剧、明星" autocomplete="off" type="text" class="form-control x-kw" name="keyword">
                <span class="input-group-btn">
                <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span>搜 索</button>
                </span>
            </div>
        </div>
        <div class="good">
            <p>
              <!--
                <a href="download.php?hash=0abdd9487bd15c52b42a75eff6b3efc39324dcf3&name=%E5%91%A8%E6%9D%B0%E4%BC%A6MV%E5%90%88%E9%9B%86" >周杰伦MV合集</a> &nbsp;&nbsp;&nbsp;&nbsp;
            
                <a href="download.php?hash=17be89d05641382bcb5d922825ab48d4c8f089e3&name=%E8%B6%85%E8%83%BD%E9%99%86%E6%88%98%E9%98%9F.Big.Hero.6.2014.HD1080P.X264.AAC.English.CHS-ENG.Mp4Ba" >超能陆战队</a> &nbsp;&nbsp;&nbsp;&nbsp;
            
                <a href="download.php?hash=9f935789815dd75d9055eac2e184617fa08b8aa9&name=%E5%91%A8%E6%98%9F%E9%A9%B0%E7%94%B5%E5%BD%B1%E5%9B%BD%E8%AF%AD%E5%85%A8%E9%9B%86" >周星驰合集</a> &nbsp;&nbsp;&nbsp;&nbsp;
            
                <a href="download.php?hash=01823e5d25ef682420a51e0dc60221b0c3ee076e&name=%E9%BA%BB%E7%94%9F%E5%B8%8C%E5%87%BA%E9%81%93%E4%BB%A5%E4%BE%8611%E9%83%A8%E5%90%88%E9%9B%8614.6G(www.xvideos.so)" >麻生希出道以來11部合集</a> &nbsp;&nbsp;&nbsp;&nbsp;
            
                <a href="download.php?hash=e219446124d3f8d1e87742d2cddd2d93586614fb&name=%E5%91%A8%E6%B6%A6%E5%8F%91%E4%BD%9C%E5%93%81" >周润发作品</a> &nbsp;&nbsp;&nbsp;&nbsp;
              -->
              <?php 
              $Classstr = "演唱会";
              $sql = "SELECT * FROM movie_hash WHERE `name` like '%$Classstr%' order by rand() limit 10";
                  //print($sql);
                  $stmt = $conn->query($sql);
                  echo "<a href=\"list.php?keyword=$Classstr\">$Classstr</a> :&nbsp;&nbsp;&nbsp;&nbsp;"; 
                  while($row = $stmt -> fetch()){
                      $disname = glkeyword($row['name'],$Classstr);
                      echo "<a href=\"list.php?keyword=".str_replace($Classstr,"",$disname)."\" > ".$disname ."</a> &nbsp;&nbsp;&nbsp;&nbsp;";
                }
              ?>

            </p>
        </div>
        <!--<div class="good">
            <p>
              
             
                <a href="download.php?hash=0abdd9487bd15c52b42a75eff6b3efc39324dcf3&name=%E5%91%A8%E6%9D%B0%E4%BC%A6MV%E5%90%88%E9%9B%86" >周杰伦MV合集</a> &nbsp;&nbsp;&nbsp;&nbsp;
            
                <a href="download.php?hash=17be89d05641382bcb5d922825ab48d4c8f089e3&name=%E8%B6%85%E8%83%BD%E9%99%86%E6%88%98%E9%98%9F.Big.Hero.6.2014.HD1080P.X264.AAC.English.CHS-ENG.Mp4Ba" >超能陆战队</a> &nbsp;&nbsp;&nbsp;&nbsp;
            
                <a href="download.php?hash=9f935789815dd75d9055eac2e184617fa08b8aa9&name=%E5%91%A8%E6%98%9F%E9%A9%B0%E7%94%B5%E5%BD%B1%E5%9B%BD%E8%AF%AD%E5%85%A8%E9%9B%86" >周星驰合集</a> &nbsp;&nbsp;&nbsp;&nbsp;
            
                <a href="download.php?hash=01823e5d25ef682420a51e0dc60221b0c3ee076e&name=%E9%BA%BB%E7%94%9F%E5%B8%8C%E5%87%BA%E9%81%93%E4%BB%A5%E4%BE%8611%E9%83%A8%E5%90%88%E9%9B%8614.6G(www.xvideos.so)" >麻生希出道以來11部合集</a> &nbsp;&nbsp;&nbsp;&nbsp;
            
                <a href="download.php?hash=e219446124d3f8d1e87742d2cddd2d93586614fb&name=%E5%91%A8%E6%B6%A6%E5%8F%91%E4%BD%9C%E5%93%81" >周润发作品</a> &nbsp;&nbsp;&nbsp;&nbsp;
              

            </p>
        </div>
        <div class="good">
            <p>

              
                <a href="download.php?hash=0abdd9487bd15c52b42a75eff6b3efc39324dcf3&name=%E5%91%A8%E6%9D%B0%E4%BC%A6MV%E5%90%88%E9%9B%86" >周杰伦MV合集</a> &nbsp;&nbsp;&nbsp;&nbsp;
            
                <a href="download.php?hash=17be89d05641382bcb5d922825ab48d4c8f089e3&name=%E8%B6%85%E8%83%BD%E9%99%86%E6%88%98%E9%98%9F.Big.Hero.6.2014.HD1080P.X264.AAC.English.CHS-ENG.Mp4Ba" >超能陆战队</a> &nbsp;&nbsp;&nbsp;&nbsp;
            
                <a href="download.php?hash=9f935789815dd75d9055eac2e184617fa08b8aa9&name=%E5%91%A8%E6%98%9F%E9%A9%B0%E7%94%B5%E5%BD%B1%E5%9B%BD%E8%AF%AD%E5%85%A8%E9%9B%86" >周星驰合集</a> &nbsp;&nbsp;&nbsp;&nbsp;
            
                <a href="download.php?hash=01823e5d25ef682420a51e0dc60221b0c3ee076e&name=%E9%BA%BB%E7%94%9F%E5%B8%8C%E5%87%BA%E9%81%93%E4%BB%A5%E4%BE%8611%E9%83%A8%E5%90%88%E9%9B%8614.6G(www.xvideos.so)" >麻生希出道以來11部合集</a> &nbsp;&nbsp;&nbsp;&nbsp;
            
                <a href="download.php?hash=e219446124d3f8d1e87742d2cddd2d93586614fb&name=%E5%91%A8%E6%B6%A6%E5%8F%91%E4%BD%9C%E5%93%81" >周润发作品</a> &nbsp;&nbsp;&nbsp;&nbsp;
              
            </p>
        </div>-->
        <div class="div-ads-front" style="margin-top: 40px; text-align:center; margin-left: 0px;">
        </div>
    </div>
</div>
</form>


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
  
<script src="static/js/bootstrap-typeahead.min.js" ></script>
<div style="display:none;">
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1255999001'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1255999001' type='text/javascript'%3E%3C/script%3E"));</script></div>
  </body>
</html>

