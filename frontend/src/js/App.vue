<script>
    import {isLogged, isTypeUser, doLogout} from '../helpers/authHandler.js';

    export default {
    data() {
        return {
            tipo_usuario: '',
            status_logado: ''
        };
    },
    methods: {
        logout: async function() {
           doLogout();
           this.$router.push({ path: '/' });
        }
    },
    mounted() {
        this.status_logado = isLogged();
        this.tipo_usuario = isTypeUser();

    },
    updated(){
        this.status_logado = isLogged();
        this.tipo_usuario = isTypeUser();
    }
}
</script>

<template>
    <div id="app">
        <div class="menu-1" v-if="status_logado == false">
            <router-link to="/">Home</router-link>
            <router-link to="/login">Login</router-link>
            <router-link to="/register">Register</router-link>
        </div>
        <div class="menu-2" v-if="status_logado == true">
            <div class="menu-2-1" v-if="tipo_usuario=='cliente'">
                <router-link to="/">Home</router-link>
                <router-link to="/abrir_chamado">Abrir chamado</router-link>
                <button class="button-logout" v-on:click="logout">Sair</button>
            </div>
            <div class="menu-2-2" v-if="tipo_usuario=='colaborador'">
                <router-link to="/">Home</router-link>
                <router-link to="/ver_chamados">Ver chamados</router-link>
                <button class="button-logout" v-on:click="logout">Sair</button>
            </div>
        </div>
        <hr>
        
        <router-view></router-view>
    </div>
</template>

<style>
    a{
        font-size: 14px;
        margin-right: 20px;
    }

    .button-logout{
        background: none;
        border: none;
        border-bottom: solid #00F 1px;
        color: #00F;
        cursor: pointer;
    }
    
</style>