<script>
    import api from "../helpers/api.js";
    
    export default {
    data() {
        return {
            titulo: '',
            descricao: '',
            error: ''
        };
    },
    methods: {
        entrar: async function() {
           let json = await api.abrirChamado(this.titulo, this.descricao);

           if (json.error) {
                this.error = json.error;
           }else{
                alert('Chamado aberto com sucesso!');

                this.$router.push({ path: '/' });
            }
        }
    }
}
</script>

<template>
    <div>
        <div class="error" v-if="error">{{ error }}</div>
        <h1>Abrir chamado</h1>

        <label>
            titulo: <br/>
            <input type="text" v-model="titulo">
        </label>

        <label>
            descricao: <br/>
            <input type="text" v-model="descricao">
        </label>

        <button v-on:click="entrar">Abrir chamado</button>
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