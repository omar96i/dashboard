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
                                <v-select label="label" :options="business_options" v-model="data.route.business_id" :reduce="option => option.id" :class="[{'is-invalid' : validation.route.business_id}]" :disabled="disabled_business || $parent.role=='admin'" ></v-select>
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

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha de Inicio:</label>
                                <input type="date" :class="[{'is-invalid' : validation.route.start_date }, 'form-control']" v-model="data.route.start_date">
                                <div class="invalid-feedback">
                                    Por favor seleccione una Fecha Inicial
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha Finalizacion:</label>
                                <input type="date" :class="[{'is-invalid' : validation.route.end_date }, 'form-control']" v-model="data.route.end_date">
                                <div class="invalid-feedback">
                                    Por favor seleccione una Fecha Final
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6" v-if="disabled_business">
                            <div class="mb-3">
                                <label class="form-label">Estado:</label>
                                <v-select label="label" :options="options_status_route" v-model="data.route.status" :reduce="option => option.id" :class="[{'is-invalid' : validation.route.status}]"></v-select>
                                <div class="invalid-feedback">
                                    Por favor seleccione una Fecha Inicial
                                </div>
                            </div>
                        </div>

                        <div class="col-12" v-if="disabled_business">
                            <div class="mb-3">
                                <label class="form-label">Cobrador: </label>
                                <v-select label="label" :options="collectors_options" v-model="data.route_collector.collector_id" :reduce="option => option.id" :class="[{'is-invalid' : validation.route_collector.collector_id}]" ></v-select>
                                <div class="invalid-feedback">
                                    Por favor seleccione un Cobrador
                                </div>
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
export default{
    props:['route', 'form', 'business_list'],
    components:{
        'content-spinner': Spinner,
    },
    data(){
        return{
            data:{
                route:{
                    'business_id':'',
                    'name':'',
                    'start_date':'',
                    'end_date':'',
                    'status':''
                },
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
            options_status_route: [
                            {'label':'ACTIVA', 'id':'active'},
                            {'label':'INACTIVA', 'id':'inactive'}
                          ],
            business_options:[],
            collectors_options:[],
            route_axios: (this.form == 'insert')? '/Route/store' : `/Route/update/${this.route.id}`,
            loading_spinner: false,
            disabled_business: false,
            text_spinner: "cargando"
        }
    },
    created(){
        if (this.$parent.business_id) {
            this.data.route.business_id = parseInt(this.$parent.business_id);
        }

        // Cargando Lista de Empresas - Vienen del index para ahorar proceso
        for (var i = 0; i < this.business_list.length; i++) {
            this.business_options.push( {'label':this.business_list[i].name, 'id':this.business_list[i].id} )
        }


        // Cargando datos de edicion
        if (this.form=="edit") {
            this.data.route.business_id = this.route.business_id
            this.data.route.name = this.route.name
            this.data.route.start_date = this.route.start_date
            this.data.route.end_date = this.route.end_date
            this.data.route.status = this.route.status
            
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
                    console.log(error.response)
                })
            }
        },

        action(){

            if (this.form=="edit") {
                if (this.validationForm()){
                    this.loading_spinner = true
                    this.text_spinner = "Actualizando Ruta"
                    axios.post(this.route_axios, this.data).then(res=>{
                        var index = _.findIndex(this.$parent.routes, function(o) { return o.id == res.data.route.id; });
                        this.$parent.routes[index] = res.data.route
                        this.alert('Ruta', 'Editada con éxito', 'success')
                        this.$parent.closeModal()
                    }).catch(error=>{
                        this.alert('Ruta', 'Error en el servidor', 'error')
                        console.log(error.response)
                    }).finally(r=>{
                        this.loading_spinner = false
                    })
                }else{
                    this.$fire({
                        title: "Error en validación de datos",
                        text: "Todos los campos del formulario son obligatorios.",
                        type: "warning",
                        confirmButtonText: "Entendido"
                    })
                }
            }else if (this.form=="insert") {
                if (this.validationForm()){
                    let temp =  {   
                                    'business_id':this.data.route.business_id,
                                    'name':this.data.route.name,
                                    'start_date':this.data.route.start_date,
                                    'end_date':this.data.route.end_date,
                                    'status':'active'
                                }

                    this.loading_spinner = true
                    this.text_spinner = "Insertando Ruta"
                    axios.post(this.route_axios, {'route':temp}).then(res=>{
                        this.$parent.routes.push(res.data.route)
                        this.alert('Ruta', 'Creacion exitosa', 'success')
                        this.$parent.closeModal()
                    }).catch(error=>{
                        this.alert('Ruta', 'Error en el servidor', 'error')
                        console.log(error.response)
                    }).finally(r=>{
                        this.loading_spinner = false
                    })
                }else{
                    this.$fire({
                        title: "Error en validación de datos",
                        text: "Todos los campos del formulario son obligatorios.",
                        type: "warning",
                        confirmButtonText: "Entendido"
                    })
                }
            }
        },

        alert(titulo, text, tipo){
            this.$fire({
                title: titulo,
                text: text,
                type: tipo,
            })
        },

        validationForm(){
            if (this.data.route.business_id!="" && this.data.route.name!="" && this.data.route.start_date!="" && this.data.route.end_date!="") {
                return true;
            }

            this.validation.route.business_id = (this.data.route.business_id=="");
            this.validation.route.name = (this.data.route.name=="");
            this.validation.route.start_date = (this.data.route.start_date=="");
            this.validation.route.end_date = (this.data.route.end_date=="");

            return false;
        },
    }
}
</script>
