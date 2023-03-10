<template>
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Suscripción</h5>
            <h6 class="card-subtitle mb-2 text-muted">Creado por: {{subscription.created_by.personal_information.name}}</h6>
            <p class="card-text">Precio: ${{ new Intl.NumberFormat('es-ES').format(subscription.price)}}</p>
            <p class="card-text">Estado: <i class="bx bx-check-circle text-success" v-if="subscription.status == 'active'"></i><i class='bx bxs-x-circle text-danger' v-else></i></p>
        </div>
        <div class="card-footer text-muted">
            <p><small><span class="fw-bold">{{ getDate(subscription.start_date) }} - {{ getDate(subscription.end_date) }}</span></small></p>
        </div>
       <button type="button" class="btn-close position-absolute top-0 end-0 btn-danger" @click="action()"></button>
       <spinner v-if="loading"></spinner>
    </div>
</template>
<script>
import Spinner from '../../../Spinner.vue'
export default {
    components:{
        Spinner
    },
    props:['subscription'],
    data(){
        return{
            meses : ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"],
            loading : false
        }
    },
    methods:{
        getDate(fecha){
            var date = new Date(fecha)
            var mes = this.meses[date.getMonth()]
            var dia = date.getDate()
            var yeear = date.getFullYear()
            return `${dia} de ${mes} de ${yeear}`
        },
        action(){
            this.$fire({
	                title: 'Eliminar Suscripción',
	                html: `¿Está seguro de eliminar la suscripcion seleccionada?`,
	                type: 'warning',
	                showCancelButton: true,
	                confirmButtonText: 'Eliminar',
	                cancelButtonText: 'Cancelar',
	                confirmButtonColor: '#FF0000',
	            }).then((result) => {
	                if(result.value){
                        this.loading = true
						axios.get(`/Route/Subscription/delete/${this.subscription.id}`).then(res=>{
                            if(res.data.status){
                                this.$parent.alert('Suscripción', 'Eliminada', 'success')
                                this.$parent.getSubscriptions()
                            }
						}).catch(error=>{
							console.log(error.response)
						}).finally(()=>{
                            this.loading = false
                        })
	                }
	            });
        }
    }
}
</script>
