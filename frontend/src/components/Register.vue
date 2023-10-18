<script>
    import api from "../helpers/api.js";
    import {doLogin} from '../helpers/authHandler.js';
    
    export default {
    data() {
        return {
            nome_completo: '',
            tipo_usuario: '',
            email: '',
            cpf: '',
            password: '',
            error: ''
        };
    },
    methods: {
        entrar: async function() {
           let json = await api.register(this.nome_completo, this.tipo_usuario, this.email, this.cpf, this.password);

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
            Nome completo: <br/>
            <input type="text" v-model="nome_completo">
        </label>

        <label>
            Tipo de usuário: <br/>
            <select v-model="tipo_usuario">
                <option></option>
                <option  value="cliente">cliente</option>
                <option  value="colaborador">colaborador</option>
            </select>
        </label>

        <label>
            Email: <br/>
            <input type="email" v-model="email">
        </label>

        <label>
            CPF: <br/>
            <input type="text" v-model="cpf">
        </label>

        <label>
            Senha: <br/>
            <input type="password" v-model="password">
        </label>

        <button v-on:click="entrar">Cadastrar</button>
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