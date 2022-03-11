import Vuex from 'vuex'
import axios from 'axios'
import Vue from 'vue'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        contacts: [],
        companies: [],
        loading: false
    },
    actions: {
        async getData({commit}) {
            commit('setIsLoading', true)
            await store.dispatch('getCompanies')
            await store.dispatch('getContacts')
            commit('setIsLoading', false)
        },
        async getContacts({state}) {
            try {
                const res = await axios.get('/api/contact/all')
                const data = res.data
                data.map((contact) => {
                    contact.visible = true
                    return contact
                });

                state.contacts = data
                return true
            } catch (error) {
                console.error(`Error loading contacts: ${error}`)
                return false
            }
        },
        async getCompanies({state}) {
            try {
                const res = await axios.get('/api/company/all');
                state.companies = res.data;
                
                return true;
            } catch (error) {
                console.error(`Error loading companies: ${error}`);
            }
        }
    },
    mutations: {
        setIsLoading(state, condition) {
            state.loading = condition
        },
        setContacts(state, contacts) {
            state.contacts = contacts
        }
    }
})

export default store