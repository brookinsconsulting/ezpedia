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

<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key={ezini('SiteSettings','GMapsKey')}" type="text/javascript"></script>
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
      var point = new GLatLng(lat, lng)
      var marker = new GMarker( point, icon );
      GEvent.addListener(marker, "click", function() {
        marker.openInfoWindowHtml(info);
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
        if (GBrowserIsCompatible()) {
          map = new GMap2(document.getElementById(mapid));

          map.addControl(new GSmallMapControl());
          map.addControl(new GMapTypeControl());
          map.setCenter(new GLatLng(0,0), 0);
          var bounds = new GLatLngBounds();
    {/literal}
{foreach $users as $index=>$user}
{if and($user.data_map.location.content.latitude,$user.data_map.location.content.longitude)}
{set $mapCount=$mapCount|inc}
          var popupwindow_{$index}=document.getElementById('user_{$index}').innerHTML;
          map.addOverlay(createMarker('{$user.data_map.location.content.latitude}','{$user.data_map.location.content.longitude}',popupwindow_{$index}, bounds));
{/if}
{/foreach}

    {literal}

          map.setMapType(G_SATELLITE_MAP);
          map.setCenter(bounds.getCenter(), (map.getBoundsZoomLevel(bounds) - 1));

        }
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