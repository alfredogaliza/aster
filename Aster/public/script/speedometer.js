function drawSpeedometer(rate){
	var canvas = document.getElementById('speedometer');
	var ctx = canvas.getContext("2d");
	
	var w = canvas.width;
	var h = canvas.height;	
	
	var cX = w/2;
	var cY = h;
	var R =  h-10;
	
	var ticks = 20;
	
	// Cria um preenchimento gradiente
	grad = ctx.createLinearGradient(0,0,w,h);
	grad.addColorStop(0, 'gray');
	grad.addColorStop(.5, 'white');
	grad.addColorStop(1, 'gray');	
	
	// Desenhar a base
	ctx.fillStyle = "black";
	ctx.strokeStyle = grad;
	ctx.lineWidth = 10;	
	ctx.beginPath();	
	ctx.arc(cX, cY, R, Math.PI, 0);
	ctx.closePath();
	ctx.stroke();
	ctx.fill();
		
	ctx.fillStyle = "#80FF80";
	ctx.beginPath();
	ctx.moveTo(cX, cY);
	ctx.arc(cX, cY, R, Math.PI, Math.PI * 1.3);
	ctx.closePath();
	ctx.fill();
	
	ctx.fillStyle = "#FFFF80";
	ctx.beginPath();
	ctx.moveTo(cX, cY);
	ctx.arc(cX, cY, R, Math.PI * 1.3, Math.PI * 1.7);
	ctx.closePath();
	ctx.fill();
	
	ctx.fillStyle = "#FF8080";
	ctx.beginPath();
	ctx.moveTo(cX, cY);
	ctx.arc(cX, cY, R, Math.PI * 1.7, Math.PI * 2);
	ctx.closePath();
	ctx.fill();
	
	
	
	// Desenhar os marcadores
	var r = R - 20;	
	ctx.lineWidth = 1;
	ctx.strokeStyle = 'black';
	ctx.fillStyle = 'black';
	ctx.font = "12px Arial";
	
	for (i = 0; i <= ticks; i++) {
		angle = Math.PI * (1 - i / ticks);
		x0 = cX + Math.cos(angle) * r;
		y0 = cY - Math.sin(angle) * r;
		x1 = cX + Math.cos(angle) * (r-15);
		y1 = cY - Math.sin(angle) * (r-15);

		txt = Math.round(i * 100 / ticks);	
		ctx.fillText( txt, x0 - ctx.measureText(txt).width/2 , y0-2);
				
		ctx.beginPath();
		ctx.moveTo(x0, y0);
		ctx.lineTo(x1, y1);
		ctx.stroke();		
	}
	
	// Desenhar a agulha e a base
	angle = Math.PI * (1-rate);
	
	x0 = cX + Math.cos(angle-Math.PI/2) * 10;
	y0 = cY - Math.sin(angle-Math.PI/2) * 10;
	x1 = cX + Math.cos(angle) * (r-20);
	y1 = cY - Math.sin(angle) * (r-20);	
	x2 = cX + Math.cos(angle+Math.PI/2) * 10;
	y2 = cY - Math.sin(angle+Math.PI/2) * 10;	
	
	ctx.fillStyle = "orange";
	ctx.beginPath();
	ctx.moveTo(cX, cY);
	ctx.lineTo(x0,y0);
	ctx.lineTo(x1,y1);
	ctx.lineTo(x2,y2);
	ctx.closePath();
	ctx.fill();
	
	ctx.fillStyle = grad;	
	ctx.beginPath();	
	ctx.arc(cX, cY, 40, Math.PI, 0);
	ctx.closePath();
	ctx.fill();
	
	txt = Math.round(rate*100)+"%";
	ctx.font = "italic bold 14px arial";
	ctx.fillStyle = "black";
	ctx.fillText(txt, cX - ctx.measureText(txt).width/2, cY-5);
	
}