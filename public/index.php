<?php

#指派命名空間為 qbpwcf
namespace qbpwcf;

#匯入外部套件
require_once("qbpwcf/allInOne.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qbpwcf Demo</title>
<?php
#qbpwcf用的css樣式
$qbpwcfStyle=css::qbpwcfStyle();

#如果建立 qbpwcf 用的 css 語法失敗
if($qbpwcfStyle["status"]==="false"){

    #印出結果
    var_dump($record);

    #結束執行
    exit;

}#if end

#印出css語法
echo $qbpwcfStyle["content"];

#qbpwcf用的javascript
$qbpwcfJavaScript=javaScript::qbpwcfJavaScript();

#如果建立 qbpwcf 用的 js 語法失敗
if($qbpwcfJavaScript["status"]==="false"){

	#debug
	var_dump($qbpwcfJavaScript);

    #結束執行
    exit;

}#if end

#印出js語法
echo $qbpwcfJavaScript["content"];
?>
</head>
<body>

<div id="app"></div>

<script>

</script>
</body>
</html>


