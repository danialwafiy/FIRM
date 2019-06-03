<template>
    <div class="container"> 
    <title>Internship | FIRM</title>
        <div class="mt-4">
            <h2 class="text-center"><span class="badge badge-title">Lectures Status</span></h2>
            <br> 
        </div>
   </div> 
</template>

<script>
    export default {
        data () {
            return {
            // Create a new form instance
            form: new Form({
            })
            }
        },
        methods:{
            addLog(){
                this.form.post('api/logbook')            
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
