
export const isTypeUser = () => {
    let tipo_usuario = localStorage.getItem('tipo_usuario');
    return (tipo_usuario);
}

export const isLogged = () => {
    let token = localStorage.getItem('token');
    return (token) ? true : false;
}

export const doLogin = (token, tipo_usuario) => {
    localStorage.setItem('token', token);
    localStorage.setItem('tipo_usuario', tipo_usuario);
}

export const doLogout = () =>{
    localStorage.removeItem('token');
    localStorage.removeItem('tipo_usuario');
}