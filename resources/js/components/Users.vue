<template>
    <div class="container">
          <div class="row mt-5">
            <div class="col-md-12">
              <button class="btn btn-success" @click="addModal">Add User<i class="fas fa-user-plus fa-fw"></i></button>
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Student List</h3>
                  <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">
                    <tbody><tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Registered At</th>
                      <th>Action</th>
                    </tr>
                    <tr v-for="user in users" :key="user.id">
                      <td>{{user.id}}</td>
                      <td>{{user.name}}</td>
                      <td>{{user.email}}</td>
                      <td>{{user.type | uppercase}}</td>
                      <td>{{user.created_at | dateFormat}}</td>
                      <td>  
                          <a href="#" @click="editModal(user)" style="color:black">
                              <i class="fa fa-edit blue fa-fw"></i>
                          </a> /
                          <a href="#" style="color:black" @click="deleteUser(user.id)">
                              <i class="fas fa-trash-alt red fa-fw"></i>
                          </a>
                      </td> 
                    </tr>
                  </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
        <!--Model-->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="modalLabel">Add User</h5>
                        <h5 class="modal-title" v-show="editmode" id="modalLabel">Update User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!--if editmode is ? then update user ,, if not add user -->
                    <form @submit.prevent="editmode?updateUser():addUser()">
                      <div class="modal-body">
                          <div class="form-group">
                            <input v-model="form.name" type="text" name="name" placeholder="Enter name"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                          </div>
                          <div class="form-group">
                            <input v-model="form.email" type="email" name="email" placeholder="Enter email"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                          </div>   
                          <div class="form-group">
                            <input v-model="form.password" type="password" name="password" placeholder="Enter password"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password"></has-error>
                          </div> 
                          <div class="form-group">
                            <select name="type" v-model="form.type" id="type"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                              <option value="">Select user type</option>
                              <option value="admin">Admin</option>
                              <option value="student">Student</option>
                              <option value="lecture">Lecture</option>
                            </select> 
                            <has-error :form="form" field="type"></has-error>
                          </div>                                                           
                      </div>
                      <div class="modal-footer">
                          <button v-show="!editmode" type="submit" class="btn btn-primary">Add</button>
                          <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
          return{
            editmode:false,
            users:{},  
            form: new Form({
                id:'',
                name:'',
                email:'',
                password:'',
                type:''
            })
          }
        },
        methods:{
          loadUsers(){
            axios.get("api/user").then(({data})=>(this.users=data.data));
          },
          addUser(){
            this.$Progress.start();
            this.form.post('api/user')
            .then(()=>{
                Fire.$emit('sendHTTPRequest');
                $('#modal').modal('hide')
                toast.fire({
                  type: 'success',
                  title: 'User Created Successfully'
                })
                this.$Progress.finish();              
            })
            .catch(()=>{

            })
          },
          deleteUser(id){
              swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
              }).then((result) => { 
                 if (result.value){
                //Send request to server 
                  this.form.delete('api/user/'+id).then(()=>{
                      swal.fire('Deleted!','Your file has been deleted.','success');
                      Fire.$emit('sendHTTPRequest');
                  }).catch(()=>{
                      swal.fire("Failed!","There was something wrong","warning");
                  });
                 }
                 else if (result.dismiss === swal.DismissReason.cancel){
                    
                  }
              })
            },
            addModal(){
                this.editmode=false;
                this.form.reset(); 
                $('#modal').modal('show');
            },
            editModal(user){
                this.editmode=true;
                this.form.reset(); 
                $('#modal').modal('show');
                this.form.fill(user);
            }, 
            updateUser(){
                this.$Progress.start();              
                this.form.put('api/user/'+this.form.id)
                .then(()=>{
                      $('#modal').modal('hide');
                      swal.fire('Updated!','Your file has been updated.','success');
                      this.$Progress.finish();
                      Fire.$emit('sendHTTPRequest');
                })
                .catch(()=>{
                   this.$Progress.fail();              
                })
            }          
          },
        mounted() {
            this.loadUsers();
            Fire.$on('sendHTTPRequest',()=>{
              this.loadUsers();
            });
           // setInterval(()=>this.loadUsers(),3000);
        }
    }
</script>