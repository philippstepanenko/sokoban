<!DOCTYPE>
<html>
<head>
<title>Editor. Setting</title>
<link rel="stylesheet" type="text/css" href="style/style.css">
<meta http-equiv="Cache-Control" content="no-cache">
<meta charset="utf-8">
</head>
<body>
<div class="level-name">
<a>倉庫番</a><br>
<img src="pic/head.png"><br>
<a>SOKOBAN</a></div>
<hr>
<ul id="navbar">
  <li><a href="index.php">Уровень</a></li>
  <li><a href="setting.php">Редактор</a></li>
  <li><a href="#">Справка</a></li>
</ul>
<br>
<div class="level-name" id="name">Размеры уровня</div>

<table>
<tr><td class='headtable'>Ширина</td><td><input id='w' class="in-numb" type='text' value='10'></td></tr>
<tr><td class='headtable'>Высота</td><td><input id='h' class="in-numb" type='text' value='10'></td></tr>
</table>
<div class="cent"><input class="enter2" type="button" id="bt" onclick="go()" value="Применить"></div>

<script>
function go () {
var w = document.getElementById('w').value;
var h = document.getElementById('h').value;
window.location="editor.php?w="+w+"&h="+h;
}
</script>

<br><div class="foot">2016, Philipp Stepanenko</div>

</body>
</html>