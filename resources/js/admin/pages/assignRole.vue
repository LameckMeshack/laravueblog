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
                            v-model="data.id"
                            placeholder="select user type"
                            style="width: 300px"
                            @on-change="changeAdmin"
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
                                    {{ r.resourceName }}
                                </td>
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
                            <div class="center_button">
                                <Button
                                    type="primary"
                                    :isloading="isSending"
                                    :disabled="isSending"
                                    @click="assignRoles"
                                    >{{
                                        isSending ? "Loading..." : "Assign"
                                    }}</Button
                                >
                            </div>
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
                id: null,
            },
            resources: [
                {
                    resourceName: "Home",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "/",
                },

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
                    name: "category",
                },
                {
                    resourceName: "Create Blog",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "createBlog",
                },
                {
                    resourceName: "Blogs",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "Blogs",
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
            defaultResourcesPermission: [
                {
                    resourceName: "Home",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "/",
                },
                {
                    resourceName: "Tags",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "tags",
                },
                {
                    resourceName: "Category",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "category",
                },
                {
                    resourceName: "Create Blog",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "createBlog",
                },
                {
                    resourceName: "Blogs",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "Blogs",
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
            isSending: false,
            roles: [],
        };
    },
    methods: {
        async assignRoles() {
            let data = JSON.stringify(this.resources);
            const res = await this.callApi("post", "app/assign_roles", {
                permission: data,
                id: this.data.id,
            });
            if (res.status == 200) {
                this.i("Role has been assigned successfully");

                // let index = this.roles.find((x) => x.id == this.data.id);
                // index.permission = data;
                // same code
                let index = this.roles.findIndex((x) => x.id == this.data.id);
                console.log(index);
                this.roles[index].permission = data;
            } else {
                this.swr();
            }
        },
        changeAdmin() {
            this.resources = JSON.parse(
                this.roles.find((x) => x.id == this.data.id)?.permission ||
                    JSON.stringify(this.defaultResourcesPermission)
            );
        },
    },
    async created() {
        const res = await this.callApi("get", "app/get_roles");
        if (res.status == 200) {
            this.roles = res.data;
            if (res.data.length) {
                this.data.id = res.data[0].id;
                if (res.data[0].permission) {
                    // this.resources = JSON.parse(res.data[0].permission);
                    this.resources = this.defaultResourcesPermission
                }
            }
        } else {
            this.swr();
        }
    },
};
</script>
