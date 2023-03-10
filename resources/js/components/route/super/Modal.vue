<template>
    <!-- Modal -->
    <div class="modal fade" id="modalRoute" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
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

                        <div class="col-12" v-if="form == 'edit'">
                            <h6 class="text-muted">Suscripciones</h6>
                            <div class="nav-align-top mb-4 ">
                                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#nav-pill-general" aria-controls="nav-pill-general" aria-selected="true" @click="getSubscriptions('general')">
                                        <i class='tf-icons bx bx-book-content'></i> General
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#nav-pill-activos" aria-controls="nav-pill-activos" aria-selected="false" @click="getSubscriptions('active')">
                                        <i class='tf-icons bx bx-book-content'></i> Activas
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#nav-pill-inactivas" aria-controls="nav-pill-inactivas" aria-selected="false" @click="getSubscriptions('inactive')">
                                        <i class='tf-icons bx bx-book-content'></i> Inactivas
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#nav-pill-crear" aria-controls="nav-pill-crear" aria-selected="false">
                                        <i class='tf-icons bx bx-plus-medical'></i> Agregar suscripción
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content scroll-view">
                                    <div class="tab-pane fade active show"  id="nav-pill-general" role="tabpanel">
                                        <div class="list-group" v-if="subscriptions.length == 0">
                                            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                                <small>Actualmente no hay registros.</small>
                                            </a>
                                        </div>
                                        <div v-if="loading_view_tab_general">
                                            <molecules-subcription-list v-for="(subscription, index) in subscriptions" :key="index" :subscription="subscription"></molecules-subcription-list>
                                        </div>
                                        <content-spinner v-if="loading_spinner_tab_general" :message="'Cargando contenido...'"></content-spinner>
                                    </div>
                                    <div class="tab-pane fade" id="nav-pill-activos" role="tabpanel">
                                        <div class="demo-inline-spacing mt-3">
                                            <div class="list-group" v-if="subscriptions.length == 0">
                                                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                                    <small>Actualmente no hay registros.</small>
                                                </a>
                                            </div>
                                            <div v-if="loading_view_tab_active">
                                                <molecules-subcription-list v-for="(subscription, index) in subscriptions" :key="index" :subscription="subscription"></molecules-subcription-list>
                                            </div>
                                            <content-spinner v-if="loading_spinner_tab_active" :message="'Cargando contenido...'"></content-spinner>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-pill-inactivas" role="tabpanel">
                                        <div class="demo-inline-spacing mt-3">
                                            <div class="list-group" v-if="subscriptions.length == 0">
                                                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                                    <small>Actualmente no hay registros.</small>
                                                </a>
                                            </div>
                                            <div v-if="loading_view_tab_inactive">
                                                <molecules-subcription-list v-for="(subscription, index) in subscriptions" :key="index" :subscription="subscription"></molecules-subcription-list>
                                            </div>
                                            <content-spinner v-if="loading_spinner_tab_inactive" :message="'Cargando contenido...'"></content-spinner>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-pill-crear" role="tabpanel">
                                        <form-subcription :route="route"></form-subcription>
                                    </div>
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
import FormSubcription from './form/Subcription.vue'
import MoleculesSubcriptionList from './molecules/SubcriptionList.vue'
export default{
    props:['route', 'form', 'business_list'],
    components:{
        'content-spinner': Spinner,
        FormSubcription,
        MoleculesSubcriptionList
    },
    data(){
        return{
            data:{
                route:{
                    'business_id':'',
                    'name':'',
                }
            },
            validation:{
                'route':{
                    'business_id':false,
                    'name':false,
                }
            },
            business_options:[],
            collectors_options:[],
            route_axios: (this.form == 'insert')? '/Route/store' : `/Route/update/${this.route.id}`,
            loading_spinner: false,
            disabled_business: false,
            text_spinner: "cargando",
            isActive : false,
            loading_spinner_tab_general : false,
            loading_view_tab_general : true,
            loading_spinner_tab_active : false,
            loading_view_tab_active : false,
            loading_spinner_tab_inactive : false,
            loading_view_tab_inactive : false,
            subscriptions: [],
            state : 'general'
        }
    },
    created(){
        if(this.route.subscriptions){
            this.subscriptions = this.route.subscriptions
        }


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
        }
    },
    methods:{
        getSubscriptions(type = false){
            if(type != false){
                this.state = type
            }
            this.subscriptions = []
            if(this.route.subscriptions){
                this.resetVariables(this.state, true)
                axios.get(`/Route/Subscription/get/${this.route.id}/${this.state}`).then(res=>{
                    this.subscriptions = res.data.subscriptions
                }).catch(error=>{
                    this.alert('Ruta', 'Error en el servidor - getSubscriptions', 'error')
                    console.log(error.response)
                }).finally(()=>{
                    this.resetVariables(this.state, false)
                })
            }else{
                this.resetVariables(this.state, false)
            }

        },

        resetVariables(type, instance){
            this.loading_spinner_tab_active = (type == 'active' && instance == true) ? true : false
            this.loading_spinner_tab_general = (type == 'general' && instance == true) ? true : false
            this.loading_spinner_tab_inactive = (type == 'inactive' && instance == true) ? true : false
            this.loading_view_tab_active = (type == 'active' && instance == false) ? true : false
            this.loading_view_tab_general = (type == 'general' && instance == false) ? true : false
            this.loading_view_tab_inactive = (type == 'inactive' && instance == false) ? true : false
        },

        action(){

            if (this.form=="edit") {
                if (this.validationForm()){
                    this.loading_spinner = true
                    this.text_spinner = "Actualizando Ruta"
                    axios.post(this.route_axios, this.data).then(res=>{
                        var index = _.findIndex(this.$parent.routes, function(o) { return o.id == res.data.route.id; });
                        this.$parent.routes[index] = res.data.route
                        this.$parent.closeModal()

                        this.alert('Ruta', 'Editada con éxito', 'success')
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
