import VueRouter from 'vue-router';
import App from './App.vue';
import Home from '../components/Home.vue';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import VerChamados from '../components/VerChamados.vue';
import AbrirChamado from '../components/AbrirChamado.vue';
import NotFound from '../components/NotFound.vue';

const router = new VueRouter({
    routes: [
        {path: '/', component: Home},
        {path: '/login', component: Login},
        {path: '/register', component: Register},
        {path: '/ver_chamados', component: VerChamados},
        {path: '/abrir_chamado', component: AbrirChamado},
        // {path: '/responder_chamado', component: Register},
        // {path: '/finalizar_chamado', component: Register},
        {path: '*', component: NotFound}
    ]
});

new Vue({
    el: '#app',
    router: router,
    render: h => h(App)
});