<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="keywords" content="搜高清,高清电影，最新电影，免费电影">
<meta name="description" content="搜高清以提供最新以及历史的所有免费高清电影种子。提供高质量视频种子">

    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>友情链接- 搜高清视频,最新、最快、最全、最清晰的视频搜索网站</title>

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
              <a href="https://secure.insight-labs.org" title="Insight Labs" target="_blank">Insight Labs</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.sec-wiki.com/" title="SecWiki-安全维基" target="_blank">SecWiki-安全维基</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.xiatouzi.com/" title="瞎投资" target="_blank">瞎投资</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.doscn.org/" title="在线工具" target="_blank">在线工具</a>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.gsymy.com" title="程序猿的小本本" target="_blank">程序猿的小本本</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.yunwaf.com" title="云waf" target="_blank">云waf</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.zzxiaoyu.cn/" title="August's Blog" target="_blank">August's Blog</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.wianm.com/" title="wianm's blog" target="_blank">wianm's Blog</a> &nbsp;&nbsp;&nbsp;&nbsp; <a href="http://www.cnkk.me" title="Mr.K - 专注前端开发" target="_blank">Mr.K - 专注前端开发</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.hackersb.com" title="" target="_blank">王松_Striker</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </p>
        </div>

        
    </div>
</div>
</form>

<?php include "footer.php";?>
  </body>
</html>

