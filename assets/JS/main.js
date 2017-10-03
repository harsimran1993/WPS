
	var pos=0;
	var style = document.getElementById('home').style;
	document.onclick  = function() {
		pos++;
		style.backgroundPositionX = - spriteparseX(pos) + 'px';
		style.backgroundPositionY = - spriteparseY(pos) + 'px';
	};
	
	function spriteparseX(pos){
		return ((pos%64)*32);
	}
	function spriteparseY(pos){
		return (Math.floor((pos/64))*32);
	}