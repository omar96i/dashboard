<template>
    <!-- Modal -->
    <div class="modal fade" id="modalBusiness" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">Formulario de Registro</h5>
                    <button @click="$parent.closeModal()" type="button" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body row">

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre:</label>
                                <input type="text" :class="[{'is-invalid' : validation.name }, 'form-control']" v-model="data.business.name">
                                <div class="invalid-feedback">
                                    Por favor ingrese el nombre de la empresa
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">País:</label>
                                <input type="text" :class="[{'is-invalid' : validation.country }, 'form-control']" v-model="data.business.country">
                                <div class="invalid-feedback">
                                    Por favor seleccione un País valido
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Zona Horaria:</label>
                                <v-select label="label" :options="options" v-model="data.business.time_zone" :reduce="option => option.id" :class="[{'is-invalid' : validation.time_zone}]" ></v-select>
                                <div class="invalid-feedback">
                                    Por favor seleccione una Zona Horaria
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Logo:</label>
                                <input type="text" :class="[{'is-invalid' : validation.path_icon }, 'form-control']" v-model="data.business.path_icon">
                                <div class="invalid-feedback">
                                    Por favor seleccione una imagen valida para el Logo
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Descripción: </label>
                                <textarea type="text" :class="[{'is-invalid' : validation.description }, 'form-control']" v-model="data.business.description"> </textarea>
                                <div class="invalid-feedback">
                                    Por favor ingrese una descripcion valida
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-outline-secondary" @click="$parent.closeModal()">
                    Close
                    </button>
                    <button type="button" @click="accion()" class="btn btn-primary" >{{ (form == 'insert') ? 'Agregar' : 'Actualizar' }}</button>
                </div>
                
                <content-spinner v-if="loading_spinner" :message="text_spinner"></content-spinner>
            </div>
        </div>
    </div>
</template>
<script>
import Spinner from '../custom/Spinner.vue'
import helper_option from '../../helpers/zona_horaria.js'
export default{
    props:['business', 'form'],
    components:{
        'content-spinner': Spinner,
    },
    data(){
        return{
            data:{
                'business': {   'name':'',
                                'country':'',
                                'time_zone':'',
                                'path_icon':'',
                                'description':''
                            },
            },
            validation:{
                            'name':false,
                            'country':false,
                            'time_zone':false,
                            'path_icon':false,
                            'description':false
                        },
            options: [],
            route: (this.form=="insert")? `/Business/store` : `/Business/update/${this.business.id}`, 
            loading_spinner: false,
            text_spinner: "cargando"
        }
    },
    created(){
        if (this.form=="edit") {
            this.data.business = this.business
        }
        this.options = helper_option.optionsZonaHoraria 
    },
    methods:{
        
        accion(){
            console.log("data del formulario: ")
            console.log(this.data.business)

            if(this.validationForm()){
                this.text_spinner = (this.form=="insert")? "Creando Empresa" : "Actualizando datos de la Empresa";
                this.loading_spinner = true;
                axios.post(this.route, this.data).then(res=>{
                    if (this.form=="edit" && res.data.status) {
                        let index = _.find(this.$parent.business_list, function(i){ return i.id == res.data.business.id })
                        this.$parent.business_list[index] = res.data.business
                        this.$parent.closeModal()
                    } 
                    if (this.form=="insert" && res.data.status){
                        this.$parent.business_list.push(res.data.business)
                        this.$parent.closeModal()
                    }
                }).catch(error=>{
                    console.log(error.response)
                }).finally(()=>{
                    this.loading_spinner = false;
                })
            } else {
                this.$fire({
                    title: "Error en validación de datos",
                    text: "Todos los campos del formulario son obligatorios.",
                    type: "warning",
                    confirmButtonText: "Entendido"
                })
            }
        },

        validationForm(){
            if (this.data.business.name!="" && this.data.business.country!="" && this.data.business.time_zone!="" && this.data.business.path_icon!="" && this.data.business.description!="") {
                return true;
            }

            this.validation.name = (this.data.business.name=="");
            this.validation.country = (this.data.business.country=="");
            this.validation.time_zone = (this.data.business.time_zone=="");
            this.validation.path_icon = (this.data.business.path_icon=="");
            this.validation.description = (this.data.business.description=="");
            return false;
        },

    }
}
</script>
