<template>
    <div class="container mb-5">
        <title>Dashboard | FIRM</title>
        <div class="mt-5" v-if="userType==1|userType==2|userType==3"> 
        <div class="row justify-content-center">

            <div v-if="userType=='3'" class="container">
                <div class="card-deck text-center">
                    <div class="card col-md-3 back-blue text-white" style="height:100px;">
                        <div class="card-body">
                            <p class="card-text">STATUS</p>
                            <h2 v-if="student.status=='1'" class="card-title font-weight-bold "><span class="badge badge-success">Active</span></h2>
                            <h2 v-if="student.status=='0'" class="card-title font-weight-bold "><span class="badge badge-danger">Inactive</span></h2>
                        </div>
                    </div>
                    <div class="card col-md-3 back-blue text-white" style="height:100px;">
                        <div class="card-body">
                            <p class="card-text">START INTERNSHIP</p>
                            <h2 class="card-title font-weight-bold">{{student.intern_start_date}}</h2>
                        </div>
                    </div>
                    <div class="card col-md-3 back-blue text-white" style="height:100px;">
                        <div class="card-body">
                            <p class="card-text">END INTERNSHIP</p>
                            <h2 class="card-title font-weight-bold">{{student.intern_end_date}}</h2>
                        </div>
                    </div>
                    <div class="card col-md-3 back-blue text-white" style="height:100px;">
                        <div class="card-body">
                            <p class="card-text">SEMESTER</p>
                            <h2 class="card-title font-weight-bold">{{student.semester}}</h2>
                        </div>
                    </div>
                </div>                                              
            </div>

            <div v-if="userType=='2'" class="container">
                <div class="card-deck text-center">
                    <div class="card col-md-4 back-blue text-white" style="height:100px;">
                        <div class="card-body">
                            <p class="card-text">STATUS</p>
                            <h2 v-if="lecture.status=='1'" class="card-title font-weight-bold "><span class="badge badge-success">Active</span></h2>
                            <h2 v-if="lecture.status=='0'" class="card-title font-weight-bold "><span class="badge badge-danger">Inactive</span></h2>
                        </div>
                    </div>
                    <div class="card col-md-4 back-blue text-white" style="height:100px;">
                        <div class="card-body">
                            <p class="card-text">SEMESTER</p>
                            <h2 class="card-title font-weight-bold">{{lecture.semester}}</h2>
                        </div>
                    </div>
                    <div class="card col-md-4 back-blue text-white" style="height:100px;">
                        <div class="card-body">
                            <p class="card-text">NO. STUDENTS</p>
                            <h2 class="card-title font-weight-bold">{{lecture.no_student}}</h2>
                        </div>
                    </div>
                </div>                                              
            </div>

            <div v-if="userType=='1'" class="container">
                <div class="card-deck text-center">
                    <div class="card col-md-3 back-blue text-white" style="height:100px;">
                        <div class="card-body">
                            <p class="card-text">TOTAL STUDENTS</p>
                            <h2 class="card-title font-weight-bold">{{admin.totalStudent}}</h2>
                        </div>
                    </div>
                    <div class="card col-md-3 back-blue text-white" style="height:100px;">
                        <div class="card-body">
                            <p class="card-text">ACTIVE STUDENTS</p>
                            <h2 class="card-title font-weight-bold"><span class="badge badge-success">{{admin.activeStudent}}</span></h2>
                        </div>
                    </div>
                    <div class="card col-md-3 back-blue text-white" style="height:100px;">
                        <div class="card-body">
                            <p class="card-text">TOTAL LECTURES</p>
                            <h2 class="card-title font-weight-bold">{{admin.totalLecture}}</h2>
                        </div>
                    </div>
                    <div class="card col-md-3 back-blue text-white" style="height:100px;">
                        <div class="card-body">
                            <p class="card-text">ACTIVE LECTURES</p>
                            <h2 class="card-title font-weight-bold"><span class="badge badge-success">{{admin.activeLecture}}</span></h2>
                        </div>
                    </div>
                </div>                                              
            </div>

        </div>
        <br>
        <h2 class="text-center"><sspan class="badge badge-title">Latest News</sspan></h2>
        <div class="row justify-content-center mt-4">
            <div class="container">
                <table class="table col-md-12" style="background-color:white;">
                    <thead class="thead white" style="background-color:#303642">
                        <tr>
                            <th scope="col">News</th>
                        </tr>
                    </thead>
                    <tbody>
                    <ul class="pagination mt-3 ml-2">
                        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchNews(pagination.prev_page_url)">Previous</a></li>
                        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#"  @click="fetchNews(pagination.next_page_url)">Next</a></li>
                    </ul>
                        <tr>
                            <td>
                                <div class="card col-md-12" v-for="newz in news" v-bind:key="newz.news_id">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <h5 class="card-title">{{newz.title}}</h5>
                                                <h6 class="card-subtitle mb-2 text-muted">{{newz.date_created | dateFormatNum }}</h6>
                                                <p class="card-text">{{newz.description}}</p>
                                            </div>
                                            <div class="col-md-2">
                                                <img v-if="newz.filename!=null"  class="img-rounded img-responsive" style="max-width:100px;height:100px;" :src="getFile(newz.filename)">  
                                            </div>   
                                        </div>                                       
                                    </div>
                                </div>                                 
                            </td>   
                        </tr>                                                
                    </tbody>
                </table>
            </div>            
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
            news:[],
            pagination:{},
            student:'',
            lecture:'',
            userType:'',
            admin:''
            }
        },
        methods:{
            dashboardAdminData(){
                axios.get('/api/lecture/dashboardAdminData').then(response => this.admin = response.data);
            },
            getUserType(){
                axios.get('/api/profile/getUserType').then(response => this.userType = response.data);
            },
            getFile($id){
                return "/files/" + $id;
            },    
            showWithSessionLecture(){
                axios.get('/api/lecture/showWithSessionLecture').then(response => this.lecture = response.data);
            },        
            showWithSessionStudent(){
                axios.get('/api/profile/showWithSessionStudent').then(response => this.student = response.data);
            },
            fetchNews(page_url){
                let vm=this;
                page_url=page_url || '/api/news'
                fetch(page_url).then(res=>res.json()).then(res=>{
                    this.news = res.data;
                    vm.makePagination(res.meta,res.links);
                })
                .catch(err=>console.log(err));
            }
        },
        mounted() {
            this.dashboardAdminData();
            this.showWithSessionLecture();
            this.getUserType();
            this.showWithSessionStudent();
            this.fetchNews();
            console.log('Component mounted.')
        }
    }
</script>