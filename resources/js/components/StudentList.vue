<template>
    <div class="container">
        <div class="row mt-5 mb-5">
          <div class="col-md-12">
            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addUser">Add User<i class="fas fa-user-plus fa-fw"></i></button>
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
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  <tr>
                    <td>657</td>
                    <td>Bob Doe</td>
                    <td>11-7-2014</td>
                    <td><span class="tag tag-primary">Approved</span></td>
                    <td>
                        <a href="#" data-toggle="modal" data-target="#viewProfile" style="color:black">Profile
                            <i class="fa fa-user blue fa-fw"></i>
                        </a> /
                        <a href="https://wa.me/60126581804" style="color:black">Whatsapp
                            <i class="fab fa-whatsapp green fa-fw"></i>
                        </a>
                    </td> 
                  </tr>
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!--View Profile Model-->
        <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUser" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUser">Add User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                         ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
                name:'',
                email:'',
                password:''
            })
          }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>