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
                <td>{{company.name}}</td>
                <td>
                  <button type="button" class="btn btn-primary">Edit</button>
                  <button type="button" class="btn btn-warning">Own</button>
                  <button type="button" class="btn btn-danger">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
</div>
</template>

<script>
    export default {
       data: function () {
            return {
                companies:null
            }
        },
        props:['url'],

        mounted() {
            let vm = this;
            
              console.log(this.url); 
            axios.get('/api/company/all')
            .then(function (response) {
              vm.companies = response.data.data;
                
               console.log(vm.companies[0]);
            })
            .catch(function (error) {
                console.log(error); 
            });
        },
        methods: {
    
        }
    }
</script>
