import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        token: localStorage.getItem('access_token') || null
    },
    getters: {
        loggedIn(state) {
            return state.token !== null
        },
        getToken(state){
            return state.token
        }
    },
    mutations: {
        retrieveToken(state, token) {
            state.token = token
        },
        destroyToken(state) {
            state.token = null
        }
    },
    actions: {
        retrieveToken(context, credentials) {
            return new Promise((resolve, reject) => {
                axios.post('/api/v1/login', {
                    email: credentials.email,
                    password: credentials.password,
                })
                    .then(response => {
                        //console.log(response)
                        const token = response.data.access_token
                        localStorage.setItem('access_token', token)
                        context.commit('retrieveToken', token)

                        resolve(response)
                    })
                    .catch(error => {
                        //console.log(error)
                        reject(error)
                    })
            })

        },
        destroyToken(context) {
            return new Promise((resolve, reject) => {
                axios.get('/api/v1/logout', {
                    headers: { Authorization: "Bearer " + context.state.token }
                })
                    .then(response => {
                        console.log(response)
                        localStorage.removeItem('access_token')
                        context.commit('destroyToken')
                        console.log("Remove Token");
                        resolve(response)
                    })
                    .catch(error => {
                        //console.log(error)
                        localStorage.removeItem('access_token')
                        context.commit('destroyToken')
            
                        reject(error)
                    })
            })
        }
    }
})

export default store

