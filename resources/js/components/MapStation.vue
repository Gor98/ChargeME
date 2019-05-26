<template>
  <div>
     <gmap-map
      :center="position"
      :zoom="13"
      style="width:100%;  height: 250px;"
      :options="mapOptions"
    >
      <gmap-marker
        :position="position"
      ></gmap-marker>
    </gmap-map>
                     
    </div>
</template>

<script>
    export default {
        props:['station'],
        data: function () {
            return {
              mapOptions:{
                disableDefaultUI : true
              },
              position:{lat:0, lng:0}
  
            }
        },

         methods: {
            // geolocate: function() {
            //   navigator.geolocation.getCurrentPosition(position => {
            //     this.center = {
            //       lat: position.coords.latitude,
            //       lng: position.coords.longitude
            //     };
                             
            //   });
            // }
          },
          mounted() {
   
            if(this.station){
              this.position.lat = Number(this.station.lat);
              this.position.lng = Number(this.station.lng);
            }
        
             //this.geolocate();

          },

    }
</script>
