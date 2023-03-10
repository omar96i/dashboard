<template>
    <div>
        <div class="row">
            <div class="col-12 col-sm-6">
                <label for="form-label">Dias activos</label>
                <input type="number" :class="[{'is-invalid' : dataValidacion.days }, 'form-control']" v-model="data.days">
                <div class="invalid-feedback">
                    Por favor ingresa un numero de dias
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <label for="form-label">Precio</label>
                <input type="number" :class="[{'is-invalid' : dataValidacion.price }, 'form-control']" v-model="data.price">
                <div class="invalid-feedback">
                    Por favor ingresa un precio
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <label for="form-label">Fecha inicio</label>
                <input type="date" :class="[{'is-invalid' : dataValidacion.start_date }, 'form-control']" :disabled="!data.days" v-model="data.start_date" @change="setDate()">
                <div class="invalid-feedback">
                    Por favor seleccione una fecha
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <label for="form-label">Fecha final</label><br>
                {{ data.end_date }}
            </div>
            <div class="col-12 mt-4 text-center">
                <button class="btn btn-primary btn-sm" @click="store()"><i class='bx bx-plus-medical'></i> Subscripcion</button>
            </div>
            <spinner message="Se esta generando la subscripcion..." v-if="loading"></spinner>
        </div>
    </div>
</template>
<script>
import Spinner from '../../../custom/Spinner.vue'
export default{
    components:{
        Spinner
    },
    props:['route'],
    data(){
        return{
            data:{
                days : '',
                start_date : '',
                end_date : '',
                price : ''
            },
            dataValidacion:{
                days : false,
                start_date : false,
                end_date : false
            },
            loading : false,

        }
    },
    methods:{

        store(){
            if(this.validacion()){
                this.loading = true
                axios.post(`/Route/Subscription/store/${this.route.id}`, this.data).then(res=>{
                    if(res.data.status){
                        this.alert('Subscripcion', 'Registro exitoso!', 'success')
                    }
                }).catch(error=>{
                    this.alert('Subscripcion', 'Error del servidor - store-subscription', 'error')
                }).finally(()=>{
                    this.loading = false
                    this.validacion()
                    this.data = {
                        days : '',
                        start_date : '',
                        end_date : '',
                        price : ''
                    }
                })
            }
        },

        setDate(){
            const fechaInput = new Date(this.data.start_date)
            fechaInput.setDate(fechaInput.getDate() + parseInt(this.data.days))
            const year = fechaInput.getFullYear();
            const mes = fechaInput.getMonth() + 1;
            const dia = fechaInput.getDate();
            this.data.end_date = `${year}-${mes < 10 ? '0' : ''}${mes}-${dia < 10 ? '0' : ''}${dia}`;
        },

        validacion(){
            if(this.data.days != '' && this.data.start_date != '' && this.data.end_date != '' && this.data.price != ''){
                return true
            }
            this.dataValidacion.days = (this.data.days == '') ? true : false
            this.dataValidacion.start_date = (this.data.start_date == '') ? true : false
            this.dataValidacion.price = (this.data.price == '') ? true : false
            return false
        },

        alert(titulo, text, tipo){
            this.$fire({
                title: titulo,
                text: text,
                type: tipo,
            })
        },
    }
}
</script>
