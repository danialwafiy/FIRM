<template>
    <div class="container"> 
    <title>Internship | FIRM</title>
        <div class="mt-4 mb-5">
            <h2 class="text-center"><span class="badge badge-title text-capitalize">Students for {{lecture.name|lowercaseALL}}</span></h2>
            <br>
            <table class="table col-md-12" style="background-color:white;">
                <thead class="thead white" style="background-color:#3F51B5">
                    <tr>
                        <th colspan="6" scope="col">Assigned</th>
                    </tr>
                </thead>
                <tbody>
                    <div class="card col-md-11 mt-3 mx-auto" v-for="(aStudent,index) in aStudents" v-bind:key="aStudent.student_id">
                        <div class="card-body">
                            <div class="row">
                            <h6 class="card-subtitle text-muted col-md-1 my-auto">#{{index+1}}</h6>
                            <h6 class="card-subtitle text-muted col-md-2 my-auto">{{aStudent.student_id}}</h6>
                            <h6 class="card-subtitle text-muted col-md-6 my-auto">{{aStudent.name}}</h6>
                            <h6 class="card-subtitle text-muted col-md-2 my-auto">{{aStudent.company_state}}</h6>
                            <a href="" class="col-md-1" @click="removeLectureFK(aStudent.student_id)"><i class="fas fa-user-times"></i></a>
                            </div>  
                        </div>
                    </div>                                                
                </tbody>
            </table>
            <br>        
            <hr>
            <br>
            <button class="btn btn-primary mb-2 float-right" @click="setLectureFK" style="align-items: center;">Add Students</button> 
            <table class="table col-md-12" style="background-color:white;">
                <thead class="thead white" style="background-color:#3F51B5">
                    <th>Unassgined
                        <input class="form-control w-25 float-right" type="text" id="myInput" v-model="filter" placeholder="Search by states ...">
                    </th>
                </thead>
                <tbody>
                        <div class="card col-md-11 mt-3 mx-auto" v-for="(uStudent,index) in filteredStudents" v-bind:key="uStudent.student_id"  id="myList">
                            <div class="card-body">
                                <div class="row">
                                <h6 class="card-subtitle text-muted col-md-1 my-auto">#{{index+1}}</h6>
                                <h6 class="card-subtitle text-muted col-md-2 my-auto">{{uStudent.student_id}}</h6>
                                <h6 class="card-subtitle text-muted col-md-5 my-auto">{{uStudent.name}}</h6>
                                <h6 class="card-subtitle text-muted col-md-2 my-auto">{{uStudent.company_state}}</h6>
                                <input type="checkbox" name="check_students" class="col-md-1 my-auto" v-model="check_students" v-bind:value="uStudent.student_id">
                                </div>  
                            </div>
                        </div> 
                </tbody>
            </table>
        </div>
   </div> 
</template>

<script>
    export default {
        data () {
            return {
            check_students:[],
            filter:'',
            aStudents:[],
            uStudents:[],
            lecture:'',
            lecture_id:this.$route.params.id,
            }
        },
        methods:{
            setNoStudent(){
                axios.post(`/api/internship/setNoStudent/${this.$route.params.id}`);
            },
            getLectureDetails(){
                axios.get(`/api/lecture/${this.$route.params.id}`).then(response => this.lecture = response.data);
            },
            getAssignedStudents(){
                axios.get(`/api/internship/assignedStudents/${this.$route.params.id}`).then(response => this.aStudents = response.data);
            },
            getUnassignedStudents(){
                 axios.get(`/api/internship/unassignedStudents/${this.$route.params.id}`).then(response => this.uStudents = response.data);               
            },
            setLectureFK(){
            swal.fire({
              title: 'Are you sure?',
              text: "Make sure you selected the correct students",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Assign them!'
              }).then((result) => { 
                 if (result.value){
                //Send request to server 
                axios.post('/api/internship/setLecture/'+this.lecture_id+'/'+this.check_students).then(()=>{
                    swal.fire('Successful!','The students has been assigned.','success');
                    setTimeout(location.reload(),2000);
                  }).catch(()=>{
                      swal.fire("Failed!","There was something wrong","warning");
                  });
                 }
                 else if (result.dismiss === swal.DismissReason.cancel){
                    
                  }
              })      
            },
            removeLectureFK($student_id){
                 axios.post('/api/internship/removeLecture/'+$student_id);               
            },
        },
        mounted() {
            this.setNoStudent();
            this.getLectureDetails();
            this.getAssignedStudents();
            this.getUnassignedStudents();
            console.log('Component mounted.')
        },
        computed: {
            filteredStudents() {
            return this.uStudents.filter(user => {
                const filter = this.filter.toUpperCase();
                const byState = user.company_state.toUpperCase().includes(filter);
                const byName = user.name.toUpperCase().includes(filter);
                const byID = user.student_id.toUpperCase().includes(filter);
                return byState || byName || byID;
            })
            }
        },
    }
</script>
