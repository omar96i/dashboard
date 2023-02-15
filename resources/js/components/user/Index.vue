<template>
    <div>
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Email</th>
                        <th scope="col">Full name</th>
                        <th scope="col">Empresa</th>
                        <th scope="col">Direccion</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">codigo pais</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Ciudad</th>
                        <th scope="col">Departamento</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users" :key="index">
                        <td>{{ user.email }}</td>
                        <td>{{ user.personal_information.full_name }}</td>
                        <td>{{ user.business.name }}</td>
                        <td>{{ user.personal_information.address }}</td>
                        <td>{{ user.personal_information.landline }}</td>
                        <td>{{ user.personal_information.country_code }}</td>
                        <td>{{ user.personal_information.phone }}</td>
                        <td>{{ user.personal_information.city }}</td>
                        <td>{{ user.personal_information.department }}</td>
                        <td>
                            <button @click="editar(user)">editar</button>
                            <button @click="eliminar(user.id)">eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-primary mr-4" @click="openModal()">
            Nuevo registro
        </button>
        <form-modal v-if="loading_modal" :user="user" :form="form"></form-modal>
    </div>
</template>
<script>
import Modal from './Modal.vue'
export default {
    components:{
        'form-modal' : Modal
    },
    data(){
        return{
            users:{},
            loading_modal: false,
            user:{},
            form:'insert'
        }
    },
    created(){
        this.getUser()
    },
    methods:{

        getUser(){
            axios.get(`/User/get`).then(res=>{
                this.users = res.data.users
            }).catch(error=>{
                console.log(error.response)
            })
        },

        openModal(){
            this.loading_modal = true
            setTimeout(()=>{
                $("#modalUsers").modal('show')
            },200)
        },

        editar(user){
            this.user = user
            this.form = 'edit'
            this.openModal()
        },

        closeModal(){
            this.user = {}
            this.form = 'insert'
            $("#modalUsers").modal('hide')
            setTimeout(()=>{
                this.loading_modal = false
            },200)
        },
        eliminar(id){
            axios.get(`/User/delete/${id}`).then(res=>{
                console.log(res.data)
            }).catch(res=>{
                console.log(res.response)
            })
        }
    }
}
</script>
