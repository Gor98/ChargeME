<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Logo</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr  v-for="(company, index) in companies" v-bind:key="company.id">
                <th sope="row">{{++index}}</th>
                <td><img height="50px;" :src="url+'/storage/'+company.image" :alt="company.id"></td>
                <td><a :href="url+'/api/companies/'+company.id">{{company.name}}</a></td>
                <td>
                  <button type="button" @click="deleteCompany(company.id, --index)" class="btn btn-danger mr-1">Delete</button>
                  <button type="button" @click="showEdit(company, --index)" data-toggle="modal" data-target="#editCompany" class="btn btn-primary mr-1">Edit</button>
                  <button type="button" :disabled="Number(company.is_child) === 1" @click="showBuy(company, --index)" data-toggle="modal" data-target="#BuyCompany" class="btn btn-warning mr-1">
                  Buy</button>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- edit modal -->

          <!-- Modal -->
          <div  class="modal fade" id="editCompany" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form>
                      <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" v-validate="'required'" v-model="form.name" id="name" class="form-control" placeholder="Name" name="name">
                        <span v-show="errors.has('name')" class="text-danger">{{ errors.first('name') }}</span>
                      </div>
                      
                      <div class="form-group">
                        <div class="input-group mb-3">
                          <div class="custom-file">
                            <label class="custom-file-label" for="image">Choose file <span class="text-danger">*</span></label>
                            <input type="file"  @change="onFileChanged" name="image" placeholder="image" class="custom-file-input" id="image">
                          
                          </div>
                        </div>
                      </div>
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" @click="validateBeforeSubmit"  data-dismiss="modal" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>

           <!-- buy modal -->

          <!-- Modal -->
          <div  class="modal fade" id="BuyCompany" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                          <label for="exampleFormControlSelect2">Select base company.</label>
                          <select  v-model="baseCompany" v-if="targetCompany" class="form-control" id="exampleFormControlSelect2">
                             <option v-if="item.id !== targetCompany.id" v-for="item in companies" v-bind:value="item">
                            {{ item.name }}
                          </option>
                          </select>
                        </div>
                      <div v-if="targetCompany">
                        <p>Target company is <b>{{this.targetCompany.name}}</b></p>
                      </div>
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" @click="buyCompany"  data-dismiss="modal" class="btn btn-primary">Save changes</button>
                </div>
              </div>
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
                companies:null,

                editCompany:null,
                index:null,

                targetCompany:null,
                baseCompany:null,
                targetIndex:null,

                form:{
                  name:null,
                  image:null
                }
            }
        },
        props:['url'],

        mounted() {
            let vm = this;
            
            axios.get('/api/company/all')
            .then(function (response) {
              vm.companies = response.data.data;
            })
            .catch(function (error) {
                console.log(error); 
            });
        },
        methods: {
          deleteCompany(id, index) {
            let vm = this;
            axios.delete('/api/companies/'+id)
            .then(function (response) {
                alert('deleted')
                location.reload();
            })
            .catch(function (error) {
                console.log(error); 
            });
          },

          onFileChanged (event) {
              this.form.image = event.target.files[0]
          },

          showEdit(company, index){
            this.editCompany = company;
            this.index = index;
            this.form.name = company.name;
          },

          showBuy(company, index){
            this.targetCompany = company;
            this.targetIndex = index;
          },

          buyCompany(){
            if(this.targetCompany === null || this.baseCompany === null){
                alert('Validation error! Chose base company.');
            }else{

            let vm = this;
            axios.post('/api/company/buy',{
              targetCompanyId:this.targetCompany.id,
              baseCompanyId:this.baseCompany.id,
            })
              .then(function (response) {
                  vm.companies[vm.targetIndex]['is_child'] = 1;
                  vm.targetCompany = null;
                  vm.baseCompany = null;
                  vm.targetIndex  = null;
                  alert('Succress')
              })
              .catch(function (error) {
                  vm.targetCompany = null;
                  vm.baseCompany = null;
                  console.log(error); 
              });
  
            }

          },


         validateBeforeSubmit() {
            this.$validator.validateAll().then((result) => {
              if (result) {
                this.updateCompany();
                return;
              }

              alert('Validation error! Image an name fields are reqire.');
            });
          },


          updateCompany(){
              const formData = new FormData();
                formData.append('image', this.form.image);
                formData.append('name', this.form.name);
                formData.append('_method', 'put');

              let vm = this;     
             axios.post('/api/companies/'+this.editCompany.id, formData)
                .then(function (response) {

                  vm.companies[vm.index].name = response.data.success.data.name;
                  vm.companies[vm.index].image = response.data.success.data.image;
                  vm.editCompany = null;
                  vm.index = null;
                  vm.id = null;

                    alert('Succress')
                })
                .catch(function (error) {
                    console.log(error.response); 
                });
          }  

        }
    }
</script>
