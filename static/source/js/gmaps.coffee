(($) ->

  # *  document ready
  # *
  # *  This function will render each map when the document is ready (page has loaded)
  # *
  # *  @type	function
  # *  @date	8/11/2013
  # *  @since	5.0.0
  # *
  # *  @param	n/a
  # *  @return	n/a

  # global var
  map = null

  # *  new_map
  # *
  # *  This function will render a Google Map onto the selected jQuery element
  # *
  # *  @type	function
  # *  @date	8/11/2013
  # *  @since	4.3.0
  # *
  # *  @param	$el (jQuery element)
  # *  @return	n/a

  new_map = ($el) ->
    `var map`
    # var
    $markers = $el.find('.marker')
    # vars
    args =
      zoom: 16
      center: new (google.maps.LatLng)(0, 0)
      mapTypeId: google.maps.MapTypeId.HYBRID
    # create map
    map = new (google.maps.Map)($el[0], args)
    # add a markers reference
    map.markers = []
    # add markers
    $markers.each ->
      add_marker $(this), map
      return
    # center map
    center_map map
    # return
    map

  # *  add_marker
  # *
  # *  This function will add a marker to the selected Google Map
  # *
  # *  @type	function
  # *  @date	8/11/2013
  # *  @since	4.3.0
  # *
  # *  @param	$marker (jQuery element)
  # *  @param	map (Google Map object)
  # *  @return	n/a

  add_marker = ($marker, map) ->
    # var
    latlng = new (google.maps.LatLng)($marker.attr('data-lat'), $marker.attr('data-lng'))
    # create marker
    marker = new (google.maps.Marker)(
      position: latlng
      map: map)
    # add to array
    map.markers.push marker
    # if marker contains HTML, add it to an infoWindow
    if $marker.html()
      # create info window
      infowindow = new (google.maps.InfoWindow)(content: $marker.html())
      # show info window when marker is clicked
      google.maps.event.addListener marker, 'click', ->
        infowindow.open map, marker
        return
    return

  # *  center_map
  # *
  # *  This function will center the map, showing all markers attached to this map
  # *
  # *  @type	function
  # *  @date	8/11/2013
  # *  @since	4.3.0
  # *
  # *  @param	map (Google Map object)
  # *  @return	n/a

  center_map = (map) ->
    # vars
    bounds = new (google.maps.LatLngBounds)
    # loop through all markers and create bounds
    $.each map.markers, (i, marker) ->
      latlng = new (google.maps.LatLng)(marker.position.lat(), marker.position.lng())
      bounds.extend latlng
      return
    # only 1 marker?
    if map.markers.length == 1
      # set center of map
      map.setCenter bounds.getCenter()
      map.setZoom 16
    else
      # fit to bounds
      map.fitBounds bounds
    return

  $(document).ready ->
    $('.acf-map').each ->
      # create map
      map = new_map($(this))
      return
    return
  return
) jQuery