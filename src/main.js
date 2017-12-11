import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store/index'
import iView from 'iview'
import Util from './libs/util'
import 'iview/dist/styles/iview.css'
import './assets/sass/app.scss'
import 'vue-social-share/dist/client.css'
import Share from 'vue-social-share'

Vue.use(Share)

import VueQuillEditor from 'vue-quill-editor'
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

Vue.use(VueQuillEditor)

Vue.use(iView)
Vue.use(Util)

Vue.config.productionTip = true


router.beforeEach((to, from, next) => {
    iView.LoadingBar.start()
    next()
})

router.afterEach(() => {
    iView.LoadingBar.finish()
    window.scrollTo(0, 0)
})


new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: {App},
    mounted: function () {
        if (localStorage.user && localStorage.token) {
            let data = {
                user:JSON.parse(localStorage.user),
                token:JSON.parse(localStorage.token)
            }
            this.$store.dispatch('authenticated',data)
        }

        this.$axios.interceptors.response.use(respond => {
            return respond.data.code == '401' ? this.$router.push('/login') : respond
        }, error => {
            if (error.response.status == '401') {
                return this.$Message.error({
                    content: '请登录后再进行此操作',
                    onClose: () => {
                        this.$store.dispatch('unthenticated')
                        this.$router.push('/login')
                    }
                })
            }
        })
    }
})
