<template>
	<div class="m-2">
		
		<div class="col-12 m-0 p-0">
			<button class="btn btn-primary" @click="openModal()"> <i class='bx bxs-business'></i> NUEVA EMPRESA</button>
		</div>

		<div class="col-12 m-0 p-0 my-2">
			<table class="table table-bordered" id="table-business">
				<thead>
					<tr>
						<th class="text-center">Logo</th>
						<th class="text-center">Nombre</th>
						<th class="text-center">País</th>
						<th class="text-center">Zona Horaria</th>
						<th class="text-center">Descripción</th>
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
						<td class="row m-0 p-1">
							<button class="col btn btn-primary p-1 me-1" @click="editar(business)" title="Editar"><i class='bx bx-edit'></i></button>
							<button class="col btn btn-danger p-1" @click="eliminar(business)" title="Eliminar"><i class='bx bx-trash'></i></button>
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
				business_list:[],
				loading_modal: false,
				business:{},
				form: 'insert',
				loading_spinner: true,
				text_spinner: "Cargando Empresas"
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

				this.$fire({
	                title: 'Eliminar Empresa',
	                html: '¿Está seguro de eliminar la empresa <b>'+business.name+'</b> ?',
	                type: 'warning',
	                showCancelButton: true,
	                confirmButtonText: 'Eliminar',
	                cancelButtonText: 'Cancelar',
	                confirmButtonColor: '#FF0000',
	            }).then((result) => {
	                if(result.value){
						this.loading_spinner = true
						this.text_spinner = "Eliminando Empresa"
						axios.post(`/Business/delete/${business.id}`).then(res=>{
							if(res.data.status){
			                    var index = _.findIndex(this.business_list, function(o) { return o.id == business.id; });
			                    this.business_list.splice(index, 1)
							}
						}).catch(error=>{
							console.log(error.response)
						}).finally(()=>{
							this.loading_spinner = false
						})
	                }
	            });

			},

			modalClose(){
				console.log("Modal Cerrado");
			},

			reLoadTable(){
	            this.loading = false
	            setTimeout(()=>{
	                this.loading = true
	                setTimeout(()=>{
	                    this.loadTable()
	                },200)
	            }, 200)
	        },

	        loadTable(){
	            $("#table-business").DataTable()
	        },
		}
	}
</script>