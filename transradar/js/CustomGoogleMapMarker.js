function CustomMarker(latlng, map, args, to, from) {
	this.latlng = latlng;
	this.args = args;	
	this.to = to;	
	this.from = from;	
	this.setMap(map);	
}

CustomMarker.prototype = new google.maps.OverlayView();

CustomMarker.prototype.draw = function() {
	
	var self = this;
	var div = this.div;
	
	if (!div) {
	
		div = this.div = document.createElement('div');
		div.className = 'marker';
		div.innerHTML = '<div class="tracks_to">'+this.to+'</div><div class="tracks_from">'+this.from+'</div>';
		div.style.position = 'absolute';
		// div.style.cursor = 'pointer';

		if (typeof(self.args.marker_id) !== 'undefined') {
			div.dataset.marker_id = self.args.marker_id;
		}
		
		// google.maps.event.addDomListener(div, "click", function(event) {
		// 	alert('You clicked on a custom marker!');			
		// 	google.maps.event.trigger(self, "click");
		// });
		
		var panes = this.getPanes();
		panes.overlayImage.appendChild(div);
	}
	
	var point = this.getProjection().fromLatLngToDivPixel(this.latlng);
	
	if (point) {
		div.style.left = (point.x - 22) + 'px';
		div.style.top = (point.y - 46) + 'px';
	}
};

CustomMarker.prototype.remove = function() {
	if (this.div) {
		this.div.parentNode.removeChild(this.div);
		this.div = null;
	}	
};

CustomMarker.prototype.getPosition = function() {
	return this.latlng;	
};