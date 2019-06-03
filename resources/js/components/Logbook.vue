<style>
    a:hover{
        color:black;
        background-color:#F4F6F9;
    }
</style>

<template>
    <div class="container">
    <title>Logbook | FIRM</title>
        <div class="mt-4 mb-5">
            <h2 class="text-center"><span class="badge badge-title">Logbook</span></h2>
            <br>  
                <button  v-if="status.showAddLogBtn=='true'" class="btn btn-success mb-3" @click="addLog">Add New Log</button>
                <nav>
                <ul class="pagination ">
                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a></li>
                    <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                    <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#"  @click="fetchArticles(pagination.next_page_url)">Next</a></li>
                </ul>
                </nav>
                <div style="text-decoration:none" class="black card card-body mb-3" v-for="logbook in logbooks" v-bind:key="logbook.logbook_id">
                    <h5 class="card-title">{{logbook.title}}</h5>
                    <p class="card-text">{{ logbook.description | truncate(300)}}</p>
                    <button class="btn"  @click="getLog(logbook.logbook_id)" style="background-color:#3F51B5;color:white">View Log</button>
                    <hr>
                    <div class="row mt-3 text-center">
                        <div class="col-md-4 col-sm-4">
                            <h6 class="card-subtitle mb-2 text-muted">Date Created: <span class="badge badge-secondary"> {{logbook.date | dateFormatNum}}</span></h6>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <h6 v-if="logbook.lecture_verify == 'verified'" class="card-subtitle mb-2 text-muted">Status: <span class="badge badge-success">Verified</span></h6>
                            <h6 v-else class="card-subtitle mb-2 text-muted">Supervisor Status: <span class="badge badge-danger">Unverified</span></h6>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <h6 v-if="logbook.supervisor_verify=='verified'" class="card-subtitle mb-2 text-muted">Status: <span class="badge badge-success">Verified</span></h6>
                            <h6 v-else class="card-subtitle mb-2 text-muted">Company Status: <span class="badge badge-danger">Unverified</span></h6>
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
            status:[],
            logbooks:[],
            pagination:{},
            logbook_id:'',
            edit:false
        }
    },

    created(){
        this.fetchLogbook();
        this.showButton();
    },

    methods:{
        addLog(){
            this.$router.push('/logbook-add')
        },
        fetchLogbook(page_url){
            let vm=this;
            page_url=page_url || `/api/logbook/getStudentLogbook/${this.$route.params.id}`
            fetch(page_url).then(res=>res.json()).then(res=>{
                this.logbooks = res.data;
                vm.makePagination(res.meta,res.links);
            })
            .catch(err=>console.log(err));
        },
        getLog($id){
                this.$router.push({path: '/logbook/log/'+ $id});
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
        showButton(){
            axios.get('/api/logbook').then(response => this.status = response.data);
        }
    }
}
</script>

