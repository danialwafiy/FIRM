<template>
    <div class="container"> 
    <title>Internship | FIRM</title>
        <div class="mt-4 mb-5">
            <h2 class="text-center"><span class="badge badge-title">Lectures Status</span></h2>
            <br> 
                <table class="table col-md-12" style="background-color:white;">
                    <thead class="thead white" style="background-color:#3F51B5">
                        <tr>
                            <th colspan="6" scope="col">Active Lectures</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(aLecture,index) in aLectures" v-bind:key="aLecture.lecture_id">
                            <td>#{{index+1}}</td>   
                            <td>{{aLecture.lecture_id}}</td>   
                            <td class="text-capitalize">{{aLecture.name | lowercaseALL}}</td>
                            <td><span class="badge badge-success">Active</span></td>
                            <td><a href="" title="Deactivate lecture" @click="setStatusDeactive(aLecture.lecture_id)"><i class="fas fa-user-times"></i></a></td>
                            <td><a href=""  title="Assigned students"  @click="goSortInternship(aLecture.lecture_id)"><i class="fas fa-users"></i></a></td>
                        </tr>                                                
                    </tbody>
                </table>
            <br>
            <hr>
            <br> 
                <table class="table col-md-12" style="background-color:white;">
                    <thead class="thead white" style="background-color:#3F51B5">
                        <tr>
                            <th colspan="5" scope="col">Inactive Lectures</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(dLecture,index) in dLectures" v-bind:key="dLecture.lecture_id">
                            <td>#{{index+1}}</td>   
                            <td>{{dLecture.lecture_id}}</td>   
                            <td class="text-capitalize">{{dLecture.name | lowercaseALL}}</td>
                            <td><span class="badge badge-danger">Inactive</span></td>
                            <td><a href="" @click="setStatusActive(dLecture.lecture_id)"><i class="fas fa-user-plus"></i></a></td>
                        </tr>                                                
                    </tbody>
                </table>            
        </div>
   </div> 
</template>

<script>
    export default {
        data () {
            return {
            aLectures:[],
            dLectures:[],
            form: new Form({
            })
            }
        },
        methods:{
            getActiveLecture(){
                 axios.get('/api/internship/activeLectures').then(response => this.aLectures = response.data);
            },
            getInactiveLecture(){
                 axios.get('/api/internship/inactiveLectures').then(response => this.dLectures = response.data);
            },
            setStatusDeactive($id){
                 axios.post('/api/internship/statusInactive/'+$id);
                 location.reload();
            },
            setStatusActive($id){
                 axios.post('/api/internship/statusActive/'+$id);
                 location.reload();
            },
            goSortInternship($id){
                this.$router.push({ name: 'internshipsort', params: { id: $id }})
            }            
        },
        mounted() {
            this.getActiveLecture();
            this.getInactiveLecture();
            console.log('Component mounted.')
        }
    }
</script>
