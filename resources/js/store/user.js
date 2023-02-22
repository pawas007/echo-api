const state = {
    authUser: null,
    settings:null
}

const mutations = {
    SET_AUTH_USER: (state, user) => {
        state.authUser = user;
    },
    SET_AUTH_USER_SETTINGS: (state, settings) => {
        state.settings = settings;
    },
}

const actions = {

    GET_AUTH_USER: async (context) => {
        return await axios.get('/user')
            .then(response => {
                context.commit('SET_AUTH_USER', response.data);
            })
    },
    GET_AUTH_USER_SETTINGS: async (context) => {
        return await axios.get('/user/settings')
            .then(response => {
                context.commit('SET_AUTH_USER_SETTINGS', response.data);
            })
    }

}

const getters = {
    AUTH_USER: state => {
        return state.authUser;
    },
    AUTH_USER_SETTINGS: state => {
        return state.settings;
    },
}
export default {
    state, getters, mutations, actions
}
