var code=1; // текущий блок-спрайт для рисования уровня
addEventListener("keydown", function(event) { // 
  if (event.keyCode>=48 && event.keyCode<=53){
    code=event.keyCode-48;
  }
});

var urlParams = new URLSearchParams(window.location.search);
var params = {};
urlParams.forEach((p, key) => {
   params[key] = p;
});

if (params["w"]!==undefined && params["h"]!==undefined){
  var temp_level = params["l"] !== undefined ? params['l'] : '0'.repeat(params['w']*params['h']);
  var level = '{"w":' + params['w'] + ',"h":' + params['h'] + ',"l":"' + temp_level + '"}';
}
else{
  var level = '{"w":20,"h":20,"l":"'+'0'.repeat(20*20)+'"}';
}

var m=[];
var color=["#ffffff","#000000","#ffa500","#0000ff", "#ff0000","#00ee00"];
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

function go () {
var l="";
for(var i=0; i<level.h;i++){
    for(var j=0; j<level.w;j++){
      l+=m[i][j];
    }
  }
window.location="index.html?w="+level.w+"&h="+level.h+"&l="+l;
}

function select_code(cd){
  code=cd;
}