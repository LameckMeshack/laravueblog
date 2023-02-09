<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Blogs<Button
                            v-if="isWritePermitted"
                            @click="$router.push('/createblog')"
                            ><Icon type="md-add" />Add Tag</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Categories</th>
                                <th>Tags</th>
                                <th>Views</th>
                                <th
                                    v-if="
                                        isDeletePermitted || isUpdatePermitted
                                    "
                                >
                                    Action
                                </th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->

                            <tr v-for="(blog, i) in blogs" :key="i">
                                <template
                                    style="position: inherit"
                                    v-if="blogs.length"
                                >
                                    <td>{{ blog.id }}</td>
                                    <td class="_table_name">
                                        {{ blog.title }}
                                    </td>
                                    <td>
                                        <span
                                            class="_table_name"
                                            v-for="(c, j) in blog.cat"
                                            :key="j"
                                        >
                                            <Tag color="default">{{
                                                c.categoryName
                                            }}</Tag>
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="_table_name"
                                            v-for="(t, j) in blog.tag"
                                            :key="j"
                                        >
                                            <Tag color="default">{{
                                                t.tagName
                                            }}</Tag>
                                        </span>
                                    </td>

                                    <td class="_table_name">
                                        {{ blog.view }}
                                    </td>
                                    <td>
                                        <Button
                                            v-if="isUpdatePermitted"
                                            type="info"
                                            size="small"
                                            @click="showEditingModal(blog, i)"
                                            >Visit Blog</Button
                                        >
                                        <Button
                                            v-if="isUpdatePermitted"
                                            type="info"
                                            size="small"
                                            @click="showEditingModal(blog, i)"
                                            >Edit</Button
                                        >
                                        <Button
                                            v-if="isDeletePermitted"
                                            type="error"
                                            size="small"
                                            @click="showDeletingModal(blog, i)"
                                            >Delete</Button
                                        >
                                    </td>
                                </template>
                            </tr>
                        </table>
                    </div>
                </div>

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
            isAdding: false,
            blogs: [],
            index: -1,
            isDeleting: false,
            deleteItem: {},
            showDeleteModal: false,
            deletingIndex: -1,
        };
    },
    components: { DeleteModal },
    methods: {
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
        const res = await this.callApi("get", "app/get_blogs");
        if (res.status == 200) {
            this.blogs = res.data;
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
