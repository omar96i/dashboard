<template>
    <!-- Modal -->
    <div class="modal fade" id="modalRoute" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
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
                                <label class="form-label">Empresa:</label>
                                <input type="text" :class="[{'is-invalid' : validation.route.business_id }, 'form-control']" v-model="data.business.name" :disabled="true">
                                <div class="invalid-feedback">
                                    Por favor seleccione una empresa valida
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre Ruta:</label>
                                <input type="text" :class="[{'is-invalid' : validation.route.name }, 'form-control']" v-model="data.route.name">
                                <div class="invalid-feedback">
                                    Por favor ingrese el nombre de la Ruta
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12" v-if="disabled_business">
                            <div class="mb-3">
                                <label class="form-label">Cobrador: </label>
                                <v-select label="label" :options="collectors_options" v-model="data.route_collector.collector_id" :reduce="option => option.id"></v-select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-outline-secondary" @click="$parent.closeModal()">
                    Close
                    </button>
                    <button type="button" @click="action()" class="btn btn-primary" >{{ (form == 'insert') ? 'Agregar' : 'Actualizar' }}</button>
                </div>
                
                <content-spinner v-if="loading_spinner" :message="text_spinner"></content-spinner>
            </div>
        </div>
    </div>
</template>
<script>
import Spinner from '../../custom/Spinner.vue'
import message_spanish from '../../../helpers/messages_in_spanish.js'
export default{
    props:['route', 'form'],
    components:{
        'content-spinner': Spinner,
    },
    data(){
        return{
            data:{
                route:{
                    'business_id':'',
                    'name':''
                },
                business: {
                    'id':'',
                    'name':''
                }
                ,
                route_collector:{
                    'collector_id':''
                }
            },
            validation:{
                'route':{
                    'business_id':false,
                    'name':false,
                    'start_date':false,
                    'end_date':false,
                    'status':false
                },
                'route_collector':{
                    'collector_id':false
                }
            },
            collectors_options:[],
            loading_spinner: false,
            text_spinner: "cargando"
        }
    },
    created(){
        if (this.$parent.business_id) {
            this.data.route.business_id = parseInt(this.$parent.business_id);
        }

        // Cargando datos de edicion
        if (this.form=="edit") {
            this.data.business.id = this.route.business.id
            this.data.business.name = this.route.business.name

            this.data.route.business_id = this.route.business_id
            this.data.route.name = this.route.name
            
            this.disabled_business = true
            for (var i = 0; i < this.route.route_collector.length; i++) {
                if (this.route.route_collector[i].status=="active"){
                    this.data.route_collector.collector_id = this.route.route_collector[i].collector_id
                    break
                }
            }
            
            this.getCobradoresEmpresa(this.route.business_id)
        }
    },
    methods:{
        getCobradoresEmpresa(business_id){
            if (business_id!=undefined && business_id!='') {
                this.collectors_options = []
                axios.get(`/Business/getCollectors/${business_id}`).then(res=>{
                    console.log(res.data)
                    for (var i = 0; i < res.data.collectors.length; i++) {
                        this.collectors_options.push( {'label':res.data.collectors[i].personal_information.full_name, 'id':res.data.collectors[i].id} )
                    }
                }).catch(error=>{
                    this.$alertGlobal(message_spanish.errorInServer)
                    console.log(error.response)
                })
            }
        },

        action(){
            if (this.validationForm()){
                this.loading_spinner = true
                this.text_spinner = "Actualizando Ruta"
                axios.post(`/Route/update/${this.route.id}`, this.data).then(res=>{
                    var index = _.findIndex(this.$parent.routes, function(o) { return o.id == res.data.route.id; });
                    this.$parent.routes[index] = res.data.route
                    this.$parent.closeModal()
                    this.$alertGlobal(message_spanish.successUpdate)
                }).catch(error=>{
                    this.$alertGlobal(message_spanish.errorInServer)
                    console.log(error.response)
                }).finally(r=>{
                    this.loading_spinner = false
                })
            }else{
                this.$alertGlobal(message_spanish.errorValidationUpdate)
            }
        },

        validationForm(){
            if (this.data.route.business_id && this.data.route.name) {
                return true;
            }
            this.validation.route.business_id = (this.data.route.business_id)? false : true;
            this.validation.route.name = (this.data.route.name)? false : true;
            return false;
        },
    }
}
</script>
