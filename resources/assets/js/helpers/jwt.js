import Cookie from 'js-cookie'

export default {
    setToken(token) {
        window.localStorage.setItem('jwt-token',token);
    },
    getToken() {
        return window.localStorage.getItem('jwt-token');
    },
    removeToken() {
        window.localStorage.removeItem('jwt-token');
        Cookie.remove('auth_id');
    },
    setAuthId(auth_id) {
        Cookie.set('auth_id',auth_id);
    }
}