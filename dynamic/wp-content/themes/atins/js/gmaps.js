!function(a){var b,c,d,e;d=null,e=function(d){var e,f,g;return f=d.find(".marker"),g={zoom:16,center:new google.maps.LatLng(0,0),mapTypeId:google.maps.MapTypeId.HYBRID},e=new google.maps.Map(d[0],g),e.markers=[],f.each(function(){b(a(this),e)}),c(e),e},b=function(a,b){var c,d,e;d=new google.maps.LatLng(a.attr("data-lat"),a.attr("data-lng")),e=new google.maps.Marker({position:d,map:b}),b.markers.push(e),a.html()&&(c=new google.maps.InfoWindow({content:a.html()}),google.maps.event.addListener(e,"click",function(){c.open(b,e)}))},c=function(b){var c;c=new google.maps.LatLngBounds,a.each(b.markers,function(a,b){var d;d=new google.maps.LatLng(b.position.lat(),b.position.lng()),c.extend(d)}),1===b.markers.length?(b.setCenter(c.getCenter()),b.setZoom(16)):b.fitBounds(c)},a(document).ready(function(){a(".acf-map").each(function(){d=e(a(this))})})}(jQuery);