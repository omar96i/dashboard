<template>
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">Suscripción</h5>
            <p class="card-text">Precio: ${{ new Intl.NumberFormat('es-ES').format(subscription.price)}}</p>
            <p class="card-text">Estado: <i class="bx bx-check-circle text-success" v-if="subscription.status == 'active'"></i><i class='bx bxs-x-circle text-danger' v-else></i></p>
        </div>
        <div class="card-footer text-muted">
            <p><small><span class="fw-bold">{{ getDate(subscription.start_date) }} - {{ getDate(subscription.end_date) }}</span></small></p>
        </div>
    </div>
</template>
<script>
export default {
    props:['subscription'],
    data(){
        return{
            meses : ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"],
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
    }
}
</script>
