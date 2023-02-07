<template>
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
            <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Contraseña</label>
                <a href="#">
                <small>Olvido su contraseña?</small>
                </a>
            </div>
            <div class="input-group input-group-merge">
                <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password"
                    v-model="data.password"
                />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary d-grid w-100" type="submit">Entrar</button>
        </div>
    </form>
</template>
<script>
export default{
    data(){
        return{
            data:{
                'email': '',
                'password': ''
            }
        }
    },
    created() {
    },
    methods:{
        login(){
            axios.post('/login', this.data).then(res=>{
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
            this.$swal({
                title: title,
                text: text,
                icon: icon,
                timer: 3000
            })
        }
    }
}
</script>
