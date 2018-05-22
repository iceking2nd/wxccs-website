import jwtToken from './../../helpers/jwt'

export default {
    actions : {
        loginRequest({dispatch},formData) {
            return axios.post('/api/login',formData).then(response => {
                dispatch('loginSuccess',response.data)
                dispatch('showNotification',{level:'success',msg:'登录成功！'})
            })
        },
        loginSuccess({dispatch},tokenResponse) {
            jwtToken.setToken(tokenResponse.token)
            jwtToken.setAuthId(tokenResponse.auth_id)
            dispatch('setAuthUser')
        },
        logoutRequest({dispatch}){
            return axios.post('/api/logout').then(response => {
                jwtToken.removeToken()
                dispatch('unsetAuthUser')
                dispatch('showNotification',{level:'info',msg:'登出成功！'})
            }).catch(error => {
                dispatch('showNotification',{level:'danger',msg:'登出失败！原因:'+error.response.message})
            })
        }
    }
}