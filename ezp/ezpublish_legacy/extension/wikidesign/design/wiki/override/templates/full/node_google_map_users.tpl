{set-block scope=root variable=cache_ttl}0{/set-block}

<h1>{$node.name|wash}</h1>

{let $users=fetch( 'content', 'tree', hash(
    'parent_node_id', 5,
    'class_filter_type', 'include',
    'class_filter_array',
    hash(
        0, 'user'
        ),
    'main_node_only', true()
    ))
    $mapCount=0
}
{if $users|count|gt(0)}

<script src="https://maps.googleapis.com/maps/api/js?key={ezini('SiteSettings','GMapsKey')}&sensor={ezini('GMapSettings', 'UseSensor', 'ezgmaplocation.ini')}" type="text/javascript"></script>
<script type="text/javascript">
    {literal}
    var mapid = 'map';
    var map = null;
    var geocoder = null;
    var gmapExistingOnload = null;
    var marker = null;

    if (window.onload)
    {
            //Hang on to any existing onload function.
            gmapsExistingOnload = window.onload;
    }

    function createMarker( lat, lng, info, bounds, icon)
    {
      var point = new google.maps.LatLng(lat, lng);
      var marker = new google.maps.Marker({ position: point, draggable: false, map: map });
      google.maps.event.addListener(marker, "click", function() {
        // var infoWindow = new google.maps.InfoWindow();
        // infoWindow.setContent(info);
        // infoWindow.open(marker);
        // marker.openInfoWindowHtml(info);
      });
      bounds.extend(point);
      return marker;
    }

    window.onload=function(ev){
        //Run any onload that we found.
        if (gmapExistingOnload)
        {
                gmapExistingOnload(ev);
        }
        // if (GBrowserIsCompatible()) {
        var myOptions = {
          center: new google.maps.LatLng(38.5, -40.5),
          zoom: 1,
          mapTypeId: google.maps.MapTypeId.SATELLITE,
          // Add controls
          mapTypeControl: true,
          scaleControl: true,
          overviewMapControl: true,
          overviewMapControlOptions: {
            opened: true
          }
        };

          map = new google.maps.Map(document.getElementById(mapid), myOptions);

          // map.addControl(new GSmallMapControl());
          // map.addControl(new GMapTypeControl());
          // map.setCenter(new GLatLng(0,0), 0);

          var bounds = new google.maps.LatLngBounds();
    {/literal}
{foreach $users as $index => $user}
{* // <b>{$user.data_map.location.content|attribute(show)}</b> *}
{set $mapCount=$mapCount|inc}
{if and($user.data_map.location.content.latitude,$user.data_map.location.content.longitude)}
          var popupwindow_{$index}=document.getElementById('user_{$index}').innerHTML;
          // map.addOverlay(createMarker('{$user.data_map.location.content.latitude}','{$user.data_map.location.content.longitude}',popupwindow_{$index}, bounds));

          var overlay = createMarker('{$user.data_map.location.content.latitude}','{$user.data_map.location.content.longitude}',popupwindow_{$index}, bounds);
	  overlay.setMap(map);

          var infoWindow = new google.maps.InfoWindow();
    {literal}
          google.maps.event.addListener(overlay, 'click', function () {
    {/literal}
            infoWindow.setContent( popupwindow_{$index} );
    {literal} 
            infoWindow.open(map);
          });
    {/literal}

          
{/if}
{/foreach}

    {literal}
          // map.setMapType(G_SATELLITE_MAP);
          // map.setCenter(bounds.getCenter(), (map.fitBounds(bounds) - 1));
        //}
    };

    {/literal}
</script>

<div id="map" style="width: 650px; height: 450px"></div>
<p>{"There are %count users on the map."|i18n("design/wiki",'',hash("%count",$mapCount))}</p>
<div style="display: none">
{foreach $users as $index => $user}
  <div class="user_line" id="user_{$index}">
    <div><strong><a href={$user.url_alias|ezurl}>{$user.name|wash}</a></strong></div>
    <div>{attribute_view_gui attribute=$user.data_map.signature}</div>
  </div>
{/foreach}
</div>

{/if}


{/let}