const BASEAPI = 'http://127.0.0.1:8000/api';

const apiFetchPost = async (endpoint, body) =>{
    if(!body.token){
        let token = localStorage.getItem('token');

        if(token){
            body.token = token;
        }
    }

    const res = await fetch(BASEAPI+endpoint, {
        method:'POST',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(body)
    });

    const json = await res.json();

    if(json.notallowed){
        window.location.href = '/signin';
        return;
    }

    return json;
}

const apiFetchGet = async (endpoint, body = []) =>{
    if(!body.token){
        let token = localStorage.getItem('token');

        if(token){
            body.token = token;
        }
    }

    const res = await fetch(`${BASEAPI+endpoint}?${body}`);
    const json = await res.json();

    if(json.notallowed){
        window.location.href = '/signin';
        return;
    }

    return json;
}

const api = {

    login: async (email, password) =>{
        const json = await apiFetchPost(
            '/signin',
            {email, password}   
        );

        return json;
    },

    register: async (nome_completo, tipo_usuario, email, cpf, password) =>{
        const json = await apiFetchPost(
            '/signup',
            {nome_completo, tipo_usuario, email, cpf, password}    
        );
        return json;
    },

    abrirChamado: async (titulo, descricao) =>{
        const json = await apiFetchPost(
            '/chamado',
            {titulo, descricao}    
        );
        return json;
    },

    pegarChamados: async () =>{
        const json = await apiFetchPost(
            '/chamados' ,
            {}
        );
        return json;
    },

    responderChamado: async (id) =>{
        const json = await apiFetchPost(
            '/chamado/responder' ,
            {id}
        );
        return json;
    },

    finalizarChamado: async (id) =>{
        const json = await apiFetchPost(
            '/chamado/finalizar' ,
            {id}
        );
        return json;
    },
};

export default api;