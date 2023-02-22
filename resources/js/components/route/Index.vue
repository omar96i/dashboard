<template>
	<div class="m-2">
		
		<div class="col-12 m-0 p-0" v-if="role=='super.admin'">
			<button class="btn btn-primary" @click="openModal()"> <i class='bx bxs-business'></i> NUEVA RUTA</button>
		</div>

		<div class="col-12 m-0 p-0 my-2">
			<table class="table table-bordered" id="table-business">
				<thead>
					<tr>
						<th class="text-center">Empresa</th>
						<th class="text-center">Nombre</th>
						<th class="text-center">Fecha Inicio</th>
						<th class="text-center">Fecha Fin</th>
						<th class="text-center">Estado</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(route, index) in routes" :key="index">
						<td>{{ route.business.name }}</td>
						<td>{{ route.name }}</td>
						<td>{{ route.start_date }}</td>
						<td>{{ route.end_date }}</td>
						<td>{{ (route.status == "active")? "ACTIVA" : "INACTIVA" }}</td>
						<td class="row m-0 p-1">
							<button class="col btn btn-primary p-1 me-1" @click="editar(route)" title="Editar"><i class='bx bx-edit'></i></button>
							<button class="col btn btn-danger p-1" @click="eliminar(route)" title="Eliminar" v-if="role=='super.admin'"><i class='bx bx-trash'></i></button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
			
		<content-spinner v-if="loading_spinner" :message="text_spinner"></content-spinner>
		<form-modal v-if="loading_modal" :route="route" :business_list="business_list" :form="form"></form-modal>
	</div>
</template>
<script>
	import Modal from './Modal.vue'
	import Spinner from '../custom/Spinner.vue'

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

		}
	}
</script>