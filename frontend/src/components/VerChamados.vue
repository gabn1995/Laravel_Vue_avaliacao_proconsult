<script>
    import api from "../helpers/api.js";
    
    export default {
    data() {
        return {
            lista_chamados: [],
            error: ''
        };
    },
    methods: {
        entrar: async function() {
           let json = await api.pegarChamados();

           if (json.error) {
                this.error = json.error;
           }else{
                this.lista_chamados = json.chamados;
            }
        },
        responder: async function(id) {
            let json = await api.responderChamado(id);

            if (json.error) {
                this.error = json.error;
            }else{
                alert('status do chamado alterado!');
                this.$router.push({ path: '/' });
            }

        },
        finalizar: async function(id) {
            let json = await api.finalizarChamado(id);

            if (json.error) {
                this.error = json.error;
            }else{
                alert('status do chamado alterado!');
                this.$router.push({ path: '/' });
            }

        }
    },
    mounted(){
        this.entrar();
    }
}
</script>

<template>
    <div>
        <div class="error" v-if="error">{{ error }}</div>
        <h1>Lista de chamados</h1>

        <div v-for="chamado in lista_chamados" class="chamado-item">
            <h3>{{ chamado.status }}</h3>
            <h5>{{ chamado.titulo }}</h5>
            <p>{{ chamado.descricao }}</p>
            
            <button @click="responder(chamado.id)">Responder chamado</button>
            <button @click="finalizar(chamado.id)">Finalizar chamado</button>
        </div>

    </div>
</template>

<style>
    .error{
        font-size: 14px;
        color: #000;
        border: #f00 solid 1px;
        padding: 10px;
        border-radius: 5px;
    }

    .chamado-item{
        border: 1px solid #ccc;
        padding: 10px;
        margin: 10px;
        max-width: 400px;
    }
</style>