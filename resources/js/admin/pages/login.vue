<template>
    <div>
        <div class="container">
            <div
                class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col_md_4"
            >
                <div class="login_head">
                    <h1 class="_text_center">Login to the dashboard</h1>
                </div>
                <div class="space">
                    <Input
                        autofocus
                        type="email"
                        required
                        v-model="loginData.email"
                        placeholder="email"
                    />
                </div>
                <div class="space">
                    <Input
                        type="password"
                        required
                        v-model="loginData.password"
                        placeholder="password"
                    />
                </div>
                <div class="login_footer">
                    <Button
                        long
                        type="primary"
                        :disabled="isLogging"
                        :loading="isLogging"
                        @click="login"
                    >
                        {{ isLogging ? "Logging...." : "Login" }}
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            loginData: {
                email: "",
                password: "",
            },
            isLogging: false,
        };
    },
    methods: {
        async login() {
            this.checkInput(this.loginData);
            if (this.loginData.password.length < 6) {
                this.e("password");
            }
            this.isLogging = true;
            const res = await this.callApi(
                "post",
                "app/admin_login",
                this.loginData
            );
            // console.log(res);

            if (res.status === 200) {
                this.s(res.data.msg);
                window.location = "/";
            } else {
                if (res.status === 401) {
                    this.e(res.data.msg);
                } else if (res.status === 422) {
                    for (let i in res.data.errors) {
                        this.e(res.data.errors[i][0]);
                    }
                } else {
                    this.swr();
                }
            }
            this.isLogging = false;
        },
    },
};
</script>
<style scoped>
.container {
    width: fit-content;
    margin: 0 auto;
}
._1adminOverveiw_table_recent {
    width: 400px;
    margin-top: 220px;
}
</style>
