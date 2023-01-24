<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Role Management<Button @click="addModal = true"
                            ><Icon type="md-add" />Add a new role</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Role Type</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->

                            <tr v-for="(role, i) in roles" :key="i">
                                <template
                                    style="position: inherit"
                                    v-if="roles.length"
                                >
                                    <td>{{ role.id }}</td>
                                    <td class="_table_name">
                                        {{ role.roleName }}
                                    </td>
                                    <td>{{ role.created_at }}</td>
                                    <td>
                                        <Button
                                            type="info"
                                            size="small"
                                            @click="showEditingModal(role, i)"
                                            >Edit</Button
                                        >
                                        <Button
                                            type="error"
                                            size="small"
                                            @click="showDeletingModal(role, i)"
                                            >Delete</Button
                                        >
                                    </td>
                                </template>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- role adding modal -->
                <Modal
                    v-model="addModal"
                    title="Add Role"
                    :mask-closable="false"
                    :closable="false"
                >
                    <Input
                        v-model="data.roleName"
                        placeholder="Role Name"
                        class="modal_input"
                        @on-keyup.enter="addRole"
                    ></Input>
                    <div slot="footer">
                        <Button type="default" @click="addModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="addRole"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{ isAdding ? "Adding" : "Add Role" }}</Button
                        >
                    </div>
                </Modal>
                <!-- role editing modal -->

                <Modal
                    v-model="showEditModal"
                    title="Edit Role"
                    :mask-closable="false"
                    :closable="false"
                >
                    <Input
                        v-model="editData.roleName"
                        placeholder="Edit a role name"
                        class="modal_input"
                        @on-keyup.enter="editRole"
                    ></Input>
                    <div slot="footer">
                        <Button type="default" @click="showEditModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="editRole"
                            :disabled="isEditing"
                            :loading="isEditing"
                            >{{ isEditing ? "Editing" : "Edit Role" }}</Button
                        >
                    </div>
                </Modal>
                <!-- role deleting modal -->
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
                roleName: "",
            },
            addModal: false,
            isAdding: false,
            isEditing: false,
            showEditModal: false,
            roles: [],
            editData: {
                roleName: "",
            },
            index: -1,
            isDeleting: false,
            deleteItem: {},
            showDeleteModal: false,
            deletingIndex: -1,
        };
    },
    components: { DeleteModal },
    methods: {
        async addRole() {
            if (this.data.roleName.trim() == "")
                return this.e("Role name is required");
            const res = await this.callApi(
                "post",
                "app/create_role",
                this.data
            );
            if (res.status == 201) {
                this.roles.unshift(res.data);
                this.s("Role added successfully");
                this.addModal = false;
                this.data.roleName = "";
            } else {
                if (res.status == 422) {
                    if (res.data.errors.roleName) {
                        this.i(res.data.errors.roleName);
                    }
                } else {
                    this.swr();
                }
            }
        },
        //edit roles
        async editRole() {
            if (this.editData.roleName.trim() == "")
                return this.e("Role name is required");
            const res = await this.callApi(
                "post",
                "app/edit_role",
                this.editData
            );
            if (res.status == 200) {
                this.roles[this.index].roleName = this.editData.roleName;
                this.s("Role edited successfully");
                this.showEditModal = false;
                this.editData.roleName = "";
            } else {
                if (res.status == 422) {
                    if (res.data.errors.roleName)
                        this.i(res.data.errors.roleName);
                } else {
                    this.swr();
                }
            }
        },

        showEditingModal(role, index) {
            let obj = {
                id: role.id,
                roleName: role.roleName,
            };
            this.showEditModal = true;
            this.index = index;
            this.editData = obj;
        },
        showDeletingModal(role, index) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "app/delete_role",
                data: role,
                deletingIndex: index,
                isDeleted: false,
            };
            this.$store.commit("setDeleteModalObj", deleteModalObj);
        },
    },
    async created() {
        const res = await this.callApi("get", "app/get_roles");
        if (res.status == 200) {
            this.roles = res.data;
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
                this.roles.splice(this.deletingIndex, 1);
            }
        },
    },
};
</script>
