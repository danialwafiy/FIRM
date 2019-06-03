<template>
    <div class="container">
    <title>Meeting | FIRM</title>
    <div class="mt-4 mb-5">
            <h2 class="text-center"><span class="badge badge-title">Meeting List</span></h2>
            <br>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(student,index) in students" v-bind:key="student.student_id">
                            <th scope="row">{{index+1}}</th>
                            <td>{{student.student_id}}</td>
                            <td>{{student.name}}</td>
                            <td><p v-if="student.meeting_date!=null">{{student.meeting_date}}</p>
                            <p v-else><span class="badge badge-warning">None</span></p></td>
                            <td><span v-if="student.meeting_status=='confirmed'" class="badge badge-success">Confirmed</span>
                            <span v-else-if="student.meeting_status=='unconfirmed'" class="badge badge-danger">Unconfirmed</span>
                            <span v-else-if="student.meeting_status=='request'" class="badge badge-warning">Reqeusting Change</span>
                            <span v-else-if="student.meeting_status==''" class="badge badge-warning">None</span></td>
                            <td><a href="" @click="getStudentMeeting(student.student_id)"><span class="fa fa-pen-square"></span></a></td>
                            </tr>
                        </tbody>
                        </table>
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
           students:'',
          }
        },
        methods:{
            getLectureStudentList(){
                 axios.get('api/meeting/getLectureStudentList').then(response => this.students = response.data);
            },
            getStudentMeeting(student_id){
                this.$router.push({path: '/student/'+student_id+'/meeting'});
            }
          },
        mounted() {
            this.getLectureStudentList();
            console.log('Component mounted.')
        }
    }
</script>