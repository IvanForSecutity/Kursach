var RedSquare;
var backgroundstars = [];
var WIDTH = 1000, HEIGHT = 500;
var updateNum = 0;
function startGame() {

    RedSquare = new component(60, 60, "red", WIDTH / 2, HEIGHT - 30);
    myGameArea.start();
}

var myGameArea = {
    canvas: document.createElement("canvas"),
    start: function () {
        this.canvas.width = WIDTH;
        this.canvas.height = HEIGHT;
        this.context = this.canvas.getContext("2d");
        document.body.insertBefore(this.canvas, document.body.childNodes[0]);
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

    }
}



function component(width, height, color, x, y) {
    this.width = width;
    this.height = height;
    this.x = x;
    this.y = y;
    this.angle = 0;
    this.moveAngle = 0;
    this.newPos = function () {
        this.angle += this.moveAngle * Math.PI / 180;
        this.x += this.speed * Math.sin(this.angle);
        this.y -= this.speed * Math.cos(this.angle);
    }
    this.update = function () {
        ctx = myGameArea.context;
        ctx.save();
        ctx.translate(this.x, this.y);
        ctx.rotate(this.angle);
        var img = new Image();
        if (updateNum < 20)
        {
            img.src = document.getElementById("ship_hull").value;
        }
        if (updateNum < 40 && updateNum > 20)
        {
            img.src = document.getElementById("ship_hull_2").value;
        }
        if (updateNum > 40)
        {
            img.src = document.getElementById("ship_hull_3").value;
        }
        ctx.drawImage(img, this.width / -2, this.height / -2, this.width, this.height)
        ctx.restore();

    }
    this.updates = function (some) {
        ctx = myGameArea.context;
        ctx.fillStyle = color;
        this.y += some;
        ctx.fillRect(this.x, this.y, this.width, this.height);
    }
}

function updateGameArea() {
    updateNum++;
    myGameArea.clear();
    RedSquare.speed = 0;
    RedSquare.speed = 0;
    RedSquare.moveAngle = 0;
    var speed_tmp = 2;
    var angle_tmp = 1;
    if (document.getElementById("speed").value) speed_tmp = document.getElementById("speed").value;
    if (document.getElementById("angles").value) angle_tmp = document.getElementById("angles").value;
    if (myGameArea.keys && myGameArea.keys  [37]) {
        RedSquare.moveAngle = -1*(angle_tmp);
    }
    if (myGameArea.keys && myGameArea.keys  [39]) {
        RedSquare.moveAngle = angle_tmp;
    }
    if (myGameArea.keys && myGameArea.keys  [38]) {
        RedSquare.speed = speed_tmp;
    }
    if (myGameArea.keys && myGameArea.keys  [40]) {
        RedSquare.speed = -1*(speed_tmp);
    }
    RedSquare.newPos();
    RedSquare.update();
    if (updateNum % 5 == 0)
    {
        if (updateNum == 60)
            updateNum = 0;
        backgroundstars.push(new component(3, 3, "white", gR(0, 1000), 0));

    }
    for (var i = 0; i < backgroundstars.length; i++)
    {
        backgroundstars[i].updates(1);
    }

}

function gR(min, max)
{
    return Math.floor(Math.random() * (max - min + 1)) + min;
}