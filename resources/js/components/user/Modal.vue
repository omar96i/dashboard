<template>
    <!-- Modal -->
    <div class="modal fade" id="modalUsers" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">Formulario de registro</h5>
                    <button
                    @click="$parent.closeModal()"
                    type="button"
                    class="btn-close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="card-body row">

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" v-model="data.user.email">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" v-model="data.user.password">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Empresa</label>
                                <v-select label="label" :options="options" v-model="data.user.business_id" :reduce="option => option.id"></v-select>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Documento</label>
                                <input type="number" class="form-control" v-model="data.personal_information.id_card">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" v-model="data.personal_information.full_name">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Direccion</label>
                                <input type="text" class="form-control" v-model="data.personal_information.address">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Telefono fijo</label>
                                <input type="number" class="form-control" v-model="data.personal_information.landline">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Codigo de pais</label>
                                <input type="number" class="form-control" v-model="data.personal_information.country_code">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Telefono</label>
                                <input type="number" class="form-control" v-model="data.personal_information.phone">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Ciudad</label>
                                <input type="text" class="form-control" v-model="data.personal_information.city">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Departamento</label>
                                <input type="text" class="form-control" v-model="data.personal_information.department">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-outline-secondary" @click="$parent.closeModal()">
                    Close
                    </button>
                    <button type="button" class="btn btn-primary" @click="action()">{{ (form == 'insert') ? 'Agregar' : 'Actualizar' }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default{
    props:['user', 'form'],
    data(){
        return{
            data:{
                'user':{},
                'personal_information':{}
            },
            options:[{'label' : 'empresa 1', 'id' : 1}],
            route: (this.form == 'insert') ? '/User/store' : `/User/update/${this.user.id}`
        }
    },
    created(){
        if(this.form == 'edit'){
            this.data.user.id = this.user.id
            this.data.user.email = this.user.email
            this.data.user.business_id = this.user.business_id
            this.data.user.password = ''
            this.data.personal_information.address = this.user.personal_information.address
            this.data.personal_information.city = this.user.personal_information.city
            this.data.personal_information.id_card = this.user.personal_information.id_card
            this.data.personal_information.country_code = this.user.personal_information.country_code
            this.data.personal_information.department = this.user.personal_information.department
            this.data.personal_information.full_name = this.user.personal_information.full_name
            this.data.personal_information.landline = this.user.personal_information.landline
            this.data.personal_information.phone = this.user.personal_information.phone
        }
    },
    methods:{
        action(){
            axios.post(this.route, this.data).then(res=>{
                if(this.form == 'insert' && res.data.status){
                    this.$parent.users.push(res.data.user)
                    return
                }
                var index = _.findIndex(this.$parent.users, function(o) { return o.id == res.data.user.id; });
                this.$parent.users[index] = res.data.user
            }).catch(error=>{
                console.log(error.response)
            })
        }
    }
}
</script>
