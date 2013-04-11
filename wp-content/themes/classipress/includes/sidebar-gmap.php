<div id="gmap" class="mapblock">

    <?php
    // check to see if ad is legacy or not and then assemble the map address
    if ( get_post_meta($post->ID, 'location', true) )
        $make_address = get_post_meta($post->ID, 'location', true);
    else
        $make_address = get_post_meta($post->ID, 'cp_street', true) . '&nbsp;' . get_post_meta($post->ID, 'cp_city', true) . '&nbsp;' . get_post_meta($post->ID, 'cp_state', true) . '&nbsp;' . get_post_meta($post->ID, 'cp_zipcode', true);

		$coordinates = cp_get_geocode( $post->ID );
    ?>

    <script type="text/javascript">var address = "<?php echo esc_js($make_address); ?>";</script>

		<?php cp_google_maps_js($coordinates); ?>

    <!-- google map div -->
    <div id="map"></div>

</div>


<?php
// Google map on single page
function cp_google_maps_js($coordinates) {
?>
<script type="text/javascript">
//<![CDATA[
		jQuery(document).ready(function($) {
			var clicked = false;

			if( $('#priceblock1').is(':visible') ) {
				map_init();
			} else {
				jQuery('a[href=#priceblock1]').click( function() {
					if( !clicked ) {
						map_init();
						clicked = true;
					}
				});
			}

		});

		<?php 
		if(!empty($coordinates) && is_array($coordinates)) {
			echo 'var SavedLatLng = new google.maps.LatLng('.$coordinates['lat'].', '.$coordinates['lng'].');';
			$location_by = "'latLng':SavedLatLng";
			$marker_position = "SavedLatLng";
		} else {
			$location_by = "'address': address";
			$marker_position = "results[0].geometry.location";
		}
		?>

    //var directionDisplay;
    //var directionsService = new google.maps.DirectionsService();
    var map = null;
    var geocoder = null;
    var fromAdd;
    var toAdd;
    var redFlag = "<?php bloginfo('template_directory'); ?>/images/red-flag.png";
    var shadow = "<?php bloginfo('template_directory'); ?>/images/red-flag-shadow.png";
    var noLuck = "<?php bloginfo('template_directory'); ?>/images/gmaps-no-result.gif";
    //var title = "<?php esc_js(the_title()); ?>";
    var contentString = '<div id="mcwrap"><span><?php esc_js(the_title()); ?></span><br />' + address + '</div>';

		function map_init() {
			jQuery(document).ready(function($) {
				$('#map').hide();
				load();
				$('#map').fadeIn(1000);
				codeAddress();
			});
		}


    function load() {
        geocoder = new google.maps.Geocoder();
        //directionsDisplay = new google.maps.DirectionsRenderer();
        var newyork = new google.maps.LatLng(40.69847032728747, -73.9514422416687);
        var myOptions = {
            zoom: 14,
            center: newyork,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            }
        }
        map = new google.maps.Map(document.getElementById('map'), myOptions);
        //directionsDisplay.setMap(map);
    }


    function codeAddress() {
        geocoder.geocode( { <?php echo $location_by; ?> }, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter();

            var marker = new google.maps.Marker({
                map: map,
                icon: redFlag,
                shadow: shadow,
                //title: title,
                animation: google.maps.Animation.DROP,
                position: <?php echo $marker_position; ?>
            });

            var infowindow = new google.maps.InfoWindow({
                maxWidth: 270,
                content: contentString,
                disableAutoPan: false
            });

            infowindow.open(map, marker);

            google.maps.event.addListener(marker, 'click', function() {
              infowindow.open(map,marker);
            });

          } else {
            (function($) {
                $('#map').append('<div style="height:400px;background: url(' + noLuck + ') no-repeat center center;"><p style="padding:50px 0;text-align:center;"><?php echo esc_js( __( 'Sorry, the address could not be found.', APP_TD ) ); ?></p></div>');
                return false;
            })(jQuery);
          }
        });
      }

    function showAddress(fromAddress, toAddress) {
        calcRoute();
        calcRoute1();
    }
    function calcRoute() {
        var start = document.getElementById("fromAdd").value;
        var end = document.getElementById("toAdd").value;
        var request = {
            origin: start,
            destination: end,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            }
        });
    }
//]]>
</script>


<?php

}

?>
