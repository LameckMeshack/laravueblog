<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Categories<Button @click="addModal = true"
                            ><Icon type="md-add" />Add Category</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Category name</th>
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
                <!-- category adding modal -->
                <Modal
                    v-model="addModal"
                    title="Add category"
                    :mask-closable="false"
                    :closable="false"
                >
                    <div class="space"></div>
                    <Upload
                        type="drag"
                        action="/app/upload"
                        :headers="{
                            'x-csrf-token': token,
                            'X-Requested-With': 'XMLHttpRequest',
                        }"
                        :format="['jpg', 'jpeg', 'png']"
                        :on-success="handleSuccess"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                    >
                        <div style="padding: 20px 0">
                            <Icon
                                type="ios-cloud-upload"
                                size="52"
                                style="color: #3399ff"
                            ></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                    <div class="image_thumb" v-if="data.iconImage">
                        <img
                            :src="`/uploads/${data.iconImage}`"
                            alt=""
                            srcset=""
                        />
                    </div>
                    <Input
                        v-model="data.tagName"
                        placeholder="Add catogory name"
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
                <!-- delete alert modal -->
                <Modal v-model="showDeleteModal" width="360">
                    <template #header>
                        <p style="color: #f60; text-align: center">
                            <Icon type="ios-information-circle"></Icon>
                            <span>Delete confirmation</span>
                        </p>
                    </template>
                    <div style="text-align: center">
                        <p>Are you sure you want to delete category?</p>
                    </div>
                    <template #footer>
                        <Button
                            type="error"
                            size="large"
                            long
                            :loading="isDeleting"
                            :disabled="isDeleting"
                            @click="deleteTag()"
                            >Delete</Button
                        >
                    </template>
                </Modal>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            data: {
                iconImage: "",
                categoryName: "",
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
            token: "",
        };
    },

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
        //delete tag
        async deleteTag() {
            this.isDeleting = true;
            const res = await this.callApi(
                "post",
                "app/delete_tag",
                this.deleteItem
            );
            if (res.status == 200) {
                this.tags.splice(this.deletingIndex, 1);
                this.s("Tag deleted successfully");
                this.isDeleting = false;
                this.showDeleteModal = false;
            } else {
                this.swr();
            }
            this.isDeleting = false;
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
            this.deleteItem = tag;
            this.deletingIndex = index;
            this.showDeleteModal = true;
        },
        handleSuccess(res, file) {
            this.data.iconImage = res.file;
        },
        handleFormatError(file) {
            this.$Notice.warning({
                title: "The file format is incorrect",
                desc:
                    "File format of " +
                    file.name +
                    " is incorrect, please select jpg or png.",
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: "Exceeding file size limit",
                desc: "File  " + file.name + " is too large, no more than 2M.",
            });
        },
    },

    async created() {
        this.token = window.Laravel.csrfToken;

        const res = await this.callApi("get", "app/get_tags");
        if (res.status == 200) {
            this.tags = res.data;
        } else {
            this.swr();
        }
    },
};
</script>
