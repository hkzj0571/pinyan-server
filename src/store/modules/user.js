import axios from 'axios'
import * as types from './mutation-types'

export default {
    state: {
        id: null,
        avatar: null,
        name: null,
        email: null,
        token: null,
        is_active: null,
        website: null,
        gender: null,
        describe: null,
        resume: null,
        wechat_qrcode: null,
        created_at: null,
        authenticated: false,
    },
    mutations: {

        /**
         * 登陆成功
         * @param state
         * @param data
         */
        [types.AUTHENTICATED](state,data) {
            let user = data.user
            let token = data.token

            state.id = user.id
            state.avatar = user.avatar
            state.name = user.name
            state.email = user.email
            state.is_active = user.is_active
            state.website = user.website
            state.gender = user.gender
            state.describe = user.describe
            state.resume = user.resume
            state.wechat_qrcode = user.wechat_qrcode
            state.created_at = user.created_at
            state.token = token.token_type + ' ' + token.access_token
            state.authenticated = true

            localStorage.user = JSON.stringify(user)
            localStorage.token = JSON.stringify(token)

            axios.defaults.headers.common['Authorization'] = state.token
        },

        /**
         * 退出成功
         * @param state
         */
        [types.UNTHENTICATED](state) {
            state.id = null
            state.avatar = null
            state.name = null
            state.email = null
            state.token = null
            state.is_active = null
            state.website = null
            state.gender = null
            state.describe = null
            state.resume = null
            state.wechat_qrcode = null
            state.created_at = null
            state.authenticated = false

            localStorage.removeItem('user')
            localStorage.removeItem('token')
        },

        /**
         * 刷新个人资料
         * @param state
         * @param user
         */
        [types.REFRESH](state, user) {
            state.id = user.id
            state.avatar = user.avatar
            state.name = user.name
            state.email = user.email
            state.is_active = user.is_active
            state.website = user.website
            state.gender = user.website
            state.describe = user.describe
            state.resume = user.resume
            state.wechat_qrcode = user.wechat_qrcode
            state.created_at = user.created_at

            localStorage.user = JSON.stringify(user)
        }
    },
    actions: {

        /**
         * 登陆成功
         * @param commit
         * @param data
         * @returns {Promise}
         */
        authenticated({commit}, data) {
            return new Promise(function (resolve, reject) {
                commit(types.AUTHENTICATED, data)
                resolve(data)
            })
        },

        /**
         * 退出登录成功
         * @param commit
         * @returns {Promise}
         */
        unthenticated({commit}) {
            return new Promise(function (resolve, reject) {
                commit(types.UNTHENTICATED)
                resolve()
            })
        },

        /**
         * 账号激活
         * @param commit
         * @param rootState
         * @param token
         * @returns {Promise}
         */
        actived({dispatch,commit, rootState}, token) {
            return new Promise(function (resolve, reject) {
                axios.post('active', token).then(resource => {
                    let respond = resource.data
                    if (respond.status) {
                        if (rootState.user.authenticated) {
                            dispatch('refresh')
                        }
                        resolve(respond.message)
                    } else {
                        reject(respond.message)
                    }
                })
            })
        },

        /**
         * 刷新用户资料
         * @param commit
         * @param data
         */
        refresh({commit}) {
            return new Promise(function (resolve, reject) {
                axios.post('user/refresh', {}).then(resource => {
                    let respond = resource.data
                    if (respond.status) {
                        commit(types.REFRESH, respond.data.user)
                        resolve()
                    } else {
                        reject()
                    }
                })
            })

        }

    },
}