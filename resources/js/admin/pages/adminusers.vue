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
                                            @click="showEditingModal(email, i)"
                                            >Edit</Button
                                        >
                                        <Button
                                            type="error"
                                            size="small"
                                            @click="showDeletingModal(email, i)"
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
                            <Option value="Admin">Admin</Option>
                            <Option value="Editor">Editor</Option>
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
                    title="Edit Tag"
                    :mask-closable="false"
                    :closable="false"
                >
                    <Input
                        v-model="editData.tagName"
                        placeholder="Edit a tag name"
                        class="modal_input"
                        @on-keyup.enter="editTag"
                    ></Input>
                    <div slot="footer">
                        <Button type="default" @click="showEditModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="editTag"
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
                tagName: "",
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
        async addAdmin() {
            const { fullName, email, password, userType } = this.data;
            if (!fullName.trim()) return this.e("Full name is required");
            if (!email.trim()) return this.e("email is required");
            if (!password.trim()) return this.e("password is required");
            if (!userType.trim()) return this.e("userType is required");
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
        async editTag() {
            if (this.editData.tagName.trim() == "")
                return this.e("Tag name is required");
            const res = await this.callApi(
                "post",
                "app/edit_tag",
                this.editData
            );
            if (res.status == 200) {
                this.users[this.index].tagName = this.editData.tagName;
                this.s("Tag edited successfully");
                this.showEditModal = false;
                this.editData.tagName = "";
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

        showEditingModal(tag, index) {
            let obj = {
                id: tag.id,
                tagName: tag.tagName,
            };
            this.showEditModal = true;
            this.index = index;
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
        const res = await this.callApi("get", "app/get_users");
        if (res.status == 200) {
            this.users = res.data;
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
