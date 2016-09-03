<?php
$keyword = trim($_GET['keyword']);
$page = isset($_GET['page'])?intval($_GET['page']):1;

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

if(!$stmt){
    if(empty($stmt)){
        echo 'empty data!';
    }
    echo 'json error !';
    exit;
}

class torrent{
    public $name;
    public $filesize;
    public $createtime;
    public $hash;

}

while($row = $stmt -> fetch()){
    $tor=new torrent();
    $tor->name=$row['name'];
    $tor->hash=$row['hash'];
    $tor->filesize=$row['filesize'];
    $tor->createtime=$row['createtime'];
    //填充数组
    $arr[]=$tor;    
}
echo json_encode(array('total'=>$total,'torrents'=>$arr));
?>