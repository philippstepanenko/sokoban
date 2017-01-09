<!DOCTYPE>
<html>
<head>
<title>Sokoban</title>
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
  <li><a href="#">Справка</a></li>
</ul>
<br>
<div class="level-name" id="name">Level</div>
<div class="cent"><canvas id="graphic" width="380" height="220"></canvas></div>
<br><div class="stp" id="out">Steps: 0</div>
<br><div class="foot">2016, Philipp Stepanenko</div>
<?php // проверка GET
if (!(isset($_GET['l']))){
    $w=19; $h=11; $l="00001111100000000000000100010000000000000012001000000000000111002110000000000010020201000000000111010110100011111110001011011111003311020020000000000331111110111014110033100001000001111111110000111111100000000";
}
else{
  $w=$_GET['w']; $h=$_GET['h']; $l=$_GET['l'];
}
?>
<script>
var x,y; // координаты персонажа
var m=[];
var stp=0;
var color=["#ffffff","#000000","#ffA500","#0000ff", "#ff0000","#00ee00"];
var elem = document.getElementById('out');
var key = { // клавиши управления
  "left": 37, "up": 38, "right": 39, "down": 40};
var level='{"w":<?php echo $w;?>, "h":<?php echo $h;?>, "l":"<?php echo $l;?>"}';
init_level();
addEventListener("keydown", function(event) { // слушатель события
    if (event.keyCode == key["left"]) left();
    else if(event.keyCode == key["up"]) up();
    else if(event.keyCode == key["right"]) right();
    else if(event.keyCode == key["down"]) down();
    draw();
    elem.innerHTML="Steps: "+ stp;
});
var k=20;
var canvas=document.querySelector('#graphic');
var ctx=canvas.getContext('2d');
canvas.width=level.w*k;
canvas.height=level.h*k;
var px=canvas.offsetLeft; var py=canvas.offsetTop;
var w=level.w*k; // ширина поля
var h=level.h*k; // высота поля
draw();

function draw(){
  //ctx.fillStyle="#bbbbbb";
  ctx.fillStyle="#000000";
	ctx.fillRect(0,0,w,h);
  //ctx.fillStyle="#ffffff";
  for(var i=0; i<div(h,k);i++){
  	for(var j=0; j<div(w,k);j++){
      ctx.fillStyle=color[m[i][j]];
      //elem.innerHTML+=m[i][j];
  		ctx.fillRect(j*k+1,i*k+1,k-2,k-2);
    	ctx.fill();
      }
      //elem.innerHTML+="<br>";
  }
  ctx.fillStyle="#ff0000";
  ctx.fillRect(x*k+1,y*k+1,k-2,k-2);
}

function div(x, y){
    return (x-x%y)/y;
}

function init_level(){
level = JSON.parse(level);
for(var i=0; i<level.h;i++){
  m[i]=[];
  	for(var j=0; j<level.w;j++){
    	m[i][j]=parseInt(level.l.substr(j+level.w*i,1));
      if (m[i][j]==4) {m[i][j]=0; x=j; y=i;}
      //elem.innerHTML+=l.substr(j+w*i,1);
    }
    //elem.innerHTML+="<br>";
  }
}

function left(){
if (x>0) {
	if (m[y][x-1]==0 || m[y][x-1]==3){ // если не ящик
  	x--; stp++;
  }
  else if (m[y][x-1]==2 && x>0 && (m[y][x-2]==0 || m[y][x-2]==3)){ // если ящик
    	m[y][x-2]+=m[y][x-1];
      m[y][x-1]=0;
      x--; stp++;
      win();
  	}
    else if (m[y][x-1]==5 && x>0 && (m[y][x-2]==0 || m[y][x-2]==3)){
      	m[y][x-2]+=m[y][x-1]-3;
        m[y][x-1]=3;
        x--; stp++;
  }
}
}
function up(){
if (y>0) {
	if (m[y-1][x]==0 || m[y-1][x]==3){ // если не ящик
  	y--; stp++;
  }
  else if (m[y-1][x]==2 && y>1 && (m[y-2][x]==0 || m[y-2][x]==3)){ // если ящик
    	m[y-2][x]+=m[y-1][x];
      m[y-1][x]=0;
      y--; stp++;
      win();
  	}
    else if (m[y-1][x]==5 && y>1 && (m[y-2][x]==0 || m[y-2][x]==3)){
      	//m[y-2][x]+=m[y-1][x]-3;
        m[y-2][x]+=m[y-1][x]-3;
        m[y-1][x]=3;
        y--; stp++;
  }
}
}

function down(){
if (y<level.h) {
	if (m[y+1][x]==0 || m[y+1][x]==3){ // если не ящик
  	y++; stp++;
  }
  else if (m[y+1][x]==2 && y-1<level.h && (m[y+2][x]==0 || m[y+2][x]==3)){ // если ящик
    	m[y+2][x]+=m[y+1][x];
      m[y+1][x]=0;
      y++; stp++;
      win();
  	}
    else if (m[y+1][x]==5 && y-1<level.h && (m[y+2][x]==0 || m[y+2][x]==3)){
      	m[y+2][x]+=m[y+1][x]-3;
        m[y+1][x]=3;
        y++; stp++;
  }
}
}

function right(){
if (x<level.w) {
	if (m[y][x+1]==0 || m[y][x+1]==3){ // если не ящик
  	x++; stp++;
  }
  else if (m[y][x+1]==2 && x<level.w && (m[y][x+2]==0 || m[y][x+2]==3)){ // если ящик
    	m[y][x+2]+=m[y][x+1];
      m[y][x+1]=0;
      x++; stp++;
      win();
  	}
    else if (m[y][x+1]==5 && x<level.w && (m[y][x+2]==0 || m[y][x+2]==3)){
      	m[y][x+2]+=m[y][x+1]-3;
        m[y][x+1]=3;
        x++; stp++;
  }
}
}

function win(){
var sum=0;
for(var i=0; i<level.h;i++){
  	for(var j=0; j<level.w;j++){
    if (m[i][j]==2) sum++;
  }
}
if(sum==0) {
	draw();
  alert("win");
  sql="INSERT INTO `levels` (`id`, `name`, `w`, `h`, `level_code`, `autor`) VALUES (NULL, 'Classic 1', '"+level.w+"', '"+level.h+"', '"+level.l+"', NULL);";
  alert(sql);
	}
}
</script>
</body>
</html>