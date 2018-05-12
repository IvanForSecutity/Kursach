var myGamePiece;
var myBackground;
var FH = 270;
var FW = 480;
var speed_x;
var speed_y;
var updateNum=0;
var backgroundstars = [];
var S_x=0;
var S_y=0;

function startGame() {
    //create spaceship element
    myGamePiece = new component(30, 30, "images/spaceship.png", FW/2, FH/2, "image");
    myBackground = new component(3000, 9000, "images/space.png", -1500-FW/2, -8730, "image");
    myGameArea.start();
}

var myGameArea = {
    canvas: document.createElement("canvas"),
    start: function () {
        this.canvas.width = 480;
        this.canvas.height = 270;
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
	this.updates = function () {
        ctx = myGameArea.context;
		ctx.drawImage(this.image,
                this.x,
                this.y,
                this.width, this.height);
		
				
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
		S_x = this.x;
		S_y = this.y;
    }
    this.newPosb = function () {
        this.x += this.speedX;
        this.y += this.speedY;
        this.y +=0.3;
    }
}
function obstacle(img, x, y) {
    this.image = new Image();
    this.image.src = img;
    this.width = 53;
    this.height = 53;
    this.speedX = 0;
    this.speedY = 0;
    this.x = x;
    this.y = y;
	this.updates = function () {
        ctx = myGameArea.context;
		ctx.drawImage(this.image,
                this.x,
                this.y,
                this.width, this.height);	
				
    }
	
    this.newPosb = function () {
        this.x += 0;
        this.y += -1;
		
    }
}

//every 20 miliseconds
function updateGameArea() {
    myGameArea.clear();
    myBackground.speedY = 0; 
    myBackground.speedX = 0; 

    myGamePiece.moveAngle = 0;
    var angle_tmp = 5;  
    var speed_tmp = 10;

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
			if(L)	myGamePiece.moveAngle = -1*(angle_tmp);
			if(R)	myGamePiece.moveAngle = angle_tmp;
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
		document.getElementById("angles").value = 90;
	backgroundstars.push(new obstacle("images/spaceship.png", S_x, S_y));
	for (var i = 0; i < backgroundstars.length; i++)
	{
		
		backgroundstars[i].newPosb();
			
	}
	
}

function gR(min, max)
{
    return Math.floor(Math.random() * (max - min + 1)) + min;
}