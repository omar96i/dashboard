<template>
    <!-- Modal -->
    <div class="modal fade" id="modalUsers" data-bs-backdrop="static" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">Registrar nuevo usuario</h5>
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
                                <input type="email" :class="[{'is-invalid' :  validation.user.email }, 'form-control']" v-model="data.user.email">
                                <div class="invalid-feedback">
                                    {{ (aux) ? "Por favor ingresa un correo" : "El correo ya se encuentra registrado" }}
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Contraseña</label>
                                <input type="password" :class="[{'is-invalid' : validation.user.password }, 'form-control']" v-model="data.user.password">
                                <div class="invalid-feedback">
                                    Por favor ingresa una contraseña
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Empresa</label>
                                <v-select label="label" :options="business" v-model="data.user.business_id" :reduce="option => option.id" :class="[{'is-invalid' : validation.user.business_id }]"></v-select>
                                <div class="invalid-feedback">
                                    Por favor Selecciona una empresa
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Documento</label>
                                <input type="number" :class="[{'is-invalid' : validation.personal_information.id_card }, 'form-control']" v-model="data.personal_information.id_card">
                                <div class="invalid-feedback">
                                    Por favor ingresa un documento
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre completo</label>
                                <input type="text" :class="[{'is-invalid' : validation.personal_information.full_name }, 'form-control']" v-model="data.personal_information.full_name">
                                <div class="invalid-feedback">
                                    Por favor ingresa el nombre
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Direccion</label>
                                <input type="text" :class="[{'is-invalid' : validation.personal_information.address }, 'form-control']" v-model="data.personal_information.address">
                                <div class="invalid-feedback">
                                    Por favor ingresa la direccion
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Telefono fijo</label>
                                <input type="number" :class="[{'is-invalid' : validation.personal_information.landline }, 'form-control']" v-model="data.personal_information.landline">
                                <div class="invalid-feedback">
                                    Por favor ingresa un telefono
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Telefono</label>
                                <vue-tel-input
                                    v-model="data.personal_information.phone"
                                    :defaultCountry="(this.form == 'insert') ? 'CO' : this.data.personal_information.iso"
                                    v-on:country-changed="setCountry"
                                    :class="[{'is-invalid' : validation.personal_information.phone }, 'form-control']"
                                ></vue-tel-input>
                                <div class="invalid-feedback">
                                    Por favor ingresa un telefono
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Ciudad</label>
                                <input type="text" :class="[{'is-invalid' : validation.personal_information.city }, 'form-control']" v-model="data.personal_information.city">
                                <div class="invalid-feedback">
                                    Por favor ingresa la ciudad
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Departamento</label>
                                <input type="text" :class="[{'is-invalid' : validation.personal_information.department }, 'form-control']" v-model="data.personal_information.department">
                                <div class="invalid-feedback">
                                    Por favor ingresa el departamento
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <v-select label="name" :options="roles" v-model="data.role.name"  :reduce="option => option.name" :class="[{'is-invalid' : validation.role.name }]"></v-select>
                                <div class="invalid-feedback">
                                    Por favor Selecciona un Role
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer" v-if="!loading">
                    <button type="button" class="btn btn-outline-secondary" @click="$parent.closeModal()">
                    Cerrar
                    </button>
                    <button type="button" class="btn btn-primary" @click="action()">{{ (form == 'insert') ? 'Agregar' : 'Actualizar' }}</button>
                </div>
                <div class="modal-footer" v-else>
                    <spinner></spinner>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Spinner from '../Spinner.vue'
export default{
    components:{
        Spinner
    },
    props:['user', 'form', 'business', 'roles'],
    data(){
        return{
            data:{
                'user':{
                    'email' : '',
                    'business_id' : '',
                },
                'personal_information':{
                    'address' : '',
                    'city' : '',
                    'iso' : '',
                    'id_card' : '',
                    'country_code' : '',
                    'department' : '',
                    'full_name' : '',
                    'landline' : '',
                    'phone' : ''
                },
                'role' : {
                    'name' : ''
                }
            },
            validation:{
                'user':{
                    'email' : false,
                    'business_id' : false,
                },
                'personal_information':{
                    'address' : false,
                    'city' : false,
                    'iso' : false,
                    'id_card' : false,
                    'country_code' : false,
                    'department' : false,
                    'full_name' : false,
                    'landline' : false,
                    'phone' : false
                },
                'role' : {
                    'name' : false
                }
            },
            route: (this.form == 'insert') ? '/User/store' : `/User/update/${this.user.id}`,
            loading : false,
            aux : true
        }
    },
    created(){
        if(this.form == 'edit'){
            this.data.user.id = this.user.id
            this.data.user.email = this.user.email
            this.data.user.business_id = this.user.business_id
            this.data.user.password = ''
            this.data.role.name = (this.user.roles.length > 0) ? this.user.roles[0].name : ''
            this.data.personal_information.address = this.user.personal_information.address
            this.data.personal_information.city = this.user.personal_information.city
            this.data.personal_information.iso = this.user.personal_information.iso
            this.data.personal_information.id_card = this.user.personal_information.id_card
            this.data.personal_information.country_code = this.user.personal_information.country_code
            this.data.personal_information.department = this.user.personal_information.department
            this.data.personal_information.full_name = this.user.personal_information.full_name
            this.data.personal_information.landline = this.user.personal_information.landline
            this.data.personal_information.phone = this.user.personal_information.phone
        }

    },
    methods:{
        setCountry(event){
            if(this.form == 'insert'){
                this.data.personal_information.country_code = event.dialCode
                this.data.personal_information.iso = event.iso2
            }
        },

        action(){
            if(this.validationForm()){
                this.loading = true
                axios.post(this.route, this.data).then(res=>{
                    if(this.form == 'insert' && res.data.status){
                        this.alert('Usuario', res.data.msg, 'success')
                        this.$parent.users.push(res.data.user)
                    }else if(this.form == 'edit' && res.data.status){
                        this.alert('Usuario', res.data.msg, 'success')
                        var index = _.findIndex(this.$parent.users, function(o) { return o.id == res.data.user.id; });
                        this.$parent.users[index] = res.data.user
                    }else{
                        this.aux = res.data.status
                        this.validation.user.email = true
                        return
                    }
                    this.$parent.closeModal()
                    this.$parent.reLoadTable()
                }).catch(error=>{
                    this.alert('Usuario', 'Error en el servidor', 'error')
                    console.log(error.response)
                }).finally(r=>{
                    this.loading = false
                })
            }
        },

        validationForm(){
            if(
                this.data.user.email != '' &&
                this.data.user.business_id != '' &&
                this.data.personal_information.full_name != '' &&
                this.data.personal_information.address != '' &&
                this.data.personal_information.city != '' &&
                this.data.personal_information.id_card != '' &&
                this.data.personal_information.department != '' &&
                this.data.personal_information.landline != '' &&
                this.data.personal_information.phone != '' &&
                this.data.role.name != ''
            ){
                return true
            }
            this.validation.user.email = ( this.data.user.email != '') ? false : true
            this.validation.user.business_id = ( this.data.user.business_id != '') ? false : true
            if(this.form == 'insert'){
                this.validation.user.password = ( this.data.user.password != '') ? false : true
            }
            this.validation.personal_information.address = ( this.data.personal_information.address != '') ? false : true
            this.validation.personal_information.city = ( this.data.personal_information.city != '') ? false : true
            this.validation.personal_information.id_card = ( this.data.personal_information.id_card != '') ? false : true
            this.validation.personal_information.department = ( this.data.personal_information.department != '') ? false : true
            this.validation.personal_information.full_name = ( this.data.personal_information.full_name != '') ? false : true
            this.validation.personal_information.landline = ( this.data.personal_information.landline != '') ? false : true
            this.validation.role.name = (this.data.role.name != '') ? false : true
            this.validation.personal_information.phone = ( this.data.personal_information.phone != '') ? false : true
            return false
        },

        alert(titulo, text, tipo){
            this.$fire({
                title: titulo,
                text: text,
                type: tipo,
            })
        }
    }
}
</script>
