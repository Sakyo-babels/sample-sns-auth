const error = {
    namespaced: true,
    state: () => ({
        code: null,
    }),
    mutations: {
        setCode(state, code) {
            state.code = code;
        }
    },
}

export default error;
