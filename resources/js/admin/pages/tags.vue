<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Tags<Button @click="addModal = true"
                            ><Icon type="md-add" />Add Tag</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Tag name</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->

                            <tr v-for="(tag, i) in tags" :key="i">
                                <template
                                    style="position: inherit"
                                    v-if="tags.length"
                                >
                                    <td>{{ tag.id }}</td>
                                    <td class="_table_name">
                                        {{ tag.tagName }}
                                    </td>
                                    <td>{{ tag.created_at }}</td>
                                    <td>
                                        <Button
                                            type="info"
                                            size="small"
                                            @click="showEditingModal(tag, i)"
                                            >Edit</Button
                                        >
                                        <Button
                                            type="error"
                                            size="small"
                                            @click="showDeletingModal(tag, i)"
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
                    title="Add Tag"
                    :mask-closable="false"
                    :closable="false"
                >
                    <Input
                        v-model="data.tagName"
                        placeholder="Add a tag name"
                        class="modal_input"
                        @on-keyup.enter="addTag"
                    ></Input>
                    <div slot="footer">
                        <Button type="default" @click="addModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="addTag"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{ isAdding ? "Adding" : "Add Tag" }}</Button
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
                tagName: "",
            },
            addModal: false,
            isAdding: false,
            isEditing: false,
            showEditModal: false,
            tags: [],
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
        async addTag() {
            if (this.data.tagName.trim() == "")
                return this.e("Tag name is required");
            const res = await this.callApi("post", "app/create_tag", this.data);
            if (res.status == 201) {
                this.tags.unshift(res.data);
                this.s("Tag added successfully");
                this.addModal = false;
                this.data.tagName = "";
            } else {
                if (res.status == 422) {
                    if (res.data.errors.tagName) {
                        this.i(res.data.errors.tagName);
                    }
                } else {
                    this.swr();
                }
            }
        },
        //edit tags
        async editTag() {
            if (this.editData.tagName.trim() == "")
                return this.e("Tag name is required");
            const res = await this.callApi(
                "post",
                "app/edit_tag",
                this.editData
            );
            if (res.status == 200) {
                this.tags[this.index].tagName = this.editData.tagName;
                this.s("Tag edited successfully");
                this.showEditModal = false;
                this.editData.tagName = "";
            } else {
                if (res.status == 422) {
                    if (res.data.errors.tagName)
                        this.i(res.data.errors.tagName);
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
        const res = await this.callApi("get", "app/get_tags");
        if (res.status == 200) {
            this.tags = res.data;
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
                this.tags.splice(this.deletingIndex, 1);
            }
        },
    },
};
</script>
