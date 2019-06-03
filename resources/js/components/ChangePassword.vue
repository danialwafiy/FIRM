<template>
    <div class="container">
    <title>Change Password | FIRM</title>
    <div class="mt-4">
            <h2 class="text-center"><span class="badge badge-title">Change Password</span></h2>
            <br>
            <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Change Password</div>
                    <form @submit.prevent="changePassword">
                    <div class="card-body">
                          <div class="form-group">
                            <input v-model="form.password" type="password" name="password" placeholder="Enter New Password"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password"></has-error>
                          </div>
                          <div class="form-group">
                            <input v-model="form.password_confirm" type="password" name="password_confirm" placeholder="Confirm New Password"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirm') }">
                            <has-error :form="form" field="password_confirm"></has-error>
                          </div>                          
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>     
                    </form>
                </div>
            </div>
            </div>
    </div>
    </div>
</template>

<script>
    export default {
        data(){
          return{
            form: new Form({
                password:'',
                password_confirm:''
            }),
            data: new Form({
                id:'',
            }),            
          }
        },
        methods:{
            loadUser(){
                axios.get("api/profile").then(({data})=>(this.data.fill(data)));
            },            
            changePassword(){
                this.$Progress.start();              
                this.form.put('api/change-password/'+this.data.id)
                .then(()=>{
                      $('#modal').modal('hide');
                      swal.fire('Updated!','Your password has been updated.','success');
                      this.$Progress.finish();
                    })
                .catch(()=>{
                   this.$Progress.fail();              
                    })                
            }
        },
        mounted() {
            this.loadUser();
            console.log('Component mounted.')
        }
    }
</script>