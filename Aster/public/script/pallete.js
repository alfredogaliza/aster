function hslToRgb(hsl){
    var r, g, b;
    var h = hsl[0], s = hsl[1], l = hsl[2];

    if(s == 0){
        r = g = b = l; // achromatic
    }else{
        var hue2rgb = function hue2rgb(p, q, t){
            if(t < 0) t += 1;
            if(t > 1) t -= 1;
            if(t < 1/6) return p + (q - p) * 6 * t;
            if(t < 3/6) return q;
            if(t < 4/6) return p + (q - p) * (2/3 - t) * 6;
            return p;
        }

        var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
        var p = 2 * l - q;
        r = hue2rgb(p, q, h + 1/3);
        g = hue2rgb(p, q, h);
        b = hue2rgb(p, q, h - 1/3);
    }

    return [Math.round(r * 255), Math.round(g * 255), Math.round(b * 255)];
}

function rgbToHsl(rgb){
    var r = rgb[0]/255, g = rgb[1]/255, b = rgb[2]/255;
    var max = Math.max(r, g, b), min = Math.min(r, g, b);
    var h, s, l = (max + min) / 2;

    if(max == min){
        h = s = 0; // achromatic
    }else{
        var d = max - min;
        s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
        switch(max){
            case r: h = (g - b) / d + (g < b ? 6 : 0); break;
            case g: h = (b - r) / d + 2; break;
            case b: h = (r - g) / d + 4; break;
        }
        h /= 6;
    }

    return [h, s, l];
}

function hextoRgb(rgb){
	regex = /\#?([A-F0-9]{2})([A-F0-9]{2})([A-F0-9]{2})/i;
	return regex.exec(rgb).slice(1);	
}

function rgbToHex(rgb){
	var hex = "";
	rgb.forEach(function(component){
		i = component > 15 ? component.toString(16) : "0" + component.toString(16);
		hex += i;
	});
	return hex;
}

$.fn.pallete = function(options){
	
	// Opções do módulo
	this.options = $.extend(
			{
				hSteps: 32,
				sSteps: 8
			}, options);
	
	// Canvas
	this.canvas = this.get(0);
	this.ctx = this.canvas.getContext("2d");
	
	// Cores Selecionadas
	this.colors = [[255,0,0],[0,255,0],[0,0,255]];
	
	// Variáveis das caixas seletoras 
	this.r = 1;
	this.g = 0;
	this.b = 0;
	
	this.h = 0;
	this.s = 1;
	this.l = 0.5;
	
	this.cx = Math.round(this.canvas.height * 0.3);
	this.cy = Math.round(this.canvas.height * 0.3);
	
	this.drawCircle = function(){
		
		var tau = 2 * Math.PI;
		var h = 0, m = 1 / this.options.hSteps;
		var s = 0, n = 1 / (this.options.sSteps-1);
		var q = (this.options.sSteps-1)/this.options.sSteps;
		
		var cx = this.cx;
		var cy = this.cy;
		
		var R = Math.min(cx, cy) ;
		var r = R * 0.25;
		
		for (h = 0; h < 1; h = h + m){
			for (s = 0; s <= 1; s = s + n){
				
				var x0 = cx + (r + s*(R-r)*q) * Math.cos(tau*(h));
				var y0 = cy - (r + s*(R-r)*q) * Math.sin(tau*(h));
				
				var x1 = cx + (r + (s+n)*(R-r)*q) * Math.cos(tau*(h));
				var y1 = cy - (r + (s+n)*(R-r)*q) * Math.sin(tau*(h));
				
				var x2 = cx + (r + (s+n)*(R-r)*q) * Math.cos(tau*(h+m));
				var y2 = cy - (r + (s+n)*(R-r)*q) * Math.sin(tau*(h+m));
				
				var x3 = cx + (r + s*(R-r)*q) * Math.cos(tau*(h+m));
				var y3 = cy - (r + s*(R-r)*q) * Math.sin(tau*(h+m));
				
				var color = rgbToHex(hslToRgb([h, s, this.l])).toUpperCase();			
				this.ctx.fillStyle = "#"+color;
				this.ctx.strokeStyle = "#"+color;
				this.ctx.beginPath();
				this.ctx.moveTo(x0,y0);
				this.ctx.lineTo(x1,y1);
				this.ctx.lineTo(x2,y2);
				this.ctx.lineTo(x3,y3);
				this.ctx.closePath();
				this.ctx.stroke();
				this.ctx.fill();
			}
		}		
	}
	
	this.drawColors = function(){
		
		var canvas = this.canvas;
		var ctx = this.ctx;
		
		this.colors.forEach(function(rgb, index, array){			
			var w = (canvas.width  * 0.90) / array.length ;
			var h = (canvas.height * 0.30);
			var x = (canvas.width  * 0.05) + (index * w);
			var y = (canvas.height * 0.65);
			
			color = "#"+rgbToHex(rgb);
			ctx.fillStyle = color;
			ctx.fillRect(x, y, w, h);
						
			size = w * 0.10;
			ctx.fillStyle = "black";
			ctx.font = size + "px Arial";			
			ctx.fillText(color, x + w/2 - ctx.measureText(color).width/2, y+h+size);			
		});
	}
	
	this.drawSelectors = function(){
		var ctx = this.ctx;
		
		var tau = 2 * Math.PI;
		var m = 1 / this.options.hSteps;
		var n = 1 / (this.options.sSteps-1);
		var q = (this.options.sSteps-1)/this.options.sSteps;
		
		var cx = this.cx;
		var cy = this.cy;
		
		var R = Math.min(cx, cy) ;
		var r = R * 0.25;
		
		this.colors.forEach(function(rgb, index){
			hsl = rgbToHsl(rgb);
			var h = hsl[0], s = hsl[1];
			
			ctx.lineWidth = (index == 1)? 4 : 1;
			
			var x = cx + (r + (2*s+n)/2*(R-r)*q) * Math.cos(tau*((2*h+n)/2));
			var y = cy - (r + (2*s+n)/2*(R-r)*q) * Math.sin(tau*((2*h+n)/2));
			var .
			
			ctx.fillStyle = "#"+rgbToHex(rgb);
			ctx.beginPath();
			ctx.arc();
		});
		
	}
	
	this.draw = function(){ 
		this.drawCircle();
		this.drawColors();
		this.drawSelectors();
		//this.drawLuminosity();
		//this.drawPallete();
	}
	
	//Desenhar a Interface
	this.draw();
	
	
	
};
