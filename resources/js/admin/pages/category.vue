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
                                <th>Icon image</th>
                                <th>Category name</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->

                            <tr v-for="(category, i) in categoryList" :key="i">
                                <template
                                    style="position: inherit"
                                    v-if="categoryList.length"
                                >
                                    <td>{{ category.id }}</td>
                                    <td class="table_image">
                                        <img :src="category.iconImage" />
                                    </td>
                                    <td class="_table_name">
                                        {{ category.categoryName }}
                                    </td>
                                    <td>{{ category.created_at }}</td>
                                    <td>
                                        <Button
                                            type="info"
                                            size="small"
                                            @click="
                                                showEditingModal(category, i)
                                            "
                                            >Edit</Button
                                        >
                                        <Button
                                            type="error"
                                            size="small"
                                            @click="
                                                showDeletingModal(category, i)
                                            "
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
                    <Input
                        v-model="data.categoryName"
                        placeholder="Add  category name"
                        class="modal_input"
                    ></Input>
                    <div class="space"></div>
                    <Upload
                        ref="uploads"
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

                    <div class="demo-upload-list" v-if="data.iconImage">
                        <img
                            :src="`/uploads/${data.iconImage}`"
                            alt=""
                            srcset=""
                        />
                        <div class="demo-upload-list-cover">
                            <!-- <Icon
                                type="ios-eye-outline"
                                @click="handleView()"
                            ></Icon> -->
                            <Icon
                                type="ios-trash-outline"
                                @click="handleRemove()"
                            ></Icon>
                        </div>
                    </div>
                    <ImagePreview
                        v-model="visible"
                        :preview-list="[data.iconImage]"
                    />

                    <div slot="footer">
                        <Button type="default" @click="addModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="addCategory"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{ isAdding ? "Adding" : "Add category" }}</Button
                        >
                    </div>
                </Modal>
                <!-- category editing modal -->

                <Modal
                    v-model="showEditModal"
                    title="Edit category"
                    :mask-closable="false"
                    :closable="false"
                >
                    <Input
                        v-model="editData.categoryName"
                        placeholder="Edit Category name"
                        class="modal_input"
                    ></Input>
                    <div class="space"></div>
                    <Upload
                        v-show="isIconNewImage"
                        ref="editDataUploads"
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

                    <div class="demo-upload-list" v-if="editData.iconImage">
                        <img :src="`${editData.iconImage}`" alt="" srcset="" />
                        <div class="demo-upload-list-cover">
                            <!-- <Icon
                                type="ios-eye-outline"
                                @click="handleView()"
                            ></Icon> -->
                            <Icon
                                type="ios-trash-outline"
                                @click="handleRemove(false)"
                            ></Icon>
                        </div>
                    </div>
                    <!-- <ImagePreview
                        v-model="visible"
                        :preview-list="[editData.iconImage]"
                    /> -->
                    <div slot="footer">
                        <Button type="default" @click="closeEditModal"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="editCategory"
                            :disabled="isEditing"
                            :loading="isEditing"
                            >{{
                                isEditing ? "Editing" : "Edit category"
                            }}</Button
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
                            @click="deleteCategory()"
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
            categoryList: [],
            editData: {
                categoryName: "",
                iconImage: "",
            },
            index: -1,
            isDeleting: false,
            deleteItem: {},
            showDeleteModal: false,
            deletingIndex: -1,
            token: "",
            visible: false,
            isIconNewImage: false,
            isEditingItem: false,
        };
    },

    methods: {
        async addCategory() {
            if (this.data.categoryName.trim() == "")
                return this.e("Category name is required");
            if (this.data.iconImage.trim() == "")
                return this.e("Icon image is required");
            this.data.iconImage = `/uploads/${this.data.iconImage}`;

            const res = await this.callApi(
                "post",
                "app/create_category",
                this.data
            );
            if (res.status == 201) {
                this.categoryList.unshift(res.data);
                this.s("Category has been added successfully");
                this.addModal = false;
                this.data.categoryName = "";
            } else {
                if (res.status == 422) {
                    if (res.data.errors.categoryName) {
                        this.i(res.data.errors.categoryName);
                    }
                    if (res.data.errors.iconImage) {
                        this.i(res.data.errors.iconImage);
                    }
                } else {
                    this.swr();
                }
            }
        },
        //edit category
        async editCategory() {
            // console.log(this.editData, "editData2");
            if (this.editData.categoryName.trim() == "")
                return this.e("Category name is required");

            if (this.editData.iconImage.trim() == "")
                return this.e("Image Icon name is required");

            // this.editData.iconImage = `/uploads/${this.editData.iconImage}`;

            const res = await this.callApi(
                "post",
                "app/edit_category",
                this.editData
            );
            if (res.status == 200) {
                this.categoryList[this.index].categoryName =
                    this.editData.categoryName;
                this.s("category edited successfully");
                this.showEditModal = false;
                this.editData.categoryName = "";
            } else {
                if (res.status == 422) {
                    if (res.data.errors.categoryName)
                        this.i(res.data.errors.categoryName);
                } else {
                    this.swr();
                }
            }
        },
        //delete category
        async deleteCategory() {
            this.isDeleting = true;
            const res = await this.callApi(
                "post",
                "app/delete_category",
                this.deleteItem
            );
            if (res.status == 200) {
                this.categoryList.splice(this.deletingIndex, 1);
                this.s("category deleted successfully");
                this.isDeleting = false;
                this.showDeleteModal = false;
            } else {
                this.swr();
            }
            this.isDeleting = false;
        },
        showEditingModal(category, index) {
            // let obj = {
            //     id: category.id,
            //     categoryName: category.categoryName,
            // };
            this.editData = category;
            this.showEditModal = true;
            this.index = index;
            this.isEditingItem = true;

            console.log(this.editData, "editData");
        },
        showDeletingModal(category, index) {
            this.deleteItem = category;
            this.deletingIndex = index;
            this.showDeleteModal = true;
        },
        handleSuccess(res, file) {
            if (this.isEditingItem) {
                return (this.edit.iconImage = res);
            }
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
        handleView(name) {
            this.data.iconImage = name;
            this.visible = true;
        },
        async handleRemove(isAdd = true) {
            let image = null;
            if (!isAdd) {
                // for editing
                this.isIconNewImage = true;
                image = this.editData.iconImage;
                this.editData.iconImage = "";
                this.$refs.editDataUploads.clearFiles();
            } else {
                // for adding
                image = this.data.iconImage;
                this.data.iconImage = "";
                this.$refs.uploads.clearFiles();
            }
            const res = await this.callApi("post", "app/delete_image", {
                imageName: image,
            });
            if (res.status != 200) {
                this.data.iconImage = image;
                this.swr();
            }
        },
        closeEditModal() {
            this.isEditingItem = false;
            this.showEditModal = false;
        },
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        const res = await this.callApi("get", "app/get_categories");
        if (res.status == 200) {
            this.categoryList = res.data;
        } else {
            this.swr();
        }
    },
};
</script>
