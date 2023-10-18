<script>
    import api from "../helpers/api.js";
    import {doLogin} from '../helpers/authHandler.js';
    
    export default {
    data() {
        return {
            email: '',
            pass: '',
            error: ''
        };
    },
    methods: {
        entrar: async function() {
           let json = await api.login(this.email, this.pass);

           if (json.error) {
                this.error = json.error;
           }else{
                doLogin(json.token, json.usuario.tipo_usuario);

                this.$router.push({ path: '/' });
            }
        }
    }
}
</script>

<template>
    <div>
        <div class="error" v-if="error">{{ error }}</div>
        <h1>Página de Login</h1>

        <label>
            Email: <br/>
            <input type="email" v-model="email">
        </label>

        <label>
            Senha: <br/>
            <input type="password" v-model="pass">
        </label>

        <button v-on:click="entrar">Entrar</button>
    </div>
</template>

<style>
    label{
        display: block;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .error{
        font-size: 14px;
        color: #000;
        border: #f00 solid 1px;
        padding: 10px;
        border-radius: 5px;
    }
</style>