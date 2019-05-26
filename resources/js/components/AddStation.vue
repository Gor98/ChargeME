<template>
  <div>
  
         <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" v-validate="'required'" v-model="form.name" id="name" class="form-control" placeholder="Name" name="name">
            <span v-show="errors.has('name')" class="text-danger">{{ errors.first('name') }}</span>
        </div>

      <div class="form-group">
        <label for="place">Place <span class="text-danger">*</span></label>
       <gmap-autocomplete
            id="place"
            name='place'
            class="form-control"
            placeholder="Place"
            @place_changed="setPlace">
        </gmap-autocomplete>

      </div>

    
      <button type="button" @click="validateBeforeSubmit" class="btn btn-success  btn-lg btn-block">Submit</button>
                          
  </div>
</template>

<script>
    export default {
        props:['id'],
        data: function () {
            return {
              form:{
                name:null,
                lat:null,
                lng:null,
                company_id:this.id
              }
            }
        },

        methods: {
            setPlace(place) {
              this.form.lat = place.geometry.location.lat();
              this.form.lng = place.geometry.location.lng();
            },

           create() {
               axios.post('/api/stations  ', this.form)
                .then(function (response) {
                    alert('Succress')
                    location.reload();
                })
                .catch(function (error) {
                    console.log(error.response); 
                });
            },

            validateBeforeSubmit() {
              this.$validator.validateAll().then((result) => {
                if (result && this.form.lat !== null && this.form.lat !== null) {
                  this.create();
                  return;
                }

                alert('Validation error! Place and Name fields are reqire.');
              });
            },    
        },
          mounted() {

          },

    }
</script>
