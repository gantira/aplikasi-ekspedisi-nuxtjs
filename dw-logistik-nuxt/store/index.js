export const state = () => ({
    isAuth: false,
    api_token: null //STATE UNTUK DATA API TOKEN
})

export const mutations = {
    SET_IS_AUTH(state, payload) {
        state.isAuth = payload
    },
    SET_API_TOKEN(state, payload) {
        state.api_token = payload
    }
}

export const actions = {
    nuxtServerInit({ commit }, context) {
        commit('SET_IS_AUTH', context.app.$auth.$state.loggedIn)
        //LAKUKAN PENGECEKAN, DIMANA JIKA USER SUDAH LOGIN
        if (context.app.$auth.$state.loggedIn) {
            //MAKA SET API TOKENNYA
            commit('SET_API_TOKEN', context.app.$auth.$state.user.api_token)
        }
    }
}