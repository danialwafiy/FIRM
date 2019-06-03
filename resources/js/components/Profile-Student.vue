<template>
<div class="container">
    <title>Profile | FIRM</title>
        <div class="mt-4 mb-4">
            <h2 class="text-center"><span class="badge badge-title">Profile</span></h2>
            <br>  
            <div class="container">
                <div class="card-deck text-center">
                  <div class="row col-md-12">
                    <div class="col-md-4">
                        <div class=" card card-body">
                            <h6 class="card-subtitle text-muted my-auto font-weight-bold">Basic Information</h6>
                        </div>
                        <div class=" card card-body h-40">
                            <h6 class="card-text ">Name:</h6>
                            <p class="text-primary text-capitalize font-weight-bold">{{student.name|lowercaseALL}}</p>
                            <hr>
                            <h6 class="card-text ">Matric No:</h6>
                            <p class="text-primary font-weight-bold">{{student.student_id|uppercaseALL}}</p>
                            <hr>
                            <h6 class="card-text ">Email</h6>
                            <p class="text-primary font-weight-bold">{{student.email}}</p>
                            <hr>
                            <h6 class="card-text ">Phone No:</h6>
                            <p class="text-primary font-weight-bold">{{student.phone}}</p>
                        </div>
                        <div class=" card card-body h-40">
                            <h6 class="card-text ">Faculty:</h6>
                            <p class="text-primary font-weight-bold text-capitalize">{{student.faculty|lowercaseALL}}</p>
                            <hr>
                            <h6 class="card-text ">Course:</h6>
                            <p class="text-primary font-weight-bold text-capitalize">{{student.course|lowercaseALL}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-body">
                            <h6 class="card-subtitle text-muted my-auto font-weight-bold">Internship Information</h6>
                        </div>
                        <div class=" card card-body h-40">
                            <h6 class="card-text ">Semester:</h6>
                            <p class="text-primary font-weight-bold">{{student.semester}}</p>
                            <hr>                            
                            <h6 class="card-text ">Status:</h6>
                            <p v-if="student.student_status == '1'" class="text-primary font-weight-bold"><span class="badge badge-success">Active</span></p>
                            <p v-else class="text-primary font-weight-bold"><span class="badge badge-danger">Deactive</span></p>
                            <hr>
                            <h6 class="card-text ">Start Date: </h6>
                            <p class="text-primary font-weight-bold">{{student.intern_start_date|dateFormatNum}}</p>
                            <hr>
                            <h6 class="card-text ">End Date:</h6>
                            <p class="text-primary font-weight-bold">{{student.intern_end_date|dateFormatNum}}</p>
                        </div>
                        <div class=" card card-body h-40">
                            <h6 class="card-text ">Supervised by:</h6>
                            <p class="text-primary font-weight-bold">{{lecture.name}}</p>
                            <hr>
                            <h6 class="card-text ">Phone No: </h6>
                            <p class="text-primary font-weight-bold">{{lecture.phone}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-body">
                            <h6 class="card-subtitle text-muted my-auto font-weight-bold">Company Information</h6>
                        </div>
                        <div class=" card card-body h-40">
                            <h6 class="card-text ">Company Name:</h6>
                            <p class="text-primary font-weight-bold  text-capitalize">{{student.company_name|lowercaseALL}}</p>
                            <hr>
                            <h6 class="card-text ">Company Phone:</h6>
                            <p class="text-primary font-weight-bold  text-capitalize">{{student.company_phone}}
                            <hr>
                            <h6 class="card-text ">State </h6>
                            <p class="text-primary font-weight-bold text-capitalize ">
                            {{student.company_state|lowercaseALL}}</p>
                            <hr>
                            <h6 class="card-text ">Address </h6>
                            <p class="text-primary font-weight-bold text-capitalize ">{{student.company_address|lowercaseALL}}, {{student.company_postcode}}, {{student.company_city|lowercaseALL}}, {{student.company_state|lowercaseALL}}</p>
                            <hr>
                            <h6 class="card-text ">Supervisor:</h6>
                            <p class="text-primary font-weight-bold text-capitalize">{{student.supervisor_name|lowercaseALL}}</p>
                        </div>
                   </div>
                </div> 
                <button v-show="show" class="btn btn-primary col-md-12" @click="getLogbook(student.student_id)" style="align-items: center;">View Logbook</button> 
            </div>
            </div>
    </div>
</div>
</template>

<script>
    export default {
        data(){
          return{
              student:'',
              lecture:'',
              show:'',
          }
        },
        methods:{
            getStudent(){
                 axios.get(`/api/profile/${this.$route.params.id}`).then(response => this.student = response.data);
            },
            getLecture(){
                axios.get(`/api/profile/getLecture/${this.$route.params.id}`).then(response => this.lecture = response.data);
            },
            getLogbook($id){
                this.$router.push({path: '/logbook/'+ $id});
            },
            showButton(){
                axios.get('/api/profile/showButton').then(response => this.show = response.data);
            }
        },
        mounted() {
            this.getStudent();
            this.getLecture();
            this.showButton();
            console.log('Component mounted.')
        }
    }
</script>