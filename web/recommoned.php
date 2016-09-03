<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="keywords" content="高清电影,最新电影,免费电影,BT下载,迅雷下载,种子下载">
<meta name="description" content="搜高清以提供最新以及历史的所有免费高清电影种子。提供高质量视频种子">

    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>推荐搜索- 搜高清视频,最新、最快、最全、最清晰的视频搜索网站</title>

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
                <?php include "nav.php";?>
                <li ><a href="javascript:void(0);" onclick="AddFavorite('搜高清','http://maopian.link')">加入收藏</a></li>
                <li><a href="javascript:void(0;" onclick="SetHome(this,'http://maopian.link');">设为首页</a></li>
                
            </ul>          
        </div>
    </div>
</div>
</div>
    
<form class="x-sform">
<div class="container">
    <div class="div-search-box col-lg-offset-2">
        <div style="height:100px;"></div>

        <div>
          <?php
          $handle = fopen("keyword.txt", "r");
          //Output a line of the file until the end is reached
          if ($handle) {
            while (!feof($handle)) {
              $line = fgets($handle);
              //echo $line;

              $c = explode(':',$line);
          ?>
            <p>
              <span><?php echo $c[0];?></span>
              <?php
              $cc = explode('|',$c[1]);
              //Output a line of the file until the end is reached
                foreach($cc  as &$ccc)
              {
              ?>
              <a href="/search/<?php echo($ccc);?>" title="<?php echo($ccc);?>" target="_blank"><?php echo($ccc);?></a> &nbsp;&nbsp;&nbsp;&nbsp;
              <?php } ?>
            </p>
            <?php 
            }}
            fclose($handle);
            ?>
        </div>    
    </div>
</div>
</form>

<?php include "footer.php";?>
  </body>
</html>

