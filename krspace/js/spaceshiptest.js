var SPACESHIP;
var MY_BACKGROUND;

var FH = Number.parseInt(document.getElementById('canvas_field').clientHeight);
var FW = Number.parseInt(document.getElementById('canvas_field').clientWidth);
var TOP = document.getElementById("canvas_field").offsetTop;
var LEFT = document.getElementById("canvas_field").offsetLeft;

var POINTS = 0;
var PIC_H = 6000;
var PIC_W = 6000;
var STOP = false;

var obstacles_arr = [];
var drops_arr = [];

var updateNum = 0;
var weapons;

var aim = [0, 0];
var aim1;

var myGameArea = {
  canvas: document.getElementById("canvas_field"),
  start: function() {
    this.context = this.canvas.getContext("2d");
    //document.body.insertBefore(this.canvas, document.body.childNodes[0]);
    this.frameNo = 0;
    this.interval = setInterval(UpdateGameArea, 20);
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

class Weapons {
  constructor(types,names,images,damages,ammos,recharges,ranges) {
    this.units = [];
    this.types = types;
    this.names = names;
    this.images = images;
    this.damages = damages;
    this.ammos = ammos;
    this.recharges = recharges;
    this.ranges = ranges;
    this.number = 0;
    this.cur_recharges = [0,0,0,0,0];
  }
  add_unit(a, b, c, d, t) { //add unit to the field
    for(var weap_id=0;weap_id<5;weap_id++)
    {
      if(t==weap_id && (this.ammos[weap_id] > 0) && this.cur_recharges[weap_id]==0)//here we try to make shot
      {

        //
        this.ammos[weap_id]--;
        this.cur_recharges[weap_id] = this.recharges[weap_id];
        this.units.push(new WeaponUnitOnField(a, b, c, d, t));//here is launch
        this.number++;
        document.getElementById("weapon"+(weap_id+1)).innerHTML = this.ammos[0];
      }
    }
  }
  trydraw() {
    if (this.number != 0) {
      var obstacles_id = -1;
      var unit_crashed_id = -1;
      this.units.forEach(function(item, unit_id, arr) {
        for (var i = 0; i < obstacles_arr.length; i++)
          if (obstacles_arr[i].crashWith(item)) {
            obstacles_id = i;
            unit_crashed_id =unit_id;
          }
      });
      if(unit_crashed_id!=-1)
      {
        this.units.splice(unit_crashed_id, 1);
      }
      if (obstacles_id != -1) {
        var rand = gR(0,5);
        var niiice = ["fuel","bullets"];
        var val = -1;
        if (obstacles_arr[obstacles_id].image.src.indexOf("meteor_1") != -1) {
          val=35
          POINTS += 5;
        }else if (obstacles_arr[obstacles_id].image.src.indexOf("meteor_2") != -1) {
          val=10;
          POINTS += 10;
        }else if (obstacles_arr[obstacles_id].image.src.indexOf("meteor_3") != -1) {
          val=20;
          POINTS += 20;
        }
        if(val!=-1 && rand!=5)
        {
          // explode obstacle;
          obstacles_arr[obstacles_id].health-=val;
          if(obstacles_arr[obstacles_id].health<=0)
          {
              drops_arr.push(new Drop(niiice[rand%2], val, obstacles_arr[obstacles_id].x, obstacles_arr[obstacles_id].y));
              if(obstacles_arr[obstacles_id].image.src.indexOf("meteor_1"))POINTS+=5;
              if(obstacles_arr[obstacles_id].image.src.indexOf("meteor_2"))POINTS+=10;
              if(obstacles_arr[obstacles_id].image.src.indexOf("meteor_3"))POINTS+=20;
              obstacles_arr[obstacles_id].image.src = "images/Obstacles/output-0.png";
          }
        }
      }
      //check for ended ttl
      var s = -1;
      this.units.forEach(function(item, i, arr) {
        if (item.move() == "r_f_e") {
          s = i;
        }
      });
      if (s != -1) this.units.splice(s, 1);
    }
  }
}

class WeaponUnitOnField {
  constructor(f_x, f_y, t_x, t_y, w_id) {
    this.x = f_x;
    this.y = f_y;
    this.to_x = t_x;
    this.to_y = t_y;
    this.type = w_id;
    this.height = NaN;
    this.wait=5;
    // K*dXcur^2+K*dYcur^2=NEEDSPEED^2  get K and use it
    this.img = new Image();
    var size=0;
    if(weapons.types[w_id]=="missile_weapon")//not very fast
    {
      var SP = 10; //needed absolute speed
      this.ttl = 10*weapons.ranges[w_id]/SP;
      this.img.src = "images/Weapon units/rocket.png";
      this.width = 20;
      this.height = 80;
    } else if(weapons.types[w_id]=="laser_weapon")
    {
      var SP = 20; //needed absolute speed
      this.ttl = 10*weapons.ranges[w_id]/SP;
      this.img.src = "images/Weapon units/blaster_unit.png";
      this.width = 20;
      this.height = 80;
    } else if(weapons.types[w_id]=="blaster")
    {
      var SP = 15; //needed absolute speed
      this.ttl = 10*weapons.ranges[w_id]/SP;
      this.img.src = "images/Weapon units/blaster_unit_1.png";
      this.width = 30;
      this.height = 30;
    } else if(weapons.types[w_id]=="plasma_weapon")
    {
      var SP = 10; //needed absolute speed
      this.ttl = 10*weapons.ranges[w_id]/SP;
      this.img.src = "images/Weapon units/blaster_unit_1.png";
      this.width = 20;
      this.height = 80;
    }
    var q2 = Math.sqrt(Math.pow(SP, 2) / (Math.pow(t_x - f_x, 2) + Math.pow(t_y - f_y, 2)));
    this.speedX = q2 * (t_x - f_x);
    this.speedY = q2 * (t_y - f_y);
  }
  move() {
    if (this.ttl > 0) {
      this.ttl--;
      var ctx = myGameArea.context;
      if(weapons.types[this.type]=="laser_weapon")
      {
        ctx.beginPath();
        ctx.moveTo(SPACESHIP.x, SPACESHIP.y);
        var a = this.to_x+aim1.naturalWidth/2 - SPACESHIP.x;
        var b = this.to_y+aim1.naturalHeight/2 - SPACESHIP.y;
        var c = Math.sqrt(Math.pow(Math.abs(a),2)+Math.pow(Math.abs(b),2));
        var k = 3*weapons.ranges[this.type]/c;
        k = k.toFixed(5);
        ctx.lineTo(SPACESHIP.x+k*a, SPACESHIP.y+k*b);
        ctx.lineWidth = 5;
        ctx.strokeStyle="yellow"
        ctx.stroke();
        //use
        var dmg = weapons.damages[this.type];
        obstacles_arr.forEach(function(item,id,arr){
          var x0_obstacle = item.x;
          var x1_obstacle = item.x+item.width;
          var y0_obstacle = item.y;
          var y1_obstacle = item.y+item.height;
          var x0_laser = SPACESHIP.x;
          var x1_laser = SPACESHIP.x+k*a;
          var y0_laser = SPACESHIP.y;
          var y1_laser = SPACESHIP.y+k*b;
          //resolve
          if(x0_laser>x1_laser){var t1 =x0_laser;x0_laser = x1_laser;x1_laser=t1;}
          if(y0_laser>y1_laser){var t2 =y0_laser;y0_laser = y1_laser;y1_laser=t2;}
          var stepx = Math.abs(a/200);
          var stepy = Math.abs(b/200);
          stepy = stepy.toFixed(4);
          stepx = stepx.toFixed(4);
          var x=x0_laser;
          var y=Number.parseInt(y0_laser,10);
          var in_=false;
          while(x<x1_laser || y<y1_laser)
          {
            //check if point in square
            if( (x>x0_obstacle && x < x1_obstacle) && (y>y0_obstacle &&y < y1_obstacle) )
              {
                in_=true;
                break;
              }

            x+=Number.parseFloat(stepx);
            y+=Number.parseFloat(stepy);
          }
          if(in_)
          {
            //beat obstacle
              if(item.time==5)
              {
                item.time=0;
                if(item.health>0)item.health-=5;
                if(item.health<=0)
                {
                    var rand = gR(0,5);
                    var niiice = ["fuel","bullets"];
                    if(rand!=5)drops_arr.push(new Drop(niiice[rand%2], 10, item.x, item.y));
                    item.image.src = "images/Obstacles/output-0.png";
                }
              }else {
                item.time++;
              }

          }
        });
      } else {
        ctx.save();
        ctx.translate(this.x, this.y);
        var radians = Math.atan((this.speedY / this.speedX));
        var degrees = radians * 180 / Math.PI + 90;
        if (this.speedX < 0) degrees += 180;
        ctx.rotate(degrees * Math.PI / 180);
        if (weapons.types[this.type]=="blaster" || weapons.types[this.type]=="plasma_weapon")
        {
          var id = this.img.src.indexOf(".png")-1;
          var pic_num = Number.parseInt(this.img.src[id]);
          if(pic_num==5)pic_num=0;
          if(this.wait==0)
          {
            this.wait=1;
            this.img.src = "images/Weapon units/blaster_unit_"+(pic_num+1)+".png";
          }
          this.wait--;
        }
        ctx.drawImage(this.img, this.width / -2 + this.speedX, this.height / -2 + this.speedY, this.width, this.height);
        this.x += this.speedX + MY_BACKGROUND.offset_x;
        this.y += this.speedY + MY_BACKGROUND.offset_y;
        ctx.restore();
      }
    } else return "r_f_e"; //rocket fuel ended
  }
}

class Drop {
  constructor(type, value, x, y) {
    this.x = x;
    this.y = y;
    this.type=type;
    this.value=value;
    this.width = 30;
    this.height = 30;
    this.ttsh=-1;//time to SPACESHIP
    this.index = drops_arr.length;
    if (this.type == "fuel") {
      this.img = new Image();
      this.img.src = "images/Drops/fuel.png";
      this.ttl = 500;
    }
    if (this.type == "bullets") {
      this.img = new Image();
      this.img.src = "images/Drops/bullets.png";
      this.ttl = 500;
    }
  }
  draw() {
    this.ttl--;
    var ctx = myGameArea.context;
    ctx.drawImage(this.img, this.x+=MY_BACKGROUND.speedX, this.y+=MY_BACKGROUND.speedY, this.width, this.height);
    //check for SPACESHIP above
    if(this.SPACESHIPIsAbove(SPACESHIP))
    {
      if(this.type=="fuel")
      {
        if(SPACESHIP.fuel<=SPACESHIP.fuel_i){
          if(SPACESHIP.fuel+this.value>SPACESHIP.fuel_i)SPACESHIP.fuel=SPACESHIP.fuel_i;
          else SPACESHIP.fuel+=this.value;
        }
      }else if(this.type=="bullets")
        {
          weapons.ammos[SPACESHIP.weapon_id]+=this.value;
        }
      return true;
    }
    if (this.ttl < 0) return true;
    return false;
  }
  SPACESHIPIsAbove(otherobj) {
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
    } else {
      return true;
    }
  }
}

class Background {
  constructor(width, height, img, x, y){
    this.image = new Image();
    this.image.src = img;
    this.width = width;
    this.height = height;
    this.stub = 0;
    this.speedX = 0;
    this.speedY = 0;
    this.x = x;
    this.y = y;
    //vars  for correct meteors movement
    this.offset_x = 0;
    this.offset_y = 0;
    this.left = false;
    this.right = false;
    this.up = false;
    this.down = false;
  }

  updateb() {
    var ctx = myGameArea.context;
    ctx.drawImage(this.image,
      this.x,
      this.y,
      this.width, this.height);
  }

  newPosb() {
     this.left = false;
      this.right = false;
      this.up = false;
      this.down = false; //shows that you go out of edges
    if ((this.x > 0 && this.speedX >= 0)) this.left = true;
    if ((this.x < (FW - PIC_W) && this.speedX <= 0)) this.right = true;
    if ((this.y > 0 && this.speedY >= 0)) this.up = true;
    if ((this.y < (FH - PIC_H) && this.speedY <= 0)) this.down = true;
    this.offset_x=0;
    this.offset_y=0;
    if (!(this.left || this.right || this.up || this.down)) {
      this.offset_x = this.speedX;
      this.offset_y = this.speedY;
      this.x += this.speedX;
      this.y += this.speedY;
    }
  }
}

class Spaceship {
  constructor(width, height, img, x, y){
    this.image = new Image();
    this.image.src = img;
    this.width = width;
    this.fuel_i = Number.parseInt(document.getElementById("fuel_v").innerHTML);
    this.fuel = this.fuel_i;
    this.height = height;
    this.stub = 0;
    this.health_i = Number.parseInt(document.getElementById("hp_v").innerHTML);
    this.health = this.health_i;
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
    //droid
    this.hasdoird = false;
    this.hp_heal = 0;
    this.hour = 0; //where it is now 0 to 360
    //current weapon_id
    this.weapon_id=0;
    //magnetic_grip
    this.hasgrip=false;
    this.grip_radius=0;
    this.grip_capacity=0;
    //
    this.left = false;
    this.right = false;
    this.up = false;
    this.down = false;
  }
  update() {
    this.x = FW/2;
    this.y = FH/2;
    var k = 0.7;
    this.width = k * this.image.naturalWidth;
    this.height = k * this.image.naturalHeight;
    var ctx = myGameArea.context;
    ctx.save();
    ctx.translate(this.x, this.y);
    ctx.rotate(this.angle);
    ctx.drawImage(this.image, this.width / -2, this.height / -2, this.width, this.height);
    ctx.restore();
    if (this.hasdoird) {
      if (this.hour % 60 == 0 && this.health <= (this.health_i - this.hp_heal))
        {
          this.health += Number.parseInt(this.hp_heal,10);
        }
      var radius = 40;
      var rad = this.hour * Math.PI / 180;
      this.hour++;
      if (this.hour == 361) this.hour = 0;
      var ctx = myGameArea.context;
      var im = new Image();
      im.src = document.getElementById("ship_repair_droid").value+"1.png";
      ctx.save();
      ctx.translate(this.x, this.y);
      ctx.drawImage(im, Math.cos(rad) * radius - 15, Math.sin(rad) * radius - 15, 30, 30);
      ctx.restore();
    }
  }
  newPos() {
    this.angle += this.moveAngle * Math.PI / 180;
    this.A += this.moveAngle;
    if (MY_BACKGROUND.speedY != 0 || MY_BACKGROUND.speedX != 0) {
      this.fuel -= 0.03;
      if (this.fuel <= 0) {
        STOP = true;
        alert("you are out of fuel, game over");
      }
      //update fuel html
      var t = document.querySelector('.js1');
      var percent = Number((this.fuel / this.fuel_i * 100).toFixed(0));
      t.style.setProperty('--f-v', "" + percent + "%");
      document.getElementById("percent1").innerHTML = percent + "%";
    }

    this.x += this.speedX;
    this.y += this.speedY;
  }
  updateAnimation(){
    this.image.src = this.ship_hull;
  }
  add_droid(hp_heal){
    this.hasdoird = true;
    this.hp_heal = hp_heal;
  }
  add_grip(radius,capacity){
    this.hasgrip = true;
    this.grip_radius = radius;
    this.grip_capacity = capacity;
  }
}

class Obstacle {
  constructor(w, h, img, x, y, angle, dir, speed){
    this.image = new Image();
    this.image.src = img;
    this.width = w;
    this.height = h;
    this.speedX = 0;
    this.speedY = 0;
    this.health_i = 30;
    this.health = this.health_i;
    this.x = x;
    this.init = x;
    this.y = y;
    this.ttd = 0; //time to death[slow down explode anim]
    //angle changing
    this.angle = 0;
    this.angle_chg = angle;
    //direction
    this.dir = dir;
    this.speed = speed;
    //stub for laser
    this.time=5;
  }

  updates() {
    var ctx = myGameArea.context;
    //explode obstacle
    if (this.image.src.indexOf("output") != -1) {
      var num = this.image.src[this.image.src.indexOf("output") + 7];
      this.ttd++;
      if (num != 4 && this.ttd == 5) {
        var audio = new Audio('audio/explosion.mp3');
        audio.play();
        this.ttd = 0;
        num++;
        var str = "" + this.image.src;
        var ind = str.indexOf("output") + 7;
        str = str.substr(0, ind) + num + str.substr(ind + 1);
        this.image.src = str;
      } else if (this.ttd == 6) {
        var cur_i = obstacles_arr.indexOf(this);
        obstacles_arr.splice(cur_i, 1);
      }
    }
    ctx.save();
    ctx.translate(this.x, this.y);
    ctx.rotate(this.angle * Math.PI / 180);
    ctx.drawImage(this.image, this.width / -2, this.height / -2, this.width, this.height);
    ctx.restore();
    //draw health line
    ctx.save();
    ctx.translate(this.x, this.y);
    context.beginPath();
    context.moveTo(-this.width/2, this.height/2);
    context.lineTo(this.width/2, this.height/2);
    context.lineWidth = 10;
    context.strokeStyle="#FFFFFF"
    context.stroke();
    context.beginPath();
    context.moveTo(-this.width/2, this.height/2);
    context.lineTo(-this.width/2+(this.width*this.health/this.health_i), this.height/2);
    context.lineWidth = 10;
    context.strokeStyle="#FF0000"
    context.stroke();
    ctx.restore();
  }

  newPosb() {
    this.x += this.dir + MY_BACKGROUND.offset_x + MY_BACKGROUND.offset_x;
    this.y += this.speed + MY_BACKGROUND.offset_y;
    this.angle += this.angle_chg;
    if (this.angle == 360) this.angle = 0;
  }

  crashWith(otherobj) {
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
    } else {
      return true;
    }
  }
}

function InitializeWeapons(){
  var types = [];
  var names = [];
  var images = [];
  var ranges = [];
  var ammos = [];
  var damages = [];
  var recharges = [];
  for(var i=0;i<5;i++)
  {
    var weapon = document.getElementById("Weapon"+(i+1)+"Parameters");
    if(weapon!=null)
    {
      types.push(     document.getElementById("txtWeapon"+(i+1)+"Type").value);
      names.push(    document.getElementById("txtWeapon"+(i+1)+"Name" ).value);
      images.push(    document.getElementById("txtWeapon"+(i+1)+"Image" ).value+"1.png");
      ranges.push(    Number.parseInt(document.getElementById("txtWeapon"+(i+1)+"RangeOfFire" ).value));
      ammos.push(     Number.parseInt(document.getElementById("txtWeapon"+(i+1)+"Ammunition"  ).value));
      damages.push(   Number.parseInt(document.getElementById("txtWeapon"+(i+1)+"Damage"      ).value));
      recharges.push( Number.parseInt(document.getElementById("txtWeapon"+(i+1)+"RechargeTime").value));
    }else {
      types.push(-1);
      names.push("-1");
      images.push("-1");
      ranges.push(-1);
      ammos.push(-1);
      damages.push(-1);
      recharges.push(-1);
    }
  }
  weapons = new Weapons(types,names,images,damages,ammos,recharges,ranges);

}

function StartGame() {
  SPACESHIP = new Spaceship(50, 50, "", FW / 2, FH / 2);
  var hp_recovery = Number.parseInt(document.getElementById("hp_recovery").value);
  var magnetic_grip_action_radius = Number.parseInt(document.getElementById("magnetic_grip_action_radius").value);
  var magnetic_grip_carrying_capacity = Number.parseInt(document.getElementById("magnetic_grip_carrying_capacity").value);
  if (hp_recovery!=0) {
    //// TODO: make SPACESHIP a class aside background
    SPACESHIP.add_droid(hp_recovery);
  }
  if (magnetic_grip_action_radius!=0) {
    SPACESHIP.add_grip(magnetic_grip_action_radius,magnetic_grip_carrying_capacity);
  }
  InitializeWeapons();
  MY_BACKGROUND = new Background(PIC_W, PIC_H, "images/space.jpg", -PIC_W / 2 + FW / 2, -PIC_H / 2 + FH / 2);
  var obstacles = {
    start: this.interval = setInterval(GenObstacles, 200)
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
      aim1 = new Image();
      aim1.src = "images/aim_1.png";
      var w = aim1.naturalWidth;
      var h = aim1.naturalHeight;
      aim[0] = e.pageX - (w / 2 + LEFT);
      aim[1] = e.pageY - (h / 2 + TOP);
    }
  }, false);
  //handle gamefield click
  myGameArea.canvas.addEventListener('mousedown', function(e) {
    if (!STOP) {
      //send rocket
      var x_from = SPACESHIP.x;
      var x_to = aim[0];
      var y_from = SPACESHIP.y;
      var y_to = aim[1];
      weapons.add_unit(x_from, y_from, x_to, y_to, SPACESHIP.weapon_id);
    }
  }, false);
  myGameArea.start();
}

function UpdateGameArea() {
  //resize canvas
  var w =document.getElementById('game_field').offsetWidth;
  var h =document.getElementById('game_field').offsetHeight;
  document.getElementById('canvas_field').height = h-12;
  document.getElementById('canvas_field').width = w-12;
  FH = Number.parseInt(document.getElementById('canvas_field').height);
  FW = Number.parseInt(document.getElementById('canvas_field').width);
  document.getElementById("helptext").innerHTML = FH.toFixed(1)+"|"+FW.toFixed(1);
  if (!STOP) {
    updateNum++;
    if (updateNum == 100) {
      updateNum = 0;
    }

    // Animation phases
    if (updateNum < 20 && SPACESHIP.stub == 0) {
      SPACESHIP.ship_hull = document.getElementById("ship_hull").value + "1.png";
    }
    if (updateNum >= 20 && updateNum < 40 && SPACESHIP.stub == 0) {
      SPACESHIP.ship_hull = document.getElementById("ship_hull").value + "2.png";
    }
    if (updateNum >= 40 && updateNum < 60 && SPACESHIP.stub == 0) {
      SPACESHIP.ship_hull = document.getElementById("ship_hull").value + "3.png";
    }
    if (updateNum >= 60 && updateNum < 80 && SPACESHIP.stub == 0) {
      SPACESHIP.ship_hull = document.getElementById("ship_hull").value + "4.png";
    }
    if (updateNum >= 80 && updateNum < 100 && SPACESHIP.stub == 0) {
      SPACESHIP.ship_hull = document.getElementById("ship_hull").value + "5.png";
    }
    var draw_grip_radius=false;
    myGameArea.clear();
    MY_BACKGROUND.speedY = 0;
    MY_BACKGROUND.speedX = 0;
    SPACESHIP.moveAngle = 0;
    var maneuverability_tmp = document.getElementById("maneuverability").value;
    var speed_tmp = document.getElementById("speed").value;
    if (myGameArea.keys) {
      var L = myGameArea.keys[65];
      var R = myGameArea.keys[68];
      var F = myGameArea.keys[87];
      var B = myGameArea.keys[83];
      if (myGameArea.keys[49] && weapons.ammos[0]!=-1) {
        SPACESHIP.weapon_id=0;
      }else if(myGameArea.keys[50] && weapons.ammos[1]!=-1) {
        SPACESHIP.weapon_id=1;
      }else if (myGameArea.keys[51] && weapons.ammos[2]!=-1) {
        SPACESHIP.weapon_id=2;
      }else if(myGameArea.keys[52] && weapons.ammos[3]!=-1){
        SPACESHIP.weapon_id=3;
      }else if(myGameArea.keys[53] && weapons.ammos[4]!=-1){
        SPACESHIP.weapon_id=4;
      }
      if(myGameArea.keys[16] && SPACESHIP.hasgrip)//shift
      {
        draw_grip_radius=true;
        var tmp_drops_array = [];
          drops_arr.forEach(function(item,id,arr){
            var path_to_drop = Math.sqrt(Math.pow(SPACESHIP.x - item.x,2)+Math.pow(SPACESHIP.y - item.y,2));
            if(path_to_drop<4*SPACESHIP.grip_radius)
              {
                //alert("1");
                var dx =(SPACESHIP.x - item.x)/30;
                var dy =(SPACESHIP.y - item.y)/30;
                item.x+=dx;
                item.y+=dy;
                //alert(dx+"|"+dy);
                /*if(item.type=="fuel")
                {
                  if(SPACESHIP.fuel<=SPACESHIP.fuel_i){
                    if(SPACESHIP.fuel+item.value>SPACESHIP.fuel_i)SPACESHIP.fuel=SPACESHIP.fuel_i;
                    else SPACESHIP.fuel+=item.value;
                  }
                }else if(item.type=="bullets")
                  {
                    var arr = ["rocket","blaster","laser"];
                    var weapon_id = SPACESHIP.weapon_id;
                    weapons.ammos[weapon_id]+=item.value;
                  }*/
                //tmp_drops_array.push(id);
              }
          });
        tmp_drops_array.forEach(function(item,id,arr){
          drops_arr.splice(item,1);
        });
      }
      if (L || F || R || B) {

        var cos_angle = Math.cos(SPACESHIP.angle);
        var sin_angle = Math.sin(SPACESHIP.angle);
        if (L) SPACESHIP.moveAngle = -1 * (maneuverability_tmp);
        if (R) SPACESHIP.moveAngle = maneuverability_tmp;
        if (F || B) {
          var dir = 1;
          if (B) dir = -1;
          MY_BACKGROUND.speedX = -1 * dir * speed_tmp * sin_angle;
          MY_BACKGROUND.speedY = dir * speed_tmp * cos_angle;
        }
      }
    }

    MY_BACKGROUND.newPosb();
    MY_BACKGROUND.updateb();
    //weapon unit is needed to be drawn before SPACESHIP to be under it in canvas
    weapons.trydraw();
    SPACESHIP.newPos();
    SPACESHIP.update();
    SPACESHIP.updateAnimation();
    //stub for not decreasing health very fast
    if (SPACESHIP.stub != 0) {
      if (SPACESHIP.stub % 5 == 0)
        SPACESHIP.ship_hull = document.getElementById("ship_hull").value + "1.png"
      if (SPACESHIP.stub % 10 == 0)
        SPACESHIP.ship_hull = "images/Hulls/transparent_stub.png"
      SPACESHIP.stub++;
    }
    if (SPACESHIP.stub > 60)
      SPACESHIP.stub = 0;
    var obstacle_crashed = -1;
    var obstacle_out_of_field = -1;
    for (var i = 0; i < obstacles_arr.length; i++) {
      if (obstacles_arr[i].crashWith(SPACESHIP)) {
        if (SPACESHIP.stub == 0) {
          //// TODO: audio for diff meteors
          //
          obstacle_crashed = i;
          var audio = new Audio('audio/auch.mp3');
          audio.play();
          if (obstacles_arr[i].image.src.indexOf("meteor_1") != -1) {
            SPACESHIP.health -= 30;
            POINTS += 5;
          }
          if (obstacles_arr[i].image.src.indexOf("meteor_2") != -1) {
            SPACESHIP.health -= 60;
            POINTS += 10;
          }
          if (obstacles_arr[i].image.src.indexOf("meteor_3") != -1) {
            SPACESHIP.health -= 90;
            POINTS += 20;
          }
          if (SPACESHIP.health <= 0)
            alert("Sorry, dude, but you are dead");
          if (SPACESHIP.health <= 0)
            STOP = true;
          SPACESHIP.stub++;
        }
      }
      //check if obstacle out of field
      if (
        obstacles_arr[i].x < MY_BACKGROUND.x ||
        obstacles_arr[i].y < MY_BACKGROUND.y ||
        obstacles_arr[i].x > (MY_BACKGROUND.x + PIC_W) ||
        obstacles_arr[i].y > (MY_BACKGROUND.y + PIC_H)
      ) obstacle_out_of_field = i;
      //update
      obstacles_arr[i].updates();
      obstacles_arr[i].newPosb();
    }
    //delete one out of field if there is
    if (obstacle_out_of_field != -1) {
      obstacles_arr.splice(obstacle_out_of_field, 1);
    }
    //update health html
    var h = document.querySelector('.js2');
    var percent = Number((SPACESHIP.health / SPACESHIP.health_i * 100).toFixed(0));
    h.style.setProperty('--hp-v', "" + percent + "%");
    document.getElementById("percent2").innerHTML = percent + "%";
    if (obstacle_crashed != -1) {
      obstacles_arr[obstacle_crashed].image.src = "images/Obstacles/output-0.png";
    }
    DrawWarFog();
    var drop_del=-1;
    for (var i = 0; i < drops_arr.length; i++) {
      if(drops_arr[i].draw())drop_del=i;
    }
    if(drop_del!=-1)drops_arr.splice(drop_del,1);
    //update recharges times for guns
    weapons.cur_recharges.forEach(function(recharge, id, arr)
    {
      if(weapons.cur_recharges[id]>0)
        {
          var tmp = weapons.cur_recharges[id];
          tmp-=0.1;
          tmp = tmp.toFixed(1);
          weapons.cur_recharges[id]=tmp;
        }
    });
  }
  if(draw_grip_radius){
      var ctx = myGameArea.context;
      ctx.beginPath();
      ctx.arc(SPACESHIP.x,SPACESHIP.y,4*SPACESHIP.grip_radius,0,2*Math.PI);
      ctx.strokeStyle="yellow";
      ctx.lineWidth=3;
      ctx.stroke();
      ctx.beginPath();
      ctx.arc(SPACESHIP.x,SPACESHIP.y,4*SPACESHIP.grip_radius-2,0,2*Math.PI);
      ctx.strokeStyle="red";
      ctx.lineWidth=4;
      ctx.stroke();
      ctx.beginPath();
      ctx.arc(SPACESHIP.x,SPACESHIP.y,4*SPACESHIP.grip_radius-3,0,2*Math.PI);
      ctx.strokeStyle="green";
      ctx.lineWidth=5;
      ctx.stroke();
  }
    //draw gun name
    context = myGameArea.context;
    context.beginPath();
    context.fillStyle = "#b8d1d1";
    context.font = "15px Arial";
    context.fillText("Weapon: " +weapons.names[SPACESHIP.weapon_id]+" ["+weapons.ammos[SPACESHIP.weapon_id] + "]", 5, FH-120);
    //draw gun image
    context.beginPath();
    var weapon_img = new Image();
    weapon_img.src = weapons.images[SPACESHIP.weapon_id];
    var w = weapon_img.naturalWidth;
    var h = weapon_img.naturalHeight;
    context.drawImage(weapon_img, 15, FH-100, w, h);
    //draw space
    context.save();
    var x_minimap=5;
    var y_minimap=30;
    var w_minimap = 50;
    var h_minimap = 50;//100
    //left
    context.beginPath();
    context.moveTo(5, y_minimap+h_minimap);
    context.lineWidth=5;
    context.globalAlpha=0.3;
    context.strokeStyle = '#ff0000';
    if(MY_BACKGROUND.left)
    {
      context.lineWidth=10;
      context.globalAlpha=1;
      context.strokeStyle = 'yellow';
    }
    context.lineTo(x_minimap, y_minimap);//50
    context.stroke();
    context.restore();
    //top

    context.save();
    context.beginPath();
    context.moveTo(x_minimap, y_minimap);
    context.lineWidth=5;
    context.globalAlpha=0.3;
    context.strokeStyle = '#ff0000';
    if(MY_BACKGROUND.up)
    {
      context.lineWidth=10;
      context.globalAlpha=1;
      context.strokeStyle = 'yellow';
    }
    context.lineTo(x_minimap+w_minimap, y_minimap);//50
    context.stroke();
    context.restore();
    //right
    context.save();
    context.beginPath();
    context.moveTo(x_minimap+w_minimap, y_minimap);
    context.lineWidth=5;
    context.globalAlpha=0.3;
    context.strokeStyle = '#ff0000';
    if(MY_BACKGROUND.right)
    {
      context.lineWidth=10;
      context.globalAlpha=1;
      context.strokeStyle = 'yellow';
    }
    context.lineTo(x_minimap+w_minimap, y_minimap+h_minimap);//100
    context.stroke();
    context.restore();
    //down
    context.save();
    context.beginPath();
    context.moveTo(x_minimap+w_minimap, y_minimap+h_minimap);
    context.lineWidth=5;
    context.globalAlpha=0.3;
    context.strokeStyle = '#ff0000';
    if(MY_BACKGROUND.down)
    {
      context.lineWidth=10;
      context.globalAlpha=1;
      context.strokeStyle = 'yellow';
    }
    context.lineTo(x_minimap, y_minimap+h_minimap);
    context.stroke();
    context.restore();
    DrawAim();
    DrawHpAndFuel();
}

function DrawAim() {
  var ctx = myGameArea.context;
  var aim1 = new Image();
  aim1.src = "images/aim_1.png";
  var w = aim1.naturalWidth;
  var h = aim1.naturalHeight;
  ctx.drawImage(aim1,
    aim[0],
    aim[1],
    w, h);
}

function DrawWarFog() {
  context = myGameArea.context;
  var x = SPACESHIP.x;
  var y = SPACESHIP.y;
  var oradius=200;
  if(document.getElementById("radar_action_radius").value!=0 )
  oradius+= Number.parseInt(document.getElementById("radar_action_radius").value,10); //800 good vision, 500 - middle, <300 - bad
  var radius = oradius/2; //inner
  context.beginPath();
  context.arc(x, y, oradius, 0, 2 * Math.PI, false);
  var grd = context.createRadialGradient(x, y, radius, x, y, oradius);
  grd.addColorStop(0, 'transparent');
  grd.addColorStop(1, '#030312');
  context.fillStyle = grd;
  context.fill();
  context.beginPath();
  context.arc(x, y, Math.sqrt(Math.pow(FH / 2, 2) + Math.pow(FW / 2, 2)), 0, 2 * Math.PI, false);
  context.lineWidth = (Math.sqrt(Math.pow(FH / 2, 2) + Math.pow(FW / 2, 2)) - oradius) * 2;
  context.strokeStyle = '#030312';
  context.stroke();
  context.beginPath();
  context.fillStyle = "yellow";
  context.font = "20px Arial";
  context.fillText("POINTS: " + POINTS, 0, 20);
}

function DrawHpAndFuel(){
  var y = 150;
  var x = 5;
  var max_w=200-x;
  var ctx = myGameArea.context;
  ctx.beginPath();
  ctx.save();
  context.fillStyle = "#b8d1d1";
  context.font = "10px Arial";
  context.fillText("HP: "+SPACESHIP.health+"/"+SPACESHIP.health_i, x, y-10);
  ctx.restore();

  ctx.beginPath();
  ctx.save();
  ctx.moveTo(x,y);
  ctx.lineTo(x+max_w, y);
  ctx.lineWidth = 10;
  ctx.strokeStyle="white"
  ctx.stroke();

  ctx.beginPath();
  ctx.save();
  ctx.moveTo(x,y);
  ctx.lineTo(x+max_w*SPACESHIP.health/SPACESHIP.health_i, y);
  ctx.lineWidth = 10;
  ctx.strokeStyle="red"
  ctx.stroke();

  //FUEL
  ctx.beginPath();
  ctx.save();
  context.fillStyle = "#b8d1d1";
  context.font = "10px Arial";
  context.fillText("FUEL: "+SPACESHIP.fuel.toFixed(0)+"/"+SPACESHIP.fuel_i, x, y+40);
  ctx.restore();

  ctx.beginPath();
  ctx.moveTo(x,y+50);
  ctx.lineTo(x+max_w, y+50);
  ctx.lineWidth = 10;
  ctx.strokeStyle="white"
  ctx.stroke();
  ctx.restore();

  ctx.beginPath();
  ctx.moveTo(x,y+50);
  ctx.lineTo(x+max_w*SPACESHIP.fuel/SPACESHIP.fuel_i, y+50);
  ctx.lineWidth = 10;
  ctx.strokeStyle="green"
  ctx.stroke();
  ctx.restore();

}
function GenObstacles() {
  if (!STOP) {
    var o_num = obstacles_arr.length % 3;
    switch (o_num) {
      case 0:
        obstacles_arr.push(new Obstacle(80, 80, "images/Obstacles/meteor_1.png", gMR(0), gMR(1), gR(-5, 5), gR(-5, 5), gR(-5, 5)));
        break;
      case 1:
        obstacles_arr.push(new Obstacle(100, 100, "images/Obstacles/meteor_2.png", gMR(0), gMR(1), gR(-5, 15), gR(-5, 5), gR(-4, 4)));
        break;
      case 2:
        obstacles_arr.push(new Obstacle(150, 150, "images/Obstacles/meteor_3.png", gMR(0), gMR(1), gR(-15, 5), gR(-5, 5), gR(-3, 3)));
        break;
    }
  }
}

function gR(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

function gMR(trigger){
  var re;
  if (trigger == 0) {
    ret = gR(-400, FW + 400);
    if (ret >= 0 && ret <= FW) {
      if (gR(0, 1) == 0) ret += FW;
      else ret -= FW;
    }
  } else if (trigger == 1) {
    ret = gR(-500, FH + 500);
    if (ret >= 0 && ret <= FH) {
      if (gR(0, 1) == 0) ret -= FH;
      else ret -= FH;
    }
  }
  return ret;
}
