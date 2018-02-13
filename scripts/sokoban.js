var x,y; // координаты персонажа
var m=[];
var stp=0;
var color=["#ffffff","#000000","#ffa500","#0000ff", "#ff0000","#00ee00"];
var elem = document.getElementById('out');
var key = { // клавиши управления
  "left": 37, "up": 38, "right": 39, "down": 40};

var urlParams = new URLSearchParams(window.location.search);
var params = {};
urlParams.forEach((p, key) => {
   params[key] = p;
});

if (params["w"]!==undefined && params["h"]!==undefined && params["l"]!==undefined){
  var level = '{"w":'+params['w']+',"h":'+params['h']+',"l":"'+params['l']+'"}';
}
else{
  var level = '{"w":19,"h":11,"l":"00001111100000000000000100010000000000000012001000000000000111002110000000000010020201000000000111010110100011111110001011011111003311020020000000000331111110111014110033100001000001111111110000111111100000000"}';
}

init_level();
var lname = document.getElementById('lname');
lname.innerHTML+="<a href='editor.html?w="+level.w+"&h="+level.h+"&l="+level.l+"'> (редактировать)</a>";
addEventListener("keydown", function(event) { // слушатель события
    if(p.hidden == false){
      p.hidden = true;
    }
    if (event.keyCode == key["left"]) left();
    else if(event.keyCode == key["up"]) up();
    else if(event.keyCode == key["right"]) right();
    else if(event.keyCode == key["down"]) down();
    draw2();
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

// управление мышкой
var xt=0;
var yt=0;

addEventListener("mousedown", function(event) {
  if (px<event.x && py<event.y && px+w>event.x && py+h>event.y) {
    xt=event.x; yt=event.y;
  }
});

addEventListener("mouseup", function(event) { 
  if (px<event.x && py<event.y && px+w>event.x && py+h>event.y) {
    xt-=event.x; yt-=event.y;
    if ((xt!=0) || (yt!=0)) dir();
  }
});

function dir(){ // выбор направления движения
  Math.abs(xt)>Math.abs(yt) ? (xt>0) ? left() :right(): (yt>0) ? up(): down();
  draw2();
  elem.innerHTML="Steps: "+ stp;
}


var p = document.getElementById("p");

draw();

function draw(){
  ctx.fillStyle="#000000";
  ctx.fillRect(0,0,w,h);
  for(var i=0; i<div(h,k);i++){
    for(var j=0; j<div(w,k);j++){
      ctx.fillStyle=color[m[i][j]];
      //elem.innerHTML+=m[i][j];
      ctx.fillRect(j*k+1,i*k+1,k-2,k-2);
      }
      //elem.innerHTML+="<br>";
  }
  ctx.fillStyle="#ff0000";
  ctx.fillRect(x*k+1,y*k+1,k-2,k-2);
}

function draw2(){
for(var i=y-2;i<y+2;i++){
  if (i>=0&&i<div(h,k)){
    ctx.fillStyle=color[m[i][x]];
    ctx.fillRect(x*k+1,i*k+1,k-2,k-2);
  }
}
for(var i=x-2;i<x+2;i++){
  if (i>=0&&i<div(w,k)){
    ctx.fillStyle=color[m[y][i]];
    ctx.fillRect(i*k+1,y*k+1,k-2,k-2);
  }
}
ctx.fillStyle="#ff0000"; // color[4]
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
  draw2();
  //alert("win");
  popup();
  }
}

function popup(){
  if(p.hidden == true){
    p.hidden = false;
    p.innerHTML="<div class='popup-content'><strong>Уровень пройден! Результат: "+stp+"</strong><br>Нажмите любую клавишу...</div>";
  }
  else{
    p.hidden = true;
  }
}