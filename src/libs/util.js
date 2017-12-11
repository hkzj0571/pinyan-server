import axios from 'axios'
import env from '../config/env'

export default{
    install(Vue, options)
    {
        Vue.prototype.$axios = axios
        Vue.prototype.$axios.defaults.baseURL = env.base_domain
        Vue.prototype.$axios.defaults.timeout = env.timeout

        Vue.prototype.$env = env
    }
}