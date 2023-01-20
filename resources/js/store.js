import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        deleteModalObj: {
            showDeleteModal: false,
            deleteUrl: "",
            data: null,
            deletingIndex: -1,
            isDeleted: false,
        },
        user: false,
    },
    mutations: {
        setDeleteModalObj(state, data) {
            state.deleteModalObj = data;
        },
        setDeleteModal(state, data) {
            const deleteModalObj = {
                showDeleteModal: false,
                deleteUrl: "",
                data: null,
                deletingIndex: -1,
                isDeleted: data,
            };
            state.deleteModalObj = deleteModalObj;
        },
        updateUser(state, data) {
            state.user = data;
        },
    },
    getters: {
        getDeleteModalObj(state) {
            return state.deleteModalObj;
        },
    },
    actions: {},

    modules: {},
});
