<template>
    <Modal
        :value="getDeleteModalObj.showDeleteModal"
        :mask-closable="false"
        :closable="false"
        width="360"
    >
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
            <Button size="large" @click="closeModal()">Close</Button>

            <Button
                type="error"
                size="large"
                :loading="isDeleting"
                :disabled="isDeleting"
                @click="deleteTag()"
                >Delete</Button
            >
        </template>
    </Modal>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            isDeleting: false,
        };
    },
    methods: {
        //delete category
        async deleteTag() {
            this.isDeleting = true;
            const res = await this.callApi(
                "post",
                this.getDeleteModalObj.deleteUrl,
                this.getDeleteModalObj.data
            );
            if (res.status == 200) {
                this.s("category deleted successfully");
                this.$store.commit("setDeleteModal", true);
            } else {
                this.swr();
                this.$store.commit("setDeleteModal", false);
            }
        },
        closeModal() {
            this.$store.commit("setDeleteModal", false);
        },
    },
    computed: {
        ...mapGetters(["getDeleteModalObj"]),
    },
};
</script>

<style></style>
