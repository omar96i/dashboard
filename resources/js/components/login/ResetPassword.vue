<template>
    <div>
        <h4 class="mb-2">Olvidastes tu contraseña? 🔒</h4>
        <p class="mb-4">Ingresa tu Email en el cual te enviaremos las instrucciones para recuperarla</p>
        <form id="formAuthentication" class="mb-3" action="index.html" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                type="text"
                class="form-control"
                id="email"
                name="email"
                placeholder="Email"
                autofocus
                />
            </div>
            <button class="btn btn-primary d-grid w-100">Enviar</button>
        </form>
        <div class="text-center">
        <a @click="$parent.load_second_form = false" href="#" class="d-flex align-items-center justify-content-center">
            <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
            Iniciar sesion
        </a>
        </div>
    </div>
</template>
