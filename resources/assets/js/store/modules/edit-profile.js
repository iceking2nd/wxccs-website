import jwtToken from './../../helpers/jwt'

export default {
    actions : {
        updateProfileRequest({dispatch},formData) {
            return axios.post('/api/user/profile/update',formData).then(response => {
                dispatch('showNotification',{level:'success',msg:'资料修改成功！'})
            }).catch(error => {

            })
        }
    }
}