<template>
  <div>
        <div class="row justify-content-center">
            <div class="col-10">
              
                     <gmap-map
                      :center="center"
                      :zoom="3"
                      style="width:100%; height: 500px"
                    >
                    <gmap-marker
                        :key="index"
                        v-for="(m, index) in markers"
                        :position="{lat:Number(m.lat), lng:Number(m.lng)}"
                        @click="center=m.position"
                      ></gmap-marker>
                    </gmap-map>
            </div>
      </div>
                  
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
              markers: [],
              center:{lat:0, lng:0},
              stations:''
  
            }
        },

         methods: {
            geolocate: function() {
              navigator.geolocation.getCurrentPosition(position => {
                this.center = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude
                };
                             
              });
            }
          },
          mounted() {
            this.geolocate();

            axios.get('/api/station/all')
                .then(response => {
                  this.markers = response.data.data;
                  console.log(this.stations)
                })
                .catch(error => {console.log(error)});

          },

    }
</script>
