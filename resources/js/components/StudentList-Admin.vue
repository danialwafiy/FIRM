<style>
    a:hover{
        color:black;
        background-color:#F4F6F9;
    }
</style>

<template>
    <div class="container">
    <title>Student List | FIRM</title>
        <div class="mt-4 mb-5">
            <h2 class="text-center"><span class="badge badge-title">Student List</span></h2>
            <br>  
                <nav>
                <ul class="pagination ">
                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchNews(pagination.prev_page_url)">Previous</a></li>
                    <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                    <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#"  @click="fetchNews(pagination.next_page_url)">Next</a></li>
                </ul>
                </nav>
                    <input class="form-control w-25 mx-auto" type="text" id="myInput" v-model="filter" placeholder="Search by ID or name">
                    <br>
                    <div class="card card-body pb-0" v-for="(student,index) in filteredStudents" v-bind:key="student.student_id">
                      <a href="" @click="getStudentProfile(student.student_id)">
                        <div class="row">
                            <div class="col-md-2">
                                <h6 class="my-auto card-subtitle text-muted font-weight-bold">#{{index+1}}</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 class="my-auto card-subtitle text-muted font-weight-bold">{{student.student_id}}</h6>
                            </div>
                            <div class="col-md-6">
                                <h6 class=" my-auto card-subtitle text-muted font-weight-bold">{{student.name}}</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 v-if="student.status=='1'"><span class="badge badge-success mb-3">Active</span></h6>
                                <h6 v-else><span class="badge badge-danger mb-3">Deactive</span></h6>
                            </div>                            
                        </div>
                      </a>
                    </div>
        </div>       
    </div>
</template>

<script>
export default {
    data(){
        return{
            students:[],
            pagination:{},
            student_id:'',
            filter:'',
        }
    },

    created(){
        this.fetchNews();
    },

    methods:{
        fetchNews(page_url){
            let vm=this;
            page_url=page_url || '/api/profile/getAllStudentList'
            fetch(page_url).then(res=>res.json()).then(res=>{
                this.students = res.data;
                vm.makePagination(res.meta,res.links);
            })
            .catch(err=>console.log(err));
        },
        makePagination(meta,links){
            let pagination={
                current_page:meta.current_page,
                last_page:meta.last_page,
                next_page_url:links.next,
                prev_page_url:links.prev
            }
            this.pagination = pagination;
        },
        getStudentProfile(student_id){
        this.$router.push({path: '/student/profile/'+student_id});
        },       
    },
    computed: {
        filteredStudents() {
        return this.students.filter(user => {
            const filter = this.filter.toUpperCase();
            const byID = user.student_id.toUpperCase().includes(filter);
            const byName = user.name.toUpperCase().includes(filter);
            return byID || byName;
            })
        }
    },
}
</script>

