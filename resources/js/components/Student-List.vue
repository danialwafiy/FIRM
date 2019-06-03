<style>
    .block-link {
    display: block;
}
</style>

<template>
    <div class="container">
        <title>Student Profile | FIRM</title>
        <div class="row mt-4 mb-5">
          <div class="col-md-12">
            <mark><h2 class="text-center"><span class="badge badge-title">Student List</span></h2></mark>
            <br>
                <div class="container">
                    <div class="card card-body pb-0" v-for="(student,index) in students" v-bind:key="student.student_id">
                      <a href="" @click="getStudentProfile(student.student_id)">
                        <div class="row">
                            <div class="col-md-2">
                                <h6 class="my-auto card-subtitle text-muted font-weight-bold">#{{index+1}}</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 class="my-auto card-subtitle text-muted font-weight-bold">{{student.student_id}}</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 v-if="student.student_status=='1'"><span class="badge badge-success mb-3">Active</span></h6>
                                <h6 v-else><span class="badge badge-danger mb-3">Deactive</span></h6>
                            </div>
                            <div class="col-md-6">
                                <h6 class=" my-auto card-subtitle text-muted font-weight-bold">{{student.name}}</h6>
                            </div>
                        </div>
                      </a>
                    </div>
                </div>
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
            getStudentProfile(student_id){
            this.$router.push({path: '/student/profile/'+student_id});
            },
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
