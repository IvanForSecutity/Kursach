var myGamePiece;
var myBackground;
var FH = 500;
var FW = 500;
var speed_x;
var speed_y;
var obstacles_arr = [];
var updateNum=0;

var S_x=0;
var S_y=0;
var offset_x=0;
var offset_y=0;
var PIC_H = 9000;
var PIC_W = 3000;
var ship_x =0;
var ship_hull = "";
var ship_y =0;

function startGame()
{
    ship_hull = document.getElementById("ship_hull").value + "1.png";


    
    //create spaceship element
    myGamePiece = new component(30, 50, ship_hull, FW/2, FH/2, "image");
    myBackground = new component(PIC_W, PIC_H, "images/space.png", 0-PIC_W/2-FW/2, 0-PIC_H+FW, "image");
    myGameArea.start();
	var obstacles = {start: this.interval = setInterval(gen_obstacles, 200)};
	
}
var myGameArea = {
    canvas: document.createElement("canvas"),
    start: function () {
        this.canvas.width = FW;
        this.canvas.height = FH;
		this.canvas.addEventListener('mousemove', function(e) {
			ctx = myGameArea.context;
			var docElem = document.getElementById("gamediv");
			var rect = docElem.getBoundingClientRect();

			document.getElementById("x").value = e.clientY;
			document.getElementById("y").value = e.pageY;
			send_rocket(0,0,e.pageX,e.pageY);
		}, false);
		
        this.context = this.canvas.getContext("2d");
        document.body.insertBefore(this.canvas, document.body.childNodes[0]);
        this.frameNo = 0;
        this.interval = setInterval(updateGameArea, 20);
        window.addEventListener('keydown', function (e) {
            myGameArea.keys = (myGameArea.keys || []);
            myGameArea.keys[e.keyCode] = true;
        })
        window.addEventListener('keyup', function (e) {
            myGameArea.keys[e.keyCode] = false;
        })
        
    },
    clear: function () {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    },
    stop: function () {
        clearInterval(this.interval);
    }
}
var rockets=0;
function send_rocket(from_x,from_y,to_x,to_y)
{
	
	//rockets++;
	
	//if(rockets==100)
	{
		
		ctx = myGameArea.context;
		var sticky = new Image();
		sticky.src = "images/aim_1.png";
		ctx.drawImage(sticky,
					to_x,
					to_y,
					90, 90);	
	}
}
function component(width, height, img, x, y, type) {
    this.type = type;
    if (type == "image") {
        this.image = new Image();
        this.image.src = img;
    }
    this.width = width;
    this.height = height;
    this.speedX = 0;
    this.speedY = 0;
    this.x = x;
    this.y = y;
    this.angle = 0;
    this.A = 0;
    this.moveAngle = 0;
    this.update = function () {
        ctx = myGameArea.context;
        ctx.save();
        ctx.translate(this.x, this.y);
        ctx.rotate(this.angle);
        
        ctx.drawImage(this.image, this.width / -2, this.height / -2, this.width, this.height)
        ctx.restore();
    }
	
    this.updateb = function () {
        ctx = myGameArea.context;
        ctx.drawImage(this.image,
                this.x,
                this.y,
                this.width, this.height);
    }
    this.newPos = function () {
        this.angle += this.moveAngle * Math.PI / 180;
		this.A += this.moveAngle ;
        this.x += this.speedX;
        this.y += this.speedY;
		ship_x = this.x;
		ship_y = this.y;
    }
    this.newPosb = function () {
		//document.getElementById("speed").value = offset_x;
		offset_x += this.speedX;
		offset_y = this.speedY;
        this.x += this.speedX;
        this.y += this.speedY;
        this.y +=0.3;
		S_y = this.y;
		S_x = this.x;
    }
    this.updateAnimation = function()
    {
        this.image.src = ship_hull;
    }
}
function obstacle(w,h,img, x, y) {
    this.image = new Image();
    this.image.src = img;
    this.width = w;
    this.height = h;
    this.speedX = 0;
    this.speedY = 0;
    this.x = x;
	this.init = x;
    this.y = y;
	this.updates = function () {
        ctx = myGameArea.context;
		ctx.drawImage(this.image,
                this.x,
                this.y,
                this.width, this.height);	
    }
	
    this.newPosb = function () {
        this.x = this.init+offset_x;
        this.y += 5+offset_y;
		
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
function updateGameArea()
{
    updateNum++;
    if (updateNum == 100)
    {
        updateNum = 0;
    }
    
    // Animation phases
    if (updateNum < 20)
    {
        ship_hull = document.getElementById("ship_hull").value + "1.png";
    }
    if (updateNum >= 20 && updateNum < 40)
    {
        ship_hull = document.getElementById("ship_hull").value + "2.png";
    }
    if (updateNum >= 40 && updateNum < 60)
    {
        ship_hull = document.getElementById("ship_hull").value + "3.png";
    }
    if (updateNum >= 60 && updateNum < 80)
    {
        ship_hull = document.getElementById("ship_hull").value + "4.png";
    }
    if (updateNum >= 80 && updateNum < 100)
    {
        ship_hull = document.getElementById("ship_hull").value + "5.png";
    }
    
    myGameArea.clear();
    myBackground.speedY = 0; 
    myBackground.speedX = 0; 
    myGamePiece.moveAngle = 0;
    var maneuverability_tmp = document.getElementById("maneuverability").value; 
    var speed_tmp = document.getElementById("speed").value;
	if(myGameArea.keys)
	{
		var L = myGameArea.keys  [37];
		var R = myGameArea.keys  [39];
		var F = myGameArea.keys  [38];
		var B = myGameArea.keys  [40];
		
		if(L||F||R||B)
		{
			
			var cos_angle = Math.cos(myGamePiece.angle);
			var sin_angle = Math.sin(myGamePiece.angle);
			if(L)	myGamePiece.moveAngle = -1*(maneuverability_tmp);
			if(R)	myGamePiece.moveAngle = maneuverability_tmp;
			if(F||B)
			{
				var dir=1;
				if(B)dir=-1;
				myBackground.speedX = -1*	dir*speed_tmp*sin_angle;
				myBackground.speedY = 		dir*speed_tmp*cos_angle;
			}
			
		}
		
	}
	
    myBackground.newPosb();
    myBackground.updateb();
    myGamePiece.newPos();
    myGamePiece.update();
    myGamePiece.updateAnimation();
	for (var i = 0; i < obstacles_arr.length; i++)
	{
		if(obstacles_arr[i].crashWith(myGamePiece))
		{
			
			myGameArea.stop();
		}
		obstacles_arr[i].updates();
		obstacles_arr[i].newPosb();
	}
}

function gen_obstacles()
{
	var o_num = obstacles_arr.length%3;
	switch(o_num)
	{
		case 0:
			obstacles_arr.push(new obstacle(80,80,"images/meteor_1.png", S_x + gR(0,PIC_W), S_y + gR(0,1000)));
			break;
		case 1:
			obstacles_arr.push(new obstacle(100,100,"images/meteor_2.png", S_x + gR(0,PIC_W), S_y + gR(0,1000)));
			break;
		case 2:
			obstacles_arr.push(new obstacle(150,150,"images/meteor_3.png", S_x + gR(0,PIC_W), S_y + gR(0,1000)));
			break;
		
	}
	
	
}
function gR(min, max)
{
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
function getOffset(elem) {
    if (elem.getBoundingClientRect) {
        // "правильный" вариант
        return getOffsetRect(elem)
    } else {
        // пусть работает хоть как-то
        return getOffsetSum(elem)
    }
}

function getOffsetSum(elem) {
    var top=0, left=0
    while(elem) {
        top = top + parseInt(elem.offsetTop)
        left = left + parseInt(elem.offsetLeft)
        elem = elem.offsetParent
    }

    return {top: top, left: left}
}

function getOffsetRect(elem) {
    // (1)
    var box = elem.getBoundingClientRect()

    // (2)
    var body = document.body
    var docElem = document.documentElement

    // (3)
    var scrollTop = window.pageYOffset || docElem.scrollTop || body.scrollTop
    var scrollLeft = window.pageXOffset || docElem.scrollLeft || body.scrollLeft

    // (4)
    var clientTop = docElem.clientTop || body.clientTop || 0
    var clientLeft = docElem.clientLeft || body.clientLeft || 0

    // (5)
    var top  = box.top +  scrollTop - clientTop
    var left = box.left + scrollLeft - clientLeft

    return { top: Math.round(top), left: Math.round(left) }
}
