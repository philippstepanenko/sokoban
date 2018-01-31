<!DOCTYPE>
<html>
<head>
<title>Editor.</title>
<link rel="stylesheet" type="text/css" href="style/style.css">
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
  <li><a href="ref.php">Справка</a></li>
</ul>
<br>
<div class="level-name" id="name">Редактирование уровня</div>
<div class="cent"><canvas id="drawingCanvas" width="10" height="10"></canvas></div>
<div class="cent">
<input class="code0" type="button" onclick="select_code(this.value)" value="0">
<input class="code1" type="button" onclick="select_code(this.value)" value="1">
<input class="code2" type="button" onclick="select_code(this.value)" value="2">
<input class="code3" type="button" onclick="select_code(this.value)" value="3">
<input class="code4" type="button" onclick="select_code(this.value)" value="4">
<input class="code5" type="button" onclick="select_code(this.value)" value="5">
</div>
<br>
<div class="cent"><input class="enter2" type="button" id="bt" onclick="go()" value="Пройти уровень"></div>
<br><div class="code" id="out"></div>
<br><div class="foot">2016, Philipp Stepanenko</div>
<?php
if ((!(isset($_GET['w'])))&&(!(isset($_GET["h"])))) {
  $w=20; $h=20;
  }
else{
  $w=$_GET["w"]; $h=$_GET["h"];
}
if (!(isset($_GET['l']))) {
  $l=str_repeat("0",$w*$h);
  }
else{
  $l=$_GET["l"];
}
?>
<script>
var code=1; // текущий блок-спрайт для рисования уровня
addEventListener("keydown", function(event) { // 
  if (event.keyCode>=48 && event.keyCode<=53){
        code=event.keyCode-48;
      }
});
var hx=0;
var hy=0;
var level='{"w":<?php echo $w; ?>, "h":<?php echo $h; ?>, "l":"'+ '<?php echo $l; ?>' +'"}';
var m=[];
//var color=["#ffffff","#000000","#ffA500","#0000ff", "#ff0000","#00ee00"];
var color=["#ffffff","#000000","#ffb500","#0000ff", "#ff0000","#00ee00"];
var k=20;
var isDrawing;
canvas = document.getElementById("drawingCanvas");
ctx = canvas.getContext("2d");
canvas.onmousedown = startDrawing;
//canvas.onmouseup = stopDrawing;
document.onmouseup = stopDrawing;
//canvas.onmouseout = stopDrawing;
canvas.onmousemove = draw;
init_level();
var w=level.w*k; // ширина поля
var h=level.h*k; // высота поля
canvas.width=w;
canvas.height=h;
draw_level();

function startDrawing(e) {
  isDrawing = true;
  draw(e); // fix: необходимо передавать "e"
  //ctx.beginPath();
  //ctx.moveTo(e.pageX - canvas.offsetLeft, e.pageY - canvas.offsetTop);
}
function draw(e) {
  if (isDrawing == true)
  {
    //ctx.fillStyle="#"+""+getr(0,99)+""+getr(0,99)+""+getr(0,99);
    ctx.fillStyle=color[code];
    var x = e.pageX - canvas.offsetLeft-10;
    var y = e.pageY - canvas.offsetTop-10;
    m[div(y,k)][div(x,k)]=code;
    ctx.fillRect(div(x,k)*k+1,div(y,k)*k+1,k-2,k-2);
    ctx.fill();
    //al_mas();
  }
}
function stopDrawing() { // остановка рисования
    al_mas();
    isDrawing = false;
}
function getr(min, max){ // возвращает псевдослучайное число в промеждутке [min;max]
  return Math.floor(Math.random() * (max - min + 1)) + min;
}
function init_level(){ //инициализация уровня
level = JSON.parse(level);
l=level.l;
for(var i=0; i<level.h;i++){
  m[i]=[];
    for(var j=0; j<level.w;j++){
      m[i][j]=parseInt(l.substr(j+level.w*i,1));
      //if (m[i][j]==4) {
        //m[i][j]=0; hx=j; hy=i;
      //}
    }
  }
al_mas();
}

function div(x, y){ // целочисленное деление
    return (x-x%y)/y;
}
function draw_level(){ //вывод уровня на экран
  ctx.fillStyle="#000000";
  ctx.fillRect(0,0,w,h);
  ctx.fillStyle="#ffffff";
  for(var i=0; i<div(h,k);i++){
    for(var j=0; j<div(w,k);j++){
      ctx.fillStyle=color[m[i][j]];
      ctx.fillRect(j*k+1,i*k+1,k-2,k-2);
      ctx.fill();
      }
  }
  //ctx.fillStyle="#ff0000";
  //ctx.fillRect(x*k+1,y*k+1,k-2,k-2);
}

function al_mas(){
var out = document.getElementById("out");
out.innerHTML="";
  for(var i=0; i<level.h;i++){
    for(var j=0; j<level.w;j++){
        out.innerHTML+=m[i][j];
    }
        out.innerHTML+="<br>";
  }
}
</script>
<script>
function go () {
var l="";
for(var i=0; i<level.h;i++){
    for(var j=0; j<level.w;j++){
      l+=m[i][j];
    }
  }
window.location="index.php?w="+level.w+"&h="+level.h+"&l="+l;
}

function select_code(cd){
  code=cd;
}
</script>
</body>
</html>