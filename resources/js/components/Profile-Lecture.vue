<template>
<div class="container">
    <title>Profile | FIRM</title>
        <div class="mt-4 mb-4">
            <h2 class="text-center"><span class="badge badge-title">Profile</span></h2>
            <br>         
            <div class="container">
                <div class="card-deck text-center">
                    <div class="col-md-8">
                        <div class=" card card-body">
                            <h6 class="card-subtitle text-muted my-auto font-weight-bold">Basic Information</h6>
                        </div>
                        <div class=" card card-body h-40">
                            <h6 class="card-text ">Name:</h6>
                            <p class="text-primary font-weight-bold text-capitalize">{{lecture.name|lowercaseALL}}</p>
                            <hr>
                            <h6 class="card-text ">ID No:</h6>
                            <p class="text-primary font-weight-bold">{{lecture.lecture_id|uppercaseALL}}</p>
                            <hr>
                            <h6 class="card-text ">Email</h6>
                            <p class="text-primary font-weight-bold">{{lecture.email}}</p>
                            <hr>
                            <h6 class="card-text ">Phone No:</h6>
                            <p class="text-primary font-weight-bold">{{lecture.phone}}</p>
                            <hr>
                            <h6 class="card-text ">Address</h6>
                            <p class="text-primary font-weight-bold text-capitalize">{{lecture.address|lowercaseALL}}, {{lecture.postcode}}, {{lecture.city|lowercaseALL}}, {{lecture.state|lowercaseALL}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-body">
                            <h6 class="card-subtitle text-muted my-auto font-weight-bold">Internship Information</h6>
                        </div>
                        <div class=" card card-body h-40">
                            <h6 class="card-text ">Status:</h6>
                            <p v-if="lecture.status == '1'" class="text-primary font-weight-bold"><span class="badge badge-success">Active</span></p>
                            <p v-else class="text-primary font-weight-bold"><span class="badge badge-danger">Deactive</span></p>
                            <hr>
                            <h6 class="card-text ">Semester</h6>
                            <p class="text-primary font-weight-bold">{{lecture.semester}}</p>
                            <hr>
                            <h6 class="card-text ">No of Students: </h6>
                            <p class="text-primary font-weight-bold">{{lecture.no_student}}</p>
                        </div> 
                    </div>
                    <div class="col-md-12 mt-3" v-show="show">
                            <div class="card card-body">
                                <h6 class="card-subtitle text-muted my-auto font-weight-bold">Students Assigned</h6>
                            </div>
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
                                    <h6 v-if="student.status=='1'"><span class="badge badge-success mb-3">Active</span></h6>
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
</div>
</template>

<script>
    export default {
        data(){
          return{
              lecture:'',
              students:[],
              show:''
          }
        },
        methods:{
            getLectureProfile(){
                axios.get(`/api/lecture/getLectureProfile/${this.$route.params.id}`).then(response => this.lecture = response.data);
            },
            getMyStudents(){
                     axios.get(`/api/lecture/getMyStudents/${this.$route.params.id}`).then(response => this.students = response.data.data);
            },
            getStudentProfile(student_id){
            this.$router.push({path: '/student/profile/'+student_id});
            },
            showStudentProfile(){
                axios.get('/api/profile/showStudentProfile').then(response => this.show = response.data);
            }
        },
        mounted() {
            this.getLectureProfile();
            this.getMyStudents();
            this.showStudentProfile();
            console.log('Component mounted.')
        }
    }
</script>