<template>
	<div class="m-2 p-2">
		
		<div class="col-12 m-0 p-0" v-if="role=='super.admin'">
			<button class="btn btn-primary" @click="openModal()"> <i class='bx bxs-business'></i> NUEVA RUTA</button>
		</div>

		<div class="col-12 m-0 p-0" v-if="role!='super.admin'">
			<h5 class="text-dark">Rutas de la Empresa:</h5>
		</div>

		<div class="col-12 m-0 p-0 my-2">

			<div class="col-12 row m-0 p-0">
				<div class="col-12 col-sm-6 col-lg-4 m-0 p-2" v-for="(route, index) in routes" :key="index">
					<div class="col card h-100">
				      <div class="card-header d-flex align-items-center justify-content-between pb-0">
				        <div class="card-title mb-0">
				          <h5 class="m-0 me-2 text-dark text-uppercase">{{ route.name }}</h5>
				          <small class="text-muted"><b>{{ route.start_date }}</b> hasta <b>{{ route.end_date }}</b> </small>
				        </div>
				      </div>
				      <div class="card-body">
				        <div class="d-flex justify-content-center align-items-center mt-2 mb-3" style="position: relative;">
				          <div class="d-flex flex-column align-items-center">
				            <h2 class="mb-0">190</h2>
				            <span>Total Clientes</span>
				          </div>
				        </div>
				        <ul class="p-0 m-0">
				          <li class="d-flex mb-2 pb-1">
				            <div class="avatar flex-shrink-0 me-3">
				              <span class="avatar-initial rounded bg-label-success"><i class='bx bxs-user-check'></i></span>
				            </div>
				            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
				              <div class="me-2">
				                <h6 class="mb-0">Clientes Activos</h6>
				                <small class="text-muted">Ver lista</small>
				              </div>
				              <div class="user-progress">
				                <small class="fw-semibold">130</small>
				              </div>
				            </div>
				          </li>
				          <li class="d-flex mb-2 pb-1">
				            <div class="avatar flex-shrink-0 me-3">
				              <span class="avatar-initial rounded bg-label-danger"><i class='bx bx-user-voice'></i></span>
				            </div>
				            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
				              <div class="me-2">
				                <h6 class="mb-0">Clientes Inactivos</h6>
				                <small class="text-muted">Ver lista</small>
				              </div>
				              <div class="user-progress">
				                <small class="fw-semibold">60</small>
				              </div>
				            </div>
				          </li>
				          <li class="d-flex mb-2 pb-1">
				            <div class="avatar flex-shrink-0 me-3">
				              <span class="avatar-initial rounded bg-label-info"><i class='bx bx-cycling'></i></span>
				            </div>
				            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
				              <div class="col">
				                <h6 class="mb-0">Cobrador</h6>
				                <small class="text-dark">
				                	{{ extraerCobradorActivo(route.route_collector) }}
				                </small>
				              </div>
				            </div>
				          </li>
				          <li class="d-flex pb-1">
				            <div class="avatar flex-shrink-0 me-3">
				              <span class="avatar-initial rounded bg-label-warning"><i class='bx bx-loader'></i></span>
				            </div>
				            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
				              <div class="col">
				                <h6 class="mb-0">Estado de la Ruta</h6>
				                <small class="text-sucess">{{ (route.status == "active")? "ACTIVA" : "INACTIVA" }}</small>
				              </div>
				            </div>
				          </li>
				          <li class="d-flex m-0 p-0 justify-content-end">
				            <button class="btn btn-primary py-1" @click="editar(route)">Información</button>
				          </li>
				        </ul>
				      </div>
				    </div>
					
				</div>
			</div>

		</div>
			
		<content-spinner v-if="loading_spinner" :message="text_spinner"></content-spinner>
		<form-modal v-if="loading_modal" :route="route" :business_list="business_list" :form="form"></form-modal>
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
				text_spinner: "Cargando Rutas"
			}
		},
		created(){
			this.getRoutes()
		},
		methods:{

			getRoutes(){
				axios.get(`/Route/get`).then(res=>{
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
						axios.post(`/Route/delete/${route.id}`).then(res=>{
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

			extraerCobradorActivo(collectors){
				let texto = `Sin definir`
				collectors.forEach(reg => {
					if (reg.status=="active") {
						texto = reg.collector.personal_information.full_name
					} 
                });
				return texto
			}

		}
	}
</script>