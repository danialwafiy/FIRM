<template>
    <div class="container"> 
    <title>Add Logbook | FIRM</title>
    <div class="mt-4 mb-5">
        <h2 class="text-center"><span class="badge badge-title">Add New Log</span></h2>
        <br>                
        <form @submit.prevent="addLog" enctype="multipart/form-data" class="mb-5">

            <div class="form-group">
            <label>Date</label>
            <input v-model="form.date" type="date" name="date"
                class="form-control w-25" :class="{ 'is-invalid': form.errors.has('date') }">
            <has-error :form="form" field="date"></has-error>
            </div>

            <div class="form-group">
            <label>Title</label>
            <input v-model="form.title" type="text" name="title"
                class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
            <has-error :form="form" field="title"></has-error>
            </div>

            <div class="form-group">
            <label>Description</label>
            <textarea v-model="form.description" type="text" name="description" rows="3"
                class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
            <has-error :form="form" field="description"></has-error>
            </div>

            <div class="form-group">
            <label>File Attachment</label>
            <br>
            <input type="file" @change="checkFile" name="filename">
            </div>

            <button type="submit" class="btn btn-primary mt-3 w-100">Add</button>
        </form>
    </div>
   </div> 
</template>

<script>    
    export default {
        data () {
            return {
            // Create a new form instance
            form: new Form({
                title: '',
                description: '',
                date: '',
                filename:'',
            })
            }
        },
        methods:{
            checkFile(e){
               let file = e.target.files[0];
               let reader = new FileReader();
               if(file['size']< 2111775){ //2MB
               reader.onloadend=(file)=>{
                   this.form.filename=reader.result;
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
            addLog(){
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
                this.$Progress.start();
                //Send request to server 
                  this.form.post('api/logbook').then(()=>{
                     this.$Progress.finish();
                      swal.fire('Success!','Your log has been added.','success');
                     this.$router.go(-1);

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
            console.log('Component mounted.')
        }
    }
</script>
