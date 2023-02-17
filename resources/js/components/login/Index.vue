<template>
    <div v-if="!load_second_form">
        <h4 class="mb-2">Bienvenido a Empresa! 👋</h4>
        <p class="mb-4">Porfavor ingresa tu usuario y contraseña para empezar a administrar tu empresa</p>
        <form id="formAuthentication" class="mb-3" @submit.prevent="login">
            <div class="mb-3">
                <label for="email" class="form-label">Correo</label>
                <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="email-username"
                    placeholder="Enter your email or username"
                    autofocus
                    v-model="data.email"
                />
            </div>
            <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between" @click="load_second_form = true">
                    <label class="form-label" for="password">Contraseña</label>
                    <a href="#">
                    <small>Olvido su contraseña?</small>
                    </a>
                </div>
                <div class="input-group input-group-merge">
                    <input
                        :type="type_input"
                        id="password"
                        class="form-control"
                        name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password"
                        v-model="data.password"
                    />
                    <span class="input-group-text cursor-pointer" @click="changeInput()"><i :class="[{'bx-show' : this.type_input == 'password'},'bx', {'bx-hide' : this.type_input == 'text'}]"></i></span>
                </div>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Entrar</button>
            </div>
        </form>
    </div>

    <reset-password v-else></reset-password>
</template>
<script>
import ResetPassword from './ResetPassword.vue'
export default{
    components:{
        ResetPassword
    },
    data(){
        return{
            data:{
                'email': '',
                'password': ''
            },
            type_input : 'password',
            load_second_form : false
        }
    },
    created() {
    },
    methods:{
        changeInput(){
            this.type_input = (this.type_input == 'password') ? 'text' : 'password'
        },
        login(){
            axios.post('/login', this.data).then(res=>{
                console.log(res.data)
                if(res.data.status){
                    window.location.href = "/";
                }else{
                    this.alert('Oops...', 'El usuario o contraseña son erroneos', 'error')
                }
            }).catch(error=>{
                console.log(error.response)
            })
        },
        alert(title, text, icon){
            this.$fire({
                title: title,
                text: text,
                type: icon,
            })
        }
    }
}
</script>
