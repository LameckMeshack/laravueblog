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

                            <tr v-for="(r, i) in resources" :key="i">
                                <td>
                                    <Checkbox v-model="r.read" />
                                </td>
                                <td>
                                    <Checkbox v-model="r.write" />
                                </td>
                                <td>
                                    <Checkbox v-model="r.update" />
                                </td>
                                <td>
                                    <Checkbox v-model="r.delete" />
                                </td>
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
            resources: [
                {
                    resourceName: "Tags",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "Tags",
                },

                {
                    resourceName: "Category",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "Category",
                },

                {
                    resourceName: "Admin users",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "adminusers",
                },

                {
                    resourceName: "home",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "home",
                },
                {
                    resourceName: "Roles",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "role",
                },
                {
                    resourceName: "Assign Role",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "assignrole",
                },
            ],

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
