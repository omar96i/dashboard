<template>
	<div class="m-2">
		
		<div class="col-12 m-0 p-0">
			<button class="btn btn-primary" @click="openModal()">NUEVA EMPRESA</button>
		</div>

		<div class="col-12 m-0 p-0 my-2">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Logo</th>
						<th>Nombre</th>
						<th>País</th>
						<th>Zona Horaria</th>
						<th>Descripción</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(business, index) in business_list" :key="index">
						<td>{{ business.path_icon }}</td>
						<td>{{ business.name }}</td>
						<td>{{ business.country }}</td>
						<td>{{ business.time_zone }}</td>
						<td>{{ business.description }}</td>
						<td class="row m-0 p-0">
							<button class="col btn btn-primary p-1" @click="editar(business)">Editar</button>
							<button class="col btn btn-danger p-1" @click="eliminar(business)">Eliminar</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
			
		<content-spinner v-if="loading_spinner" :message="text_spinner"></content-spinner>
		<form-modal v-if="loading_modal" :business="business" :form="form"></form-modal>
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
		data(){
			return {
				business_list:{},
				loading_modal: false,
				business:{},
				form: 'insert',
				loading_spinner: true,
				text_spinner: "cargando"
			}
		},
		created(){
			this.getBusiness()
		},
		methods:{

			getBusiness(){
				axios.get(`/Business/get`).then(res=>{
					this.business_list = res.data.business
					this.loading_spinner = false
				}).catch(error=>{
					console.log(error.response)
				})
			},

			openModal(){
				this.loading_modal = true;
				setTimeout(()=>{
					$("#modalBusiness").modal({backdrop: 'static', keyboard: false, focus:false})
    				$("#modalBusiness").modal('show')
				})
			},

			closeModal(){
				$("#modalBusiness").modal('hide')
				setTimeout(()=>{
					this.form = "insert"
					this.loading_modal = false
				})
			},

			editar(business){
				this.form = "edit"
				this.business = business
				this.openModal()
			},

			eliminar(business){
				console.log("Eliminar: ")
				console.log(business)
			},

			modalClose(){
				console.log("Modal Cerrado");
			},
		}
	}
</script>