<template>
    <div class="container">
    <title>View Log | FIRM</title>
        <div class="mt-4 mb-5">
            <h2 class="text-center"><span class="badge badge-title">Log : {{logbook.date | dateFormatNum}}</span></h2>
            <br>
            <div class="black card card-body mb-3">
                <div class="container">
                    <h5 style="text-align:left;" >
                    <span v-if="logbook.lecture_verify=='verified'" class="badge badge-success mb-3">Lecture Verified</span>
                    <span v-else class="badge badge-danger mb-3">Lecture Unverified</span>
                    <span style="float:right;" v-if="logbook.supervisor_verify=='verified'" class="badge badge-success mb-3">Supervisor Verified</span>
                    <span style="float:right;" v-else class="badge badge-danger mb-3">Supervisor Unverified</span>
                    </h5>
                    <h3><b>Title</b> : {{logbook.title}}</h3>
                    <hr>
                    <h3><b>Description</b> :</h3>
                    <p>{{logbook.description}}</p>
                    <hr>
                    <h3 v-if="logbook.filename!=null" ><b>File Attachments :</b></h3>
                    <img v-if="logbook.filename!=null"  class="img-rounded img-responsive" style="max-width:40%;height:200px;" :src="getFile()">
                </div>
            </div>
            <button v-if="status.show=='true'" class="btn btn-primary w-25" @click="editLog()">Edit</button>
            <button v-if="status.show=='true'" class="btn btn-danger float-right w-25" @click="deleteLog()">Delete</button>
            <button v-if="status.showVerify=='true'" @click="lectureVerifyLog()" class="btn btn-primary w-25">Verify</button>
            <button v-if="status.showVerifySV=='true'" @click="svVerifyLog()" class="btn btn-primary w-25">Verify</button>

        </div>

        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Update User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="updateLog()"  enctype="multipart/form-data">
                      <div class="modal-body">
                          <div class="form-group">
                            <label>Title</label>
                            <br>
                            <input v-model="form.title" type="text" name="title"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                            <has-error :form="form" field="title"></has-error>
                          </div>
                          <div class="form-group">
                             <label>Description</label>
                            <br>                             
                            <input v-model="form.description"  type="text" name="description" rows="3"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                            <has-error :form="form" field="description"></has-error>
                          </div>   
                          <div class="form-group">
                            <label>Date</label>
                            <br>
                            <input v-model="form.date" type="date" name="date" 
                              class="form-control" :class="{ 'is-invalid': form.errors.has('date') }">
                            <has-error :form="form" field="date"></has-error>
                          </div> 
                     <div class="form-group">
                        <label>File Attachment</label>
                        <br>
                        <input type="file" @change="checkFile" name="newFile">
                      </div>
                      </div>
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Update</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                    </form>
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
                logbook:{},
                form: new Form({
                    logbook_id:'',
                    title:'',
                    description:'',
                    date:'',
                    newFile:'',
            }),
                logbook_id:''
            }
        },
        methods:{
            checkFile(e){
               let file = e.target.files[0];
               let reader = new FileReader();
               if(file['size']< 2111775){ //2MB
               reader.onloadend=(file)=>{
                   this.form.newFile=reader.result;
               }
               reader.readAsDataURL(file);
               }else{
                   swal.fire({
                       type:'error',
                       title:'Oops...',
                       text:'You are uploading a large file',
                   })
               }

            },
            getFile(){
                return "/files/" + this.logbook.filename;
            },
            getStatus(){
                 axios.get('/api/logbook').then(response => this.status = response.data);
            },
            fetchLog(){
                const url = `/api/logbook/${this.$route.params.id}`;
                axios.get(url).then(response => this.logbook = response.data);
            },
            editLog(){
                $('#modal').modal('show');
                this.form.fill(this.logbook);
            },
            updateLog(){
                this.$Progress.start();              
                this.form.put(`/api/logbook/${this.$route.params.id}`)
                .then(()=>{
                      $('#modal').modal('hide');
                      swal.fire('Updated!','Your log has been updated.','success');
                      Fire.$emit('sendHTTPRequest');
                      this.$Progress.finish();
                })
                .catch(()=>{
                   this.$Progress.fail();              
                })
            },
            deleteLog(){
              swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
              }).then((result) => { 
                 if (result.value){
                //Send request to server 
                axios.delete('/api/logbook/'+this.$route.params.id).then(()=>{
                      swal.fire('Deleted!','Your file has been deleted.','success');
                     this.$router.go(-1);
                  }).catch(()=>{
                      swal.fire("Failed!","There was something wrong","warning");
                  });
                 }
                 else if (result.dismiss === swal.DismissReason.cancel){
                    
                  }
              })
            },
            lectureVerifyLog(){
               swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to verify this log?",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, verify it!'
                }).then((result) => { 
                    if (result.value){
                        if(this.logbook.lecture_verify=="unverified"){
                            axios.post('/api/logbook/verifyLog/'+this.$route.params.id);
                            swal.fire('Verified!','You have verified this log.','success');
                            setTimeout(location.reload(),3000);
                        }
                        else{
                            swal.fire("Failed!","You have verified this log!","warning");
                        }
                    }
                    else if (result.dismiss === swal.DismissReason.cancel){
                        
                    }
                })                      
            },
            svVerifyLog(){
               swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to verify this log?",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, verify it!'
                }).then((result) => { 
                    if (result.value){
                        if(this.logbook.supervisor_verify=="unverified"){
                            axios.post('/api/logbook/svVerifyLog/'+this.$route.params.id);
                            swal.fire('Verified!','You have verified this log.','success');
                            setTimeout(location.reload(),3000);
                        }
                        else{
                            swal.fire("Failed!","You have verified this log!","warning");
                        }
                    }
                    else if (result.dismiss === swal.DismissReason.cancel){
                        
                    }
                })                     
            },            
        },
        mounted() {
            console.log('Component mounted.');
            this.getStatus();
            this.fetchLog();
            Fire.$on('sendHTTPRequest',()=>{
              this.fetchLog();
            });
        }
    }
</script>
