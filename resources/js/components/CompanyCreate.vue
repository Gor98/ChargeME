<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create company</div>

                <div class="card-body">
                
                  <div class="form-group">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" v-validate="'required'" v-model="form.name" id="name" class="form-control" placeholder="Name" name="name">
                    <span v-show="errors.has('name')" class="text-danger">{{ errors.first('name') }}</span>
                  </div>
                  
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <label class="custom-file-label" for="image">Choose file <span class="text-danger">*</span></label>
                        <input type="file" v-validate="'required|image'" @change="onFileChanged" name="image" placeholder="image" class="custom-file-input" id="image">
                        <span v-show="errors.has('image')" class="help is-danger">{{ errors.first('image') }}</span>
                      </div>
                    </div>
                  </div>
                  
                  <button type="button" @click="validateBeforeSubmit" class="btn btn-success  btn-lg btn-block">Submit</button>

                
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
       data: function () {
            return {
                form: {
                    name:null,
                    image:null
                },
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
          validateBeforeSubmit() {
              this.$validator.validateAll().then((result) => {
                if (result) {
                  this.create();
                  return;
                }

                alert('Validation error! Image and Name fields are reqire.');
              });
            },
            onFileChanged (event) {
                this.form.image = event.target.files[0]
            },
            create(){
                const formData = new FormData();
                formData.append('image', this.form.image);
                formData.append('name', this.form.name);
                    
             axios.post('/api/companies', formData)
                .then(function (response) {
                    alert('Succress')
                    window.location = '/api/companies';
                })
                .catch(function (error) {
                    console.log(error.response); 
                });
         
            }
        }
    }
</script>
