<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">Company Details</div>

                    <div v-if="company" class="card-body">
                        <h1 class="mb-4 text-center">{{company.name}}</h1>
                        <img  height="150px" :src="url+'/storage/'+company.image" class="img-thumbnail" alt="Cinque Terre">
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div v-if="company.stations && company.stations.length > 0" class="station">
                        <div class="card-header">Company Stations  ({{company.stations.length}})</div>

                        <div class="card-body">
                            <template v-for="(station, index) in company.stations" >
                                <div class="row">
                                  <div class="col-4 offset-md-2  mb-2 mt-4">
                                      <h4  class="text-center">{{station.name}} 
                                        <span v-if="station.is_child">(child)</span>
                                      </h4>
                                  </div>
                                  <div class="col-3 offset-md-2  mb-2 mt-4">
                                       <button type="button" @click="deleteStations(station.id)" class="btn btn-danger">Delete</button>
                                  </div>
                                </div>
                                 <map-station :station="station" ></map-station>
                            </template>
                        </div>
                    </div>
                    <div v-else>
                        <div class="card-header">Add Stations</div>

                        <div class="card-body">
                             Company does not any station.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">Add Stations</div>

                    <div class="card-body">
                        <div v-if="company">
                            <add-station :id="company.id" ></add-station>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props:['id', 'url'],
   
        data: function () {
            return {
              company:'',
            }
        },

         methods: {
            deleteStations(id){
              axios.delete('/api/stations/'+id)
                .then(function (response) {
                    alert('deleted')
                    location.reload();
                })
                .catch(function (error) {
                    console.log(error); 
                });
            }
          },
          mounted() {
            axios.get('/api/company/single/'+this.id)
                .then(response => {
                  this.company = response.data.success.data;
                  this.geolocate();
                })
                .catch(error => {console.log(error)});

          },

    }
</script>
