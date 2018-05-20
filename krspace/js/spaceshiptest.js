var spaceship;
var myBackground;
var FH = document.getElementById("canvas_field").height;
var FW = document.getElementById("canvas_field").width;
var PIC_H = 9000;
var PIC_W = 3000;
var STOP = false;
var obstacles_arr = [];
var updateNum = 0;
var aim = [0,0];

String.prototype.replaceAt=function(index, replacement) {
    return this.substr(0, index) + replacement+ this.substr(index + replacement.length);
}
class Weapons {
  constructor() {
    this.units = [];
    this.units_num = [10,9,8];
    this.number = 0;
  }
  add_unit(a, b, c, d, t) {//add unit to the field
    if(t == "rocket" && this.units_num[0]!=0){
      this.units_num[0]--;
      this.units.push(new unit_w(a, b, c, d, t));
      this.number++;
      document.getElementById("booms_rocket").innerHTML = this.units_num[0];
    }else if (t=="blaster" && this.units_num[1]!=0) {
      this.units_num[1]--;
      this.units.push(new unit_w(a, b, c, d, t));
      this.number++;
      document.getElementById("booms_blaster").innerHTML = this.units_num[1];
    }else if (t=="laser" && this.units_num[2]!=0) {
      this.units_num[2]--;
      this.units.push(new unit_w(a, b, c, d, t));
      this.number++;
      document.getElementById("booms_laser").innerHTML = this.units_num[2];
    }
  }
  trydraw() {
    if (this.number != 0) {
      var obstacles_id=-1;
      this.units.forEach(function(item, i, arr) {
        for (var i = 0; i < obstacles_arr.length; i++)
          if (obstacles_arr[i].crashWith(item)) {
            obstacles_id=i;
            //STOP = true;
          }
      });
      if(obstacles_id!=-1)
      {
        // explode obstacle;
        //alert("asd");
        obstacles_arr[obstacles_id].image.src = "images/Obstacles/output-0.png";
      }
      //check for ended ttl
      var s = -1;
      this.units.forEach(function(item, i, arr) {
        if (item.move() == "r_f_e") {
          s=i;
        }
      });
      if(s!=-1) this.units.splice(s,1);
    }

  }
}
//weapon unit
class unit_w {
  constructor(f_x, f_y, t_x, t_y, type) {
    this.x = f_x;
    this.y = f_y;
    this.to_x = t_x;
    this.to_y = t_y;
    this.type = type;
    this.height = NaN;
    if (type == "rocket") {
      /*use this if can fix проблемы с точностью чисел с плавающей запятой
      this.speedX = (t_x - f_x)/Math.abs((t_x - f_x));
      this.speedY = (t_y - f_y)/Math.abs((t_x - f_x));
      document.getElementById("helptext").innerHTML = Math.abs(t_x-t_y);
      */
      this.ttl=100;
      this.speedX = (t_x - f_x)/100;
      this.speedY = (t_y - f_y)/100;
      {
        this.img = new Image();
        this.img.src = "images/Weapon units/rocket.png";
        var size = 20;
        this.width = size;
        this.height = size*4;
      }
    }else if (type == "blaster") {
      this.ttl=50;
      this.speedX = (t_x - f_x)/50;
      this.speedY = (t_y - f_y)/50;
      this.img = new Image();
      this.img.src = "images/Weapon units/blaster_unit_1.png";
      var blaster_unit_size = 50;
      this.width = blaster_unit_size;
      this.height = blaster_unit_size*2;
    }else if (type == "laser") {
      this.ttl=5;
      this.speedX = (t_x - f_x)/5;
      this.speedY = (t_y - f_y)/5;
      this.img = new Image();
      this.img.src = "images/Weapon units/blaster_unit_1.png";
      var blaster_unit_size = 5;
      this.width = blaster_unit_size;
      this.height = blaster_unit_size*200;
    }
  }
  move() {
    if(this.ttl>0)
    {
      this.ttl--;
      ctx = myGameArea.context;
      ctx.save();
      ctx.translate(this.x, this.y);
      var radians = Math.atan((this.speedY / this.speedX));
      var degrees = radians * 180 / Math.PI + 90;
      if (this.speedX < 0) degrees += 180;
      ctx.rotate(degrees * Math.PI / 180);
      if(this.type == "blaster")
        this.img.src = "images/Weapon units/blaster_unit_"+ (this.ttl%5+1) +".png";
      ctx.drawImage(this.img, this.width / -2 + this.speedX, this.height / -2 + this.speedY, this.width, this.height);
      this.x += this.speedX + myBackground.offset_x;
      this.y += this.speedY + myBackground.offset_y;
      ctx.restore();
    }
    else return "r_f_e";//rocket fuel ended
  }
}
var weapons = new Weapons();

function startGame() {
  spaceship = new component(30, 50, "", FW / 2, FH * 4 / 5);
  myBackground = new component(PIC_W, PIC_H, "images/space.png", -PIC_W / 2 + FW / 2, 0 - PIC_H / 2 + FH / 2);
  var obstacles = {
    start: this.interval = setInterval(gen_obstacles, 1000)
  };
  //handle stop_button
  var docStopBt = document.getElementById("stop_button");
  docStopBt.onclick = function() {
    if (docStopBt.innerHTML == "STOP") {
      docStopBt.innerHTML = "START";
      STOP = true;
    } else if (docStopBt.innerHTML == "START") {
      docStopBt.innerHTML = "STOP";
      STOP = false;
    }
  };
  //handle aim movement
  myGameArea.canvas.addEventListener('mousemove', function(e) {
    if (!STOP) {
      var aim1 = new Image();
      aim1.src = "images/aim_1.png";
      var w = aim1.naturalWidth;
      var h = aim1.naturalHeight;
      aim[0] = e.pageX - (w / 2 + 8);
      aim[1] = e.pageY - (h / 2 + 40);
    }
  }, false);
  //handle gamefield click
  myGameArea.canvas.addEventListener('mousedown', function(e) {
    if (!STOP) {
      //send rocket
      var x_from = spaceship.x;
      var x_to = e.pageX - (45 + 8);
      var y_from = spaceship.y;
      var y_to = e.pageY - (45 + 40);
      weapons.add_unit(x_from, y_from, x_to, y_to,""+document.getElementById("WeaponType").value);
    }
  }, false);
  myGameArea.start();

}
var myGameArea = {
  canvas: document.getElementById("canvas_field"),
  start: function() {
    this.context = this.canvas.getContext("2d");
    //document.body.insertBefore(this.canvas, document.body.childNodes[0]);
    this.frameNo = 0;
    this.interval = setInterval(updateGameArea, 20);
    window.addEventListener('keydown', function(e) {
      myGameArea.keys = (myGameArea.keys || []);
      myGameArea.keys[e.keyCode] = true;
    })
    window.addEventListener('keyup', function(e) {
      myGameArea.keys[e.keyCode] = false;
    })

  },
  clear: function() {
    this.context.clearRect(0, 0, FW, FH);
  },
  stop: function() {
    clearInterval(this.interval);
  }
}

function component(width, height, img, x, y) {
  this.image = new Image();
  this.image.src = img;
  this.width = width;
  this.fuel_i= Number.parseInt(document.getElementById("fuel_v").innerHTML);
  this.fuel=this.fuel_i;
  this.height = height;
  this.stub=0;
  this.health_i= Number.parseInt(document.getElementById("hp_v").innerHTML);
  this.health= this.health_i;
  this.speedX = 0;
  this.speedY = 0;
  this.x = x;
  this.y = y;
  //vars [backgound] for correct meteors movement
  this.offset_x = 0;
  this.offset_y = 0;
  //ship
  this.ship_hull = document.getElementById("ship_hull").value + "1.png";
  this.angle = 0;
  this.A = 0;
  this.moveAngle = 0;
  this.update = function() {
    ctx = myGameArea.context;
    ctx.save();
    ctx.translate(this.x, this.y);
    ctx.rotate(this.angle);
    ctx.drawImage(this.image, this.width / -2, this.height / -2, this.width, this.height)
    ctx.restore();
  }
  this.updateb = function() {
    ctx = myGameArea.context;
    ctx.drawImage(this.image,
      this.x,
      this.y,
      this.width, this.height);
  }
  this.newPos = function() {
    this.angle += this.moveAngle * Math.PI / 180;
    this.A += this.moveAngle;
    if(myBackground.speedY!=0 || myBackground.speedX!=0  ){
      this.fuel-=0.1;
      if(this.fuel<=0)
      {
        STOP=true;
        alert("you are looser, hehe");
      }
      //update fuel html
      var t = document.querySelector('.js1');
      var percent = Number((this.fuel/this.fuel_i*100).toFixed(0));
      t.style.setProperty('--f-v',"" + percent+"%");
      document.getElementById("percent1").innerHTML = percent+"%";
    }
    this.x += this.speedX;
    this.y += this.speedY;
  }
  this.newPosb = function() {
    this.offset_x = this.speedX;
    this.offset_y = this.speedY;
    this.x += this.speedX;
    this.y += this.speedY;
  }
  this.updateAnimation = function() {
    this.image.src = this.ship_hull;
  }
}

function obstacle(w, h, img, x, y) {
  this.image = new Image();
  this.image.src = img;
  this.width = w;
  this.height = h;
  this.speedX = 0;
  this.speedY = 0;
  this.x = x;
  this.init = x;
  this.y = y;
  this.ttd=0;//time to death[slow down explode anim]
  this.updates = function() {
    ctx = myGameArea.context;
    //explode obstacle
    if(this.image.src.indexOf("output")!=-1)
    {
      var num = this.image.src[this.image.src.indexOf("output")+7];
      this.ttd++;
      document.getElementById("helptext").innerHTML = this.ttd;
      if(num!=4 && this.ttd==5)
      {
        var audio = new Audio('audio/explosion.mp3');
        audio.play();
        this.ttd=0;
        num++;
        var str =""+this.image.src;
        var ind = str.indexOf("output")+7;
        str = str.substr(0, ind) + num+ str.substr(ind + 1);
        this.image.src = str;
      }else if(this.ttd==6){
        var  cur_i = obstacles_arr.indexOf(this);
        obstacles_arr.splice(cur_i,1);
      }
    }
    ctx.drawImage(this.image,
      this.x,
      this.y,
      this.width, this.height);
  }

  this.newPosb = function() {
    this.x += myBackground.offset_x + myBackground.offset_x;
    this.y += 5 + myBackground.offset_y;

  }
  this.crashWith = function(otherobj) {
    var myleft = this.x;
    var myright = this.x + (this.width);
    var mytop = this.y;
    var mybottom = this.y + (this.height);
    var otherleft = otherobj.x;
    var otherright = otherobj.x + (otherobj.width);
    var othertop = otherobj.y;
    var otherbottom = otherobj.y + (otherobj.height);
    if ((mybottom < othertop) ||
      (mytop > otherbottom) ||
      (myright < otherleft) ||
      (myleft > otherright)) {
      return false;
    }else {
      return true;
    }
  }
}
//every 20 miliseconds
function updateGameArea() {
  if (!STOP) {
    updateNum++;
    if (updateNum == 100) {
      updateNum = 0;
    }

    // Animation phases
    if (updateNum < 20 && spaceship.stub==0) {
      spaceship.ship_hull = document.getElementById("ship_hull").value + "1.png";
    }
    if (updateNum >= 20 && updateNum < 40 && spaceship.stub==0) {
      spaceship.ship_hull = document.getElementById("ship_hull").value + "2.png";
    }
    if (updateNum >= 40 && updateNum < 60 && spaceship.stub==0) {
      spaceship.ship_hull = document.getElementById("ship_hull").value + "3.png";
    }
    if (updateNum >= 60 && updateNum < 80 && spaceship.stub==0) {
      spaceship.ship_hull = document.getElementById("ship_hull").value + "4.png";
    }
    if (updateNum >= 80 && updateNum < 100 && spaceship.stub==0) {
      spaceship.ship_hull = document.getElementById("ship_hull").value + "5.png";
    }

    myGameArea.clear();
    myBackground.speedY = 0;
    myBackground.speedX = 0;
    spaceship.moveAngle = 0;
    var maneuverability_tmp = document.getElementById("maneuverability").value;
    var speed_tmp = document.getElementById("speed").value;
    if (myGameArea.keys) {
      var L = myGameArea.keys[37];
      var R = myGameArea.keys[39];
      var F = myGameArea.keys[38];
      var B = myGameArea.keys[40];

      if (L || F || R || B) {

        var cos_angle = Math.cos(spaceship.angle);
        var sin_angle = Math.sin(spaceship.angle);
        if (L) spaceship.moveAngle = -1 * (maneuverability_tmp);
        if (R) spaceship.moveAngle = maneuverability_tmp;
        if (F || B) {
          var dir = 1;
          if (B) dir = -1;
          myBackground.speedX = -1 * dir * speed_tmp * sin_angle;
          myBackground.speedY = dir * speed_tmp * cos_angle;
        }

      }

    }

    myBackground.newPosb();
    myBackground.updateb();
    //weapon unit is needed to be drawn before spaceship to be under it in canvas
    weapons.trydraw();
    spaceship.newPos();
    spaceship.update();
    spaceship.updateAnimation();
    //stub for not decreasing health very fast
    if(spaceship.stub !=0 )
    {

        if(spaceship.stub%5==0)
          spaceship.ship_hull = document.getElementById("ship_hull").value + "1.png"
        if(spaceship.stub%10==0)
          spaceship.ship_hull = "images/Hulls/transparent_stub.png"
        spaceship.stub++;
    }
    if(spaceship.stub>60)
      spaceship.stub=0;
    for (var i = 0; i < obstacles_arr.length; i++) {
      if (obstacles_arr[i].crashWith(spaceship)) {
        if(spaceship.stub==0)
        {
          //// TODO: for diff meteors
          var audio = new Audio('audio/auch.mp3');
          audio.play();
          spaceship.health-=10;
          //update health html
          var h = document.querySelector('.js2');
          var percent = Number((spaceship.health/spaceship.health_i*100).toFixed(0));
          h.style.setProperty('--hp-v',"" + percent+"%");
          document.getElementById("percent2").innerHTML = percent+"%";
          //
          document.getElementById("hp").value = spaceship.health;
          if(spaceship.health<=0)
          STOP=true;
          spaceship.stub++;
        }
      }
      obstacles_arr[i].updates();
      obstacles_arr[i].newPosb();
    }
  }
  draw_aim();
}
function draw_aim()
{
  ctx = myGameArea.context;
  var aim1 = new Image();
  aim1.src = "images/aim_1.png";
  var w = aim1.naturalWidth;
  var h = aim1.naturalHeight;
  ctx.drawImage(aim1,
    aim[0],
    aim[1],
    w, h);
}
function gen_obstacles() {
  if (!STOP) {
    var o_num = obstacles_arr.length % 3;
    switch (o_num) {
      case 0:
        obstacles_arr.push(new obstacle(80, 80, "images/Obstacles/meteor_1.png", myBackground.x + gR(0, PIC_W), myBackground.y + gR(0, 1000)));
        break;
      case 1:
        obstacles_arr.push(new obstacle(100, 100, "images/Obstacles/meteor_2.png", myBackground.x + gR(0, PIC_W), myBackground.y + gR(0, 1000)));
        break;
      case 2:
        obstacles_arr.push(new obstacle(150, 150, "images/Obstacles/meteor_3.png", myBackground.x + gR(0, PIC_W), myBackground.y + gR(0, 1000)));
        break;
    }
  }
}

function gR(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}
