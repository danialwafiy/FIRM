<template>
    <div class="container">
        <div class="row mt-4 mb-5">
          <div class="col-md-12">
            <h2><span class="badge badge-title">My Students</span></h2>
            <br>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">My Students</h3>
                <div class="card-tools">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  <tr v-for="student in students" v-bind:key="student.student_id" class="my-auto"> 
                    <td>{{student.student_id}}</td>
                    <td>{{student.name}}</td>
                    <td>
                        <h6 v-if="student.status == 'active'"><span class="badge badge-success">Active</span></h6>
                        <h6 v-else><span class="badge badge-danger">Deactive</span></h6>
                    </td>
                    <td>
                        <button class="btn btn-primary py-0 px-1">View Profile</button>
                    </td>
                  </tr>
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>  
            <!-- /.card -->
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
              id:'',
              students:[],
            }
        },
        created(){
          axios.get('api/studentlecture')
              .then(response => {
                  this.id = response.data;
                     axios.get('api/studentlecture/'+this.id).then(response => this.students = response.data);
              })
              .catch(function(error){console.log(error)}); 
        },
        methods:{

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>