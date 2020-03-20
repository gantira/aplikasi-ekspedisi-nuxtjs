export const state = () => ({
    users: [],
    data: [], //TAMBAHKAN STATE INI
    errors: [],
    page: 1
})

export const mutations = {
    SET_USER_DATA(state, payload) {
        state.users = payload
    },
    SET_ERRORS(state, payload) {
        state.errors = payload
    },
    //MUTATION UNTUK MENGUBAH VALUE DARI STATE PAGE
    SET_PAGE(state, payload) {
        state.page = payload
    },
    SET_DATA(state, payload) {
        state.data = payload
    },
}

export const actions = {
    getUsersData({ commit, state }, payload) {
        let search = payload ? payload : ''
        return new Promise((resolve, reject) => {
            //KIRIM REQUEST KE API, DENGAN MENGIRMKAN PARAMETER Q DAN PAGE
            //DIMANA Q ADALAH PENCARIAN DAN PAGE ADALAH AKTIF PAGE YANG SEDANG DIAKSES
            this.$axios.get(`/users?q=${search}&page=${state.page}`).then((response) => {
                commit('SET_USER_DATA', response.data.data) //JIKA BERHASIL, SET DATA BARU 
                resolve()
            })
        })
    },
    storeUsersData({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            this.$axios.post('/users', payload)
                .then(() => {
                    dispatch('getUsersData')
                    resolve()
                })
                .catch((error) => {
                    commit('SET_ERRORS', error.response.data)
                })
        })
    },
    destroyUsersData({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            this.$axios.delete(`/users/${payload}`)
                .then(() => {
                    dispatch('getUsersData')
                    resolve()
                })
                .catch((error) => {
                    commit('SET_ERRORS', error.response.data)
                })
        })
    },
    getData({ commit }, payload) {
        return new Promise((resolve, reject) => {
            //KIRIM REQUEST KE SERVER UNTUK MENGAMBIL DATA USER
            this.$axios.get(`/users/${payload}`).then((response) => {
                commit('SET_DATA', response.data.data) //SET DATA YANG DITERIMA KE DALAM STATE
                resolve()
            })
        })
    },
    updateUserData({ dispatch, commit }, payload) {
        return new Promise((resolve, reject) => {
            //KIRIM PERMINTAAN UNTUK MENGUPDATE DATA BERDASARKAN ID USER
            this.$axios.put(`/users/${payload.id}`, payload)
                .then(() => {
                    dispatch('getUsersData') //AMBIL DATA USER YANG BARU 
                    resolve()
                })
                .catch((error) => {
                    commit('SET_ERRORS', error.response.data)
                })
        })
    },

}
