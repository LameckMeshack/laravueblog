<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Admin<Button @click="addModal = true"
                            ><Icon type="md-add" />Add Admin</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User type</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->

                            <tr v-for="(user, i) in users" :key="i">
                                <template
                                    style="position: inherit"
                                    v-if="users.length"
                                >
                                    <td>{{ user.id }}</td>
                                    <td class="_table_name">
                                        {{ user.fullName }}
                                    </td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.userType }}</td>
                                    <td>{{ user.created_at }}</td>

                                    <td>
                                        <Button
                                            type="info"
                                            size="small"
                                            @click="showEditingModal(user, i)"
                                            >Edit</Button
                                        >
                                        <Button
                                            type="error"
                                            size="small"
                                            @click="showDeletingModal(user, i)"
                                            >Delete</Button
                                        >
                                    </td>
                                </template>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- tag adding modal -->
                <Modal
                    v-model="addModal"
                    title="Add admin"
                    :mask-closable="false"
                    :closable="false"
                >
                    <div class="space">
                        <Input
                            type="text"
                            v-model="data.fullName"
                            placeholder="Full Name"
                        />
                    </div>

                    <div class="space">
                        <Input
                            type="email"
                            v-model="data.email"
                            placeholder="email"
                        />
                    </div>
                    <div class="space">
                        <Input
                            type="password"
                            v-model="data.password"
                            placeholder="password"
                        />
                    </div>
                    <div class="space">
                        <Select
                            v-model="data.userType"
                            placeholder="select user type"
                        >
                            <Option
                                :value="role.id"
                                v-for="(role, i) in roles"
                                :key="i"
                                v-if="roles.length"
                                >{{ role.roleName }}</Option
                            >
                        </Select>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="addAdmin"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{ isAdding ? "Adding" : "Add Admin" }}</Button
                        >
                    </div>
                </Modal>
                <!-- tag editing modal -->

                <Modal
                    v-model="showEditModal"
                    title="Edit Admin"
                    :mask-closable="false"
                    :closable="false"
                >
                    <div class="space">
                        <Input type="text" v-model="editData.fullName" />
                    </div>

                    <div class="space">
                        <Input type="email" v-model="editData.email" />
                    </div>
                    <div class="space">
                        <Input type="password" v-model="editData.password" />
                    </div>
                    <div class="space">
                        <Select v-model="editData.userType">
                            <Option value="Admin">Admin</Option>
                            <Option value="Editor">Editor</Option>
                        </Select>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="showEditModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="editAdmin"
                            :disabled="isEditing"
                            :loading="isEditing"
                            >{{ isEditing ? "Editing" : "Edit Tag" }}</Button
                        >
                    </div>
                </Modal>
                <!-- tag deleting modal -->
                <DeleteModal />
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters } from "vuex";
import DeleteModal from "../components/deleteModal.vue";

export default {
    data() {
        return {
            data: {
                fullName: "",
                email: "",
                password: "",
                userType: "",
            },
            addModal: false,
            isAdding: false,
            isEditing: false,
            showEditModal: false,
            users: [],
            editData: {
                fullName: "",
                email: "",
                password: "",
                userType: "",
            },
            editIndex: -1,
            index: -1,
            isDeleting: false,
            deleteItem: {},
            showDeleteModal: false,
            deletingIndex: -1,
            roles: [],
            role_id: null,
        };
    },
    components: { DeleteModal },
    methods: {
        async addAdmin() {
            for (let val in this.data) {
                this.checkInput(val);
            }
            const res = await this.callApi(
                "post",
                "app/create_user",
                this.data
            );
            if (res.status == 201) {
                this.users.unshift(res.data);
                this.s("Admin has been added successfully");
                this.addModal = false;
                this.data = {
                    fullName: "",
                    email: "",
                    password: "",
                    userType: "",
                };
            } else {
                if (res.status == 422) {
                    for (let i in res.data.errors) {
                        this.e(res.data.errors[i][0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        //edit users
        async editAdmin() {
            for (let val in this.editData) {
                this.checkInput(val);
            }
            const res = await this.callApi(
                "post",
                "app/edit_user",
                this.editData
            );
            if (res.status == 200) {
                // this.users[this.editIndex] = this.editData;
                this.callApi("get", "app/get_users");

                this.s("Admin edited successfully");
                this.showEditModal = false;
                this.editData = {
                    fullName: "",
                    email: "",
                    password: "",
                    userType: "",
                };
                //set editIndex
            } else {
                if (res.status == 422) {
                    for (let i in res.data.errors) {
                        this.e(res.data.errors[i][0]);
                    }
                } else {
                    this.swr();
                }
            }
        },

        showEditingModal(user, index) {
            let obj = {
                id: user.id,
                fullName: user.fullName,
                email: user.email,
                userType: user.userType,
            };
            this.showEditModal = true;
            this.editIndex = index;
            this.editData = obj;
        },
        showDeletingModal(tag, index) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "app/delete_tag",
                data: tag,
                deletingIndex: index,
                isDeleted: false,
            };
            this.$store.commit("setDeleteModalObj", deleteModalObj);
        },
    },
    async created() {
        const [res, resRoles] = await Promise.all([
            this.callApi("get", "app/get_users"),
            this.callApi("get", "app/get_roles"),
        ]);
        if (res.status == 200) {
            this.users = res.data;
        } else {
            this.swr();
        }

        if (resRoles.status == 200) {
            this.roles = resRoles.data;
        } else {
            this.swr();
        }
    },
    computed: {
        ...mapGetters(["getDeleteModalObj"]),
    },
    watch: {
        getDeleteModalObj(obj) {
            if (obj.isDeleted) {
                this.users.splice(this.deletingIndex, 1);
            }
        },
    },
};
</script>
