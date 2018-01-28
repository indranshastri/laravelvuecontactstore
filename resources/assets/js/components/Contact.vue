<template>
    <div>
       <h1> Add Contacts </h1>

        <form action="#" @submit.prevent="edit ? updateContact(contact.id) : createContact()"> 
            <div class="form-group" >
                <label for="name">Name</label>
                <input v-model="contact.name" type="text" class="form-control" name="name"/>
            </div>
             <div class="form-group">
                <label for="email">Email</label>
                <input v-model="contact.email" type="text" class="form-control" name="email"/>
            </div>
             <div class="form-group">
                <label for="phone">Phone</label>
                <input v-model="contact.phone" type="text" class="form-control" name="phone"/>
            </div>

            <div class="form-group">
                <button v-show="!edit" type="submit" name="Submit" class="btn btn-primary">Submit Contact</button>               
                <button v-show="edit" type="submit" name="Submit" class="btn btn-primary">Update Contact</button>
            </div>
        </form>
        <hr>
       <h1> Contacts </h1>
        <ul class="list-group">
            <li class="list-group-item" v-for="contact in list">
               <strong> {{contact.conctact}} </strong>{{contact.email}} {{contact.phone}} 
               <button @click="showContact(contact.id)" class="btn btn-default  btn-xs">Edit</button>
               <button @click="deleteContact(contact.id)" class="btn btn-danger  btn-xs">Delete</button>
               
            </li>
        </ul>

    </div>
</template>

<script>
    export default {
        data:function(){
            return {
                "edit":false,
                "list":[],
                "contact":{
                    'id':"",
                    "name":"",
                    "phone":"",
                    "email":""
                    
                }
            }
        },
        mounted() {
            console.log('Contacts Component mounted.');
            this.fetchContactList();
        },
        methods:{
            fetchContactList:function(){
                console.log("fetch contact");
               axios.get('api/contacts').then((response)=>{
                   console.log(response);
                   this.list = response.data;
               }).catch((error)=>{
                   console.log(error);
               });

            },
            createContact:function(){
                console.log("create Contect");
                let self = this;
                let params = Object.assign({},self.contact);
                axios.post('api/contact/store',params)
                .then(function() {
                    self.contact.name = "";
                    self.contact.email = "";
                    self.contact.phone = "";
                    self.fetchContactList();
                })
                .catch(function(error){
                    console.log(error);
                })
                return;

            },
            updateContact:function(id){
                console.log("update Contect");
                let self = this;
                let params = Object.assign({},self.contact);
                axios.patch('api/contact/'+id,params)
                .then(function() {
                    self.contact.name = "";
                    self.contact.email = "";
                    self.contact.phone = "";
                    self.fetchContactList();
                })
                .catch(function(error){
                    console.log(error);
                })
                self.edit=false;
                return;              
            },
            showContact:function(id){
                console.log("show Contact called");
                let self = this;
                axios.get('api/contact/'+id)
                .then(function(response) {
                    self.contact.name = response.data.conctact
                    self.contact.email = response.data.email;
                    self.contact.phone = response.data.phone;
                    self.contact.id = response.data.id;
                })
                .catch(function(error){
                    console.log(error);
                });
                self.edit=true;
            },
            deleteContact:function(id){
                let self = this;
                axios.delete("api/contact/"+id)
                .then(function(){
                     self.fetchContactList();
                })
                .catch(function(error){
                    console.log(error);
                    
                })
            }
        }
    }
</script>
