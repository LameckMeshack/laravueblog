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
    },
};
