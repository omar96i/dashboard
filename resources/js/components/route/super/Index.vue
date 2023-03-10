<template>
<div>
    <div class="mt-3">

    <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel" aria-hidden="true" style="visibility: hidden;">
        <div class="offcanvas-header">
            <h5 id="offcanvasTopLabel" class="offcanvas-title">Filtros</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <label class="text-muted d-block">Empresa:</label>
                    <v-select label="name" :options="business_list" :reduce="option => option.id" v-model="filtro.business_id"></v-select>
                </div>
                <div class="col-12 col-sm-6">
                    <label class="text-muted d-block">Ruta:</label>
                    <input type="text" class="form-control" v-model="filtro.route">
                </div>
                <div class="col-12 col-sm-6 mt-2">
                    <label class="text-muted d-block">Con suscripcion?</label>
                    <div class="form-check">
                        <input name="default-radio-1" class="form-check-input" type="radio" :value="false" v-model="filtro.subcription" id="defaultRadio1">
                        <label class="form-check-label" for="defaultRadio1"> No </label>
                    </div>
                    <div class="form-check">
                        <input name="default-radio-1" class="form-check-input" type="radio" :value="true" v-model="filtro.subcription" id="defaultRadio2">
                        <label class="form-check-label" for="defaultRadio2"> Si </label>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary me-2 btn-sm" @click="getRoutes()" data-bs-dismiss="offcanvas">Buscar</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="offcanvas">
                Cancelar
            </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="card-body">
                        <div class="col-12 mb-4">
                            <button type="button" class="btn btn-primary btn-sm" @click="openModal()">
                                <i class='bx bxs-business'></i> Nueva ruta
                            </button>
                            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
                                Filtros
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="table_users">
                                <thead>
                                    <tr>
                                        <th scope="col">Empresa</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Suscripcion</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(route, index) in routes" :key="index">
                                        <td>{{ route.business.name }}</td>
                                        <td>{{ route.name }}</td>
                                        <td><i class="bx bx-check-circle text-success" v-if="getStatus(route.subscriptions)"></i><i class='bx bxs-x-circle text-danger' v-else></i></td>
                                        <td>
                                            <button @click="editar(route)" class="btn btn-sm"><i class='bx bx-edit'></i></button>
                                            <button @click="eliminar(route)" class="btn btn-sm"><i class='bx bx-trash'></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <content-spinner v-if="loading_spinner" :message="text_spinner"></content-spinner>
                        <form-modal v-if="loading_modal" :route="route" :business_list="business_list" :form="form"></form-modal>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
	import Modal from './Modal.vue'
	import Spinner from '../../custom/Spinner.vue'

	export default{
		components:{
			'form-modal': Modal,
			'content-spinner': Spinner,
		},
		props:['role', 'business_id'],
		data(){
			return {
				loading_modal: false,
				business_list: [],
				routes:[],
				route:{},
				form: 'insert',
				loading_spinner: true,
				text_spinner: "Cargando Rutas",
                filtro : {
                    'business_id' : '',
                    'route' : '',
                    'subcription' : ''
                }
			}
		},
		created(){
			this.getRoutes()
		},
		methods:{

            getStatus(subscriptions){
                var aux = false
                subscriptions.forEach(element => {
                    if(element.status == 'active'){
                        aux = true
                        return
                    }
                });
                return aux
            },

			getRoutes(){
                this.loading_spinner = true
				axios.post(`/Route/get`, this.filtro).then(res=>{
                    console.log(res.data)
					this.routes = res.data.routes
					this.business_list = res.data.business
					this.loading_spinner = false
				}).catch(error=>{
					console.log(error.response)
				})
			},

			openModal(){
				this.loading_modal = true;
				setTimeout(()=>{
					$("#modalRoute").modal('show')
				},200)
			},

			closeModal(){
				$("#modalRoute").modal('hide')
				setTimeout(()=>{
					this.form = "insert"
					this.loading_modal = false
				},200)
			},

			editar(route){
				this.form = "edit"
				this.route = route
				this.openModal()
			},

			eliminar(route){
				this.$fire({
	                title: 'Eliminar Ruta',
	                html: `¿Está seguro de eliminar la ruta <b>${route.name}</b> de la empresa <b>${route.business.name}</b>?`,
	                type: 'warning',
	                showCancelButton: true,
	                confirmButtonText: 'Eliminar',
	                cancelButtonText: 'Cancelar',
	                confirmButtonColor: '#FF0000',
	            }).then((result) => {
	                if(result.value){
						this.loading_spinner = true
						this.text_spinner = "Eliminando Ruta"
						axios.get(`/Route/delete/${route.id}`).then(res=>{
							if(res.data.status){
			                    var index = _.findIndex(this.routes, function(o) { return o.id == route.id; });
			                    this.routes.splice(index, 1)
							}
						}).catch(error=>{
							console.log(error.response)
						}).finally(()=>{
							this.loading_spinner = false
						})
	                }
	            });
			},

		}
	}
</script>
