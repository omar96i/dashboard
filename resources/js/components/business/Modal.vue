<template>
    <!-- Modal -->
    <div class="modal fade" id="modalBusiness" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
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
                                <input type="text" class="form-control" v-model="data.business.name">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">País:</label>
                                <input type="text" class="form-control" v-model="data.business.country">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Zona Horaria:</label>
                                <input type="text" class="form-control" v-model="data.business.time_zone">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Logo:</label>
                                <input type="text" class="form-control" v-model="data.business.path_icon">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Descripción: </label>
                                <input type="text" class="form-control" v-model="data.business.description">
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
export default{
    props:['business', 'form'],
    components:{
        'content-spinner': Spinner,
    },
    data(){
        return{
            data:{
                'business':{},
            },
            options:[   
                        {'label':'Colombia', 'id':'Ameria/Bogota'},
                        {'label':'Estados Unidos', 'id':'America/Chicago'},
                        {'label':'Perú', 'id':'America/Lima'}
                    ],
            route: (this.form=="insert")? `/Business/store` : `/Business/update/${this.business.id}`, 
            loading_spinner: false,
            text_spinner: "cargando"
        }
    },
    created(){
        if (this.form=="edit") {
            this.data.business = this.business;
        }
    },
    methods:{

        accion(){
            console.log("data del formulario: ")
            console.log(this.data.business)

            //if (this.data.business.name!="" && this.data.business.country!="" && this.data.business.time_zone!="" && this.data.business.path_icon!="" && this.data.business.description!=""){
                this.text_spinner = (this.form=="insert")? "Creando Empresa" : "Actualizando datos Empresa";
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
            //} else {
            //    alert("Los datos son obligatorios");
            //}
        },

    }
}
</script>
