var spaceship;
var myBackground;
var FH = 700;
var FW = 1200;
var PIC_H = 9000;
var PIC_W = 3000;
var STOP = false;
var obstacles_arr = [];
var updateNum = 0;
var all_drawn = false;

class Weapons {
  constructor() {
    this.units = [];
    this.number = 0;
  }
  add_unit(a, b, c, d) {
    this.units.push(new unit_w(a, b, c, d));
    this.number++;
  }
  trydraw() {

    if (this.number != 0) {
      this.units.forEach(function(item, i, arr) {
        item.move();
      });
    }
  }
}
//weapon unit
class unit_w {
  constructor(f_x, f_y, t_x, t_y) {
    this.x = f_x;
    this.y = f_y;
    this.to_x = t_x;
    this.to_y = t_y;
    this.speedX = (t_x-f_x)/100;
    this.speedY = (t_y-f_y)/100;
    this.img = new Image();
    this.img.src = "images/Weapon units/rocket.png";
    this.w = 45;
    this.h = 90;
    this.a = -30;
  }
  move() {
    ctx = myGameArea.context;
    ctx.save();
    ctx.translate(this.x, this.y);
    var radians = Math.atan((this.speedY/this.speedX));
    var degrees = radians* 180 / Math.PI+90;
    if(this.speedX<0)degrees+=180;
    document.getElementById("helptext").innerHTML = ""+degrees;
    ctx.rotate(degrees* Math.PI/180);
    ctx.drawImage(this.img, this.w / -2+ this.speedX, this.h / -2 +this.speedY, this.w, this.h)
    this.x += this.speedX + myBackground.offset_x;
    this.y += this.speedY + myBackground.offset_y;
    ctx.restore();
  }
}
var weapons = new Weapons();

function startGame() {
  spaceship = new component(30, 50, "", FW / 2, FH*4 / 5);
  myBackground = new component(PIC_W, PIC_H, "images/space.png", - PIC_W / 2 + FW / 2, 0 - PIC_H/2 + FH/2);
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
      ctx = myGameArea.context;
      var aim = new Image();
      aim.src = "images/aim_1.png";
      var w = 90;
      var h = 90;
      ctx.drawImage(aim,
        e.pageX - (w/2 + 8),
        e.pageY - (h/2 + 8),
        w, h);
    }
  }, false);
  //handle gamefield click
  myGameArea.canvas.addEventListener('mousedown', function(e) {
    if (!STOP) {
      //send rocket
      var x_from = spaceship.x;
      var x_to = e.pageX - (45 + 8);
      var y_from = spaceship.y;
      var y_to = e.pageY - (45 + 8);
      weapons.add_unit(x_from, y_from, x_to, y_to);
    }
  }, false);
  myGameArea.start();

}
var myGameArea = {
  canvas: document.createElement("canvas"),
  start: function() {
    this.canvas.width = FW;
    this.canvas.height = FH;
			document.getElementById("y").value = e.pageY;
    this.context = this.canvas.getContext("2d");
    document.body.insertBefore(this.canvas, document.body.childNodes[0]);
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
    this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
  },
  stop: function() {
    clearInterval(this.interval);
  }
}


function component(width, height, img, x, y) {
  this.image = new Image();
  this.image.src = img;
  this.width = width;
  this.height = height;
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
    this.x += this.speedX;
    this.y += this.speedY;
  }
  this.newPosb = function() {
    this.offset_x = this.speedX;
    //this.offset_x += this.speedX;
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
  this.updates = function() {
    ctx = myGameArea.context;
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
    var crash = true;
    if ((mybottom < othertop) ||
      (mytop > otherbottom) ||
      (myright < otherleft) ||
      (myleft > otherright)) {
      crash = false;
    }
    return crash;
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
    if (updateNum < 20) {
      spaceship.ship_hull = document.getElementById("ship_hull").value + "1.png";
    }
    if (updateNum >= 20 && updateNum < 40) {
      spaceship.ship_hull = document.getElementById("ship_hull").value + "2.png";
    }
    if (updateNum >= 40 && updateNum < 60) {
      spaceship.ship_hull = document.getElementById("ship_hull").value + "3.png";
    }
    if (updateNum >= 60 && updateNum < 80) {
      spaceship.ship_hull = document.getElementById("ship_hull").value + "4.png";
    }
    if (updateNum >= 80 && updateNum < 100) {
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
    for (var i = 0; i < obstacles_arr.length; i++) {
      if (obstacles_arr[i].crashWith(spaceship)) {
        STOP = true;
      }
      obstacles_arr[i].updates();
      obstacles_arr[i].newPosb();
    }
  }
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