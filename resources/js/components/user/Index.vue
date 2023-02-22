<template>
    <div>

        <div class="card-body">
            <div class="col-12">
                <button type="button" class="btn btn-primary btn-sm mb-4" @click="openModal()">
                    <i class='bx bx-user-plus'></i> Usuario
                </button>
            </div>
            <div class="table-responsive" v-if="loading">
                <table class="table" id="table_users" >
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
                                <button @click="editUser(user)" class="btn btn-sm"><i class='bx bx-edit'></i></button>
                                <button @click="deleteUser(user.id)" class="btn btn-sm"><i class='bx bx-trash'></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <spinner v-else></spinner>
        </div>
        <form-modal v-if="loading_modal" :user="selected_user" :form="form" :business="business" :roles="roles"></form-modal>
    </div>
</template>
<script>
import Spinner from '../Spinner.vue'
import Modal from './Modal.vue'
export default {
    components:{
        'form-modal' : Modal,
        Spinner
    },
    props:['role', 'business_id'],
    data(){
        return{
            users:{},
            loading_modal: false,
            selected_user:{},
            form:'insert',
            loading : false,
            roles:[],
            business:[],
        }
    },
    created(){
        this.getRoles()
        this.getUser()
        this.getBusiness()
    },
    methods:{

        getRoles(){
            axios.get('/User/Role/get').then(res=>{
                console.log(res.data)
                res.data.roles.forEach(role => {
                    this.roles.push({'name' : role.name})
                });
            }).catch(error=>{
                console.log(error.response)
            })
        },

        getBusiness(){
            axios.get('/Business/get').then(res=>{
                res.data.business.forEach(busines => {
                    this.business.push({'label' : busines.name, 'id' : busines.id})
                });
            }).catch(error=>{
                console.log(error.response)
            })
        },

        getUser(){
            this.loading = false
            axios.get(`/User/get`).then(res=>{
                console.log(res.data)
                this.users = res.data.users
                this.loading = true
                setTimeout(()=>{
                    this.loadTable()
                },200)
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

        editUser(user){
            this.selected_user = user
            this.form = 'edit'
            this.openModal()
        },

        closeModal(){
            this.selected_user = {}
            this.form = 'insert'
            $("#modalUsers").modal('hide')
            setTimeout(()=>{
                this.loading_modal = false
            },200)
        },

        deleteUser(usuario_id){
            this.$fire({
                title: 'Usuario',
                text: 'Estas Seguro de eliminar el usuario seleccionado?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#FF0000',
            }).then((result) => {
                if(result.value){
                    axios.get(`/User/delete/${usuario_id}`).then(res => {
                        if(res.data.status){
                            this.alert('Usuario', 'Eliminado', 'success')
                            var index = _.findIndex(this.users, function(o) { return o.id == usuario_id; });
                            this.users.splice(index, 1)
                            this.reLoadTable()
                        }
                    })
                }
            });
        },

        reLoadTable(){
            this.loading = false
            setTimeout(()=>{
                this.loading = true
                setTimeout(()=>{
                    this.loadTable()
                },200)
            }, 200)
        },

        loadTable(){
            $("#table_users").DataTable()
        },

        alert(titulo, text, tipo){
            this.$fire({
                title: titulo,
                text: text,
                type: tipo,
                timer: 3000
            })
        }
    }
}
</script>
