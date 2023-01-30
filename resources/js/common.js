import { mapGetters } from "vuex";

export default {
    data() {
        return {};
    },
    methods: {
        async callApi(method, url, dataObj) {
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj,
                });
            } catch (error) {
                return error.response;
            }
        },
        i(desc, title = "Hey") {
            this.$Notice.info({
                title,
                desc,
            });
        },
        s(desc, title = "Great!") {
            this.$Notice.success({
                title,
                desc,
            });
        },
        w(desc, title = "Oops!") {
            this.$Notice.warning({
                title,
                desc,
            });
        },
        e(desc, title = "Hey") {
            this.$Notice.error({
                title,
                desc,
            });
        },
        swr(desc = "Something went wrong! Please try again.", title = "Opps") {
            this.$Notice.error({
                title,
                desc,
            });
        },
        //check if inputs are empty
        checkInput(val) {
            if (val !== null && typeof val === "object") {
                for (let i in val) {
                    if (
                        !val[i] ||
                        (typeof val[i] === "string" && val[i].length < 1)
                    ) {
                        return this.e(`${i} is required`);
                    }
                }
            } else if (!val || (typeof val === "string" && val.length < 1)) {
                return this.i(`${val} is required`);
            }
        },

        checkUserPermissions(key) {
            if (!this.userPermission) return true;
            let isPermitted = false;
            for (let d of this.userPermission) {
                if (this.$route.name == d.name) {
                    if (d[key]) {
                        isPermitted = true;
                        break;
                    } else {
                        break;
                    }
                }
            }
            return isPermitted;
        },
    },

    computed: {
        ...mapGetters({
            userPermission: "getUserPermissions",
        }),
        isReadPermitted() {
            return this.checkUserPermissions("read");
        },
        isWritePermitted() {
            return this.checkUserPermissions("write");
        },
        isUpdatePermitted() {
            return this.checkUserPermissions("update");
        },
        isDeletePermitted() {
            return this.checkUserPermissions("delete");
        },
    },
};
