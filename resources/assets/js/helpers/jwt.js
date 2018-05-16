export default {
    setToken(token) {
        window.localStorage.setItem('jwt-token',token);
    },
    getToken() {
        return window.localStorage.getItem('jwt-token');
    },
    removeToken() {
        window.localStorage.removeItem('jwt-token');
    }
}