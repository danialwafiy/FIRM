<template>
    <div class="container">
    <title>Meeting | FIRM</title>
    <div class="mt-4 mb-5">
            <h2 class="text-center"><span class="badge badge-title">Meeting</span></h2>
            <br>
            <div class="row justify-content-center">
              <div class="col-md-10">
                <div class="card">
                  <div class="card-body">
                    <p class="card-text">Meeting with supervisor will be held on:</p>
                    <h4 v-if="student.meeting_date!=null" class="card-text">{{student.meeting_date }}</h4>
                    <h3 v-else class="card-text"><span class="badge ba  dge-warning">No Date Set</span></h3>
                    <hr>

                    <p class="card-text">Location:</p>
                    <h4 class="card-text text-capitalize">{{student.company_address|lowercaseALL}}, {{student.company_postcode}}, {{student.company_city|lowercaseALL}}, {{student.company_state|lowercaseALL}}</h4>
                    <hr>

                    <p class="card-text">Student status:</p>  <h4><span v-if="student.meeting_status=='confirmed'" class="badge badge-success">Confirmed</span>
                    <span v-else-if="student.meeting_status=='unconfirmed'" class="badge badge-danger">Unconfirmed</span>
                    <span v-else-if="student.meeting_status==''" class="badge badge-warning">None</span>
                    <span v-else-if="student.meeting_status=='request'" class="badge badge-warning">Requesting Change</span></h4> 
                    <div class="mt-3" v-if="student.meeting_status=='request'"> 
                      <label>Reason of change: </label>
                      <span class="badge badge-primary">{{student.meeting_msg}}</span> 
                    </div>

                    <div v-show="user=='3'">                   
                      <div class="btn-group mt-3" role="group">
                        <button v-show="student.meeting_status=='unconfirmed'" type="button" class="btn btn-primary" @click="studentConfirmDate()">Confirm Now</button>
                        <button v-show="student.meeting_status=='unconfirmed'" type="button" class="btn btn-secondary" @click="openRequestChangeModal()">Request Change</button>
                      </div>  
                    </div>
                    <div v-show="user=='2'">
                    <hr>
                        <div v-if="show.showFormSet=='true'">
                          <p class="card-text">Set date:</p>
                          <form v-if="show.showFormSet=='true'" @submit.prevent="setDate" enctype="multipart/form-data">
                            <div class="input-group">
                              <input v-model="form.date" type="date" name="date"
                                class="form-control w-50" :class="{ 'is-invalid': form.errors.has('date') }">
                              <has-error :form="form" field="date"></has-error>                        <span class="input-group-addon"><button type="submit" class="btn btn-primary">Set Date</button></span>
                            </div>
                          </form>
                        </div> 

                        <div v-if="show.showFormChange=='true'" >
                          <p class="card-text">Change date:</p>
                          <form @submit.prevent="changeDate" enctype="multipart/form-data">
                            <div class="input-group">
                              <input v-model="form.date" type="date" name="date"
                                class="form-control w-50" :class="{ 'is-invalid': form.errors.has('date') }">
                              <has-error :form="form" field="date"></has-error>                        <span class="input-group-addon"><button type="submit" class="btn btn-primary">Change Date</button></span>
                            </div>
                          </form>  
                        </div>
                    </div>    
                  </div>
                </div>
              </div>
            </div>

          <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="modalLabel">Request Change Date</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <form @submit.prevent="requestChange()"  enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                              <label>State your reason.</label>
                              <br>
                              <input v-model="changeForm.msg" type="text" name="msg"
                                class="form-control" required/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                      </form>
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
           user:'',
           show:'',
           student:'',
           form: new Form({
                date: '',
                student_id:''
            }), 
          changeForm: new Form({
                msg:''
            })        
          }
        },
        methods:{
          openRequestChangeModal(){
                $('#modal').modal('show');
          },
          getUserType(){
            axios.get('/api/meeting/getUserType').then(response => this.user = response.data); 
          },
          studentConfirmDate(){
               swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to confirm the date?",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, verify it!'
                }).then((result) => { 
                    if (result.value){
                            axios.post('/api/meeting/studentConfirmDate');
                            swal.fire('Verified!','You have confirmed the date.','success');
                            setTimeout(location.reload(),3000);

                    }
                    else if (result.dismiss === swal.DismissReason.cancel){
                        
                    }
                }) 
          },
          getShowForm(){
            axios.get(`/api/meeting/showForm/${this.$route.params.id}`).then(response => this.show = response.data);

          },
          getCurrentDate(){
            axios.get(`/api/meeting/getCurrentDate/${this.$route.params.id}`).then(response => this.student = response.data);
          },
          requestChange(){
          swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to request date change?",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Request please!'
                }).then((result) => { 
                    if (result.value){
                            this.changeForm.post('/api/meeting/requestChange');
                            swal.fire('Submitted!','You have requested a date change.','success');
                          $('#modal').modal('hide');
                          setTimeout(location.reload(),3000);

                    }
                    else if (result.dismiss === swal.DismissReason.cancel){
                        
                    }
                }) 
          },
          changeDate(){
              swal.fire({
              title: 'Are you sure you want to change?',
              text: "Make sure all informations are correct!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
              }).then((result) => { 
                 if (result.value){
                //Send request to server 
                  this.form.student_id=this.$route.params.id; 
                  this.form.post('/api/meeting/changeDate').then(()=>{
                      swal.fire('Success!','Meeting date has been change.','success');
                      setTimeout(location.reload(),3000);
                  }).catch(()=>{
                      swal.fire("Failed!","There was something wrong","warning");
                  });
                 }
                 else if (result.dismiss === swal.DismissReason.cancel){
                    
                  }
              }) 
          },
          setDate(){
              swal.fire({
              title: 'Are you sure?',
              text: "Make sure all informations are correct!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes'
              }).then((result) => { 
                 if (result.value){
                //Send request to server
                  this.form.student_id=this.$route.params.id; 
                  this.form.post('/api/meeting').then(()=>{
                      swal.fire('Success!','Meeting date has been set.','success');
                      setTimeout(location.reload(),3000);
                  }).catch(()=>{
                      swal.fire("Failed!","There was something wrong","warning");
                  });
                 }
                 else if (result.dismiss === swal.DismissReason.cancel){
                    
                  }
              }) 
          }
        },
        mounted() {
            this.getCurrentDate(),
            this.getUserType(),
            this.getShowForm(),
            console.log('Component mounted.')
        }
    }
</script>