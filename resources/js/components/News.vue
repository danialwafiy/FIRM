<style>
    a:hover{
        color:black;
        background-color:#F4F6F9;
    }
</style>

<template>
    <div class="container">
    <title>News | FIRM</title>
        <div class="mt-4 mb-5">
            <h2 class="text-center"><span class="badge badge-title">News</span></h2>
            <br>  
                <button class="btn btn-success mb-3" @click="addNews">Add News</button>
                <nav>
                <ul class="pagination ">
                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchNews(pagination.prev_page_url)">Previous</a></li>
                    <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                    <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#"  @click="fetchNews(pagination.next_page_url)">Next</a></li>
                </ul>   
                </nav>
                <div style="text-decoration:none" class="black card card-body mb-3" v-for="newz in news" v-bind:key="newz.news_id">
                    <h6 class="card-subtitle text-muted">{{newz.date | dateFormatNum }}</h6>
                    <hr>
                    <h5 class="card-title">{{newz.title}}</h5>
                    <p class="card-text">{{ newz.description | truncate(300)}}</p>
                    <hr>
                    <h5><b>File Attachment</b> :</h5>
                    <img v-if="newz.filename!=null"  class="img-rounded img-responsive" style="max-width:150px;height:150px;" :src="getFile(newz.filename)">
                    <hr>
                    <div class="row col-md-12 mx-auto">
                        <button class="btn btn-primary col-md-5 mb-1     mx-auto"  @click="openEditModal(newz)">Edit News</button>
                        <button class="btn btn-danger col-md-5"  @click="deleteNews(newz.news_id)" >Deletes News</button>       
                    </div>
               </div>
        </div>       

        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Update News</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="updateNews()">
                      <div class="modal-body">
                          <div class="form-group">
                              <div class="label">Title</div>
                            <input v-model="form.title" type="text" name="title"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                            <has-error :form="form" field="title"></has-error>
                          </div>
                          <div class="form-group">
                              <div class="label">Description</div>
                            <input v-model="form.description" type="text" name="description"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                            <has-error :form="form" field="description"></has-error>
                          </div>   
                          <div class="form-group">
                              <div class="label">Date</div>
                            <input v-model="form.date" type="date" name="date" 
                              class="form-control" :class="{ 'is-invalid': form.errors.has('date') }">
                            <has-error :form="form" field="date"></has-error>
                          </div>  
                        <div class="form-group">
                              <div class="label">File Attachment</div>
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
            news:[],
            pagination:{},
            news_id:'',
            form: new Form({
                news_id:'',
                title:'',
                description:'',
                date:'',
                newFile:'',
            }),
        }
    },

    created(){
        this.fetchNews();
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
        getFile($id){
                return "/files/" + $id;
        },
        updateNews(){
                this.$Progress.start();              
                this.form.put('api/news/'+this.form.news_id)
                .then(()=>{
                      $('#modal').modal('hide');
                      swal.fire('Updated!','Your news has been updated.','success');
                      this.$Progress.finish();
                      setTimeout(location.reload(),2000);
                })
                .catch(()=>{
                  swal.fire('Oops!','Something went wrong.','danger');
                   this.$Progress.fail();              
                })
        },
        openEditModal(newz){
            $('#modal').modal('show');
            this.form.fill(newz);
        },
        addNews(){
            this.$router.push('/news-add')
        },
        fetchNews(page_url){
            let vm=this;
            page_url=page_url || '/api/news'
            fetch(page_url).then(res=>res.json()).then(res=>{
                this.news = res.data;
                vm.makePagination(res.meta,res.links);
            })
            .catch(err=>console.log(err));
        },
        deleteNews($id){
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
                axios.delete('/api/news/'+$id).then(()=>{
                      swal.fire('Deleted!','Your news has been deleted.','success');
                     setTimeout(location.reload(),2000);
                  }).catch(()=>{
                      swal.fire("Failed!","There was something wrong","warning");
                  });
                 }
                 else if (result.dismiss === swal.DismissReason.cancel){
                    
                  }
              })            
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
    }
}
</script>

