<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Role Management<Select
                            v-model="data.role_id"
                            placeholder="select user type"
                            style="width: 300px"
                        >
                            <Option
                                :value="role.id"
                                v-for="(role, i) in roles"
                                :key="i"
                                >{{ role.roleName }}</Option
                            >
                        </Select>
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>Resource Name</th>
                                <th>Read</th>
                                <th>Write</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->

                            <tr>
                                <td>Blog</td>
                                <td>yes</td>
                                <td>yes</td>
                                <td>yes</td>
                                <td>yes</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
            </div>
        </div>
    </div>
</template>
<script>

export default {
    data() {
        return {
            data: {
                roleName: "",
                role_id: null,
            },
            resources:[],
            
            roles: [],
            
        };
    },
    methods: {},
    async created() {
        const res = await this.callApi("get", "app/get_roles");
        if (res.status == 200) {
            this.roles = res.data;
        } else {
            this.swr();
        }
    },
};
</script>
