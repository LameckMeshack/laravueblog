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
                            ><Icon type="md-add" />Add a new blog</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <editor
                            ref="editor"
                            autofocus
                            holder-id="codex-editor"
                            save-button-id="save-button"
                            :init-data="initData"
                            @save="onSave"
                            :config="config"
                        />
                    </div>
                    <button @click="save">save</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            config: {},
            initData: null,
            data: {},
        };
    },
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
        async save() {
            this.$refs.editor.save();
        },
        onSave(response) {
            console.log("resonse", response);
        },
    },
};
</script>
<style>
	.blog_editor {
		width: 717px;
		margin-left: 160px;
		padding: 4px 7px;
		font-size: 14px;
		border: 1px solid #dcdee2;
		border-radius: 4px;
		color: #515a6e;
		background-color: #fff;
		background-image: none;
		z-index:  -1;
	}
	.blog_editor:hover {
		border: 1px solid #57a3f3;
	}
	._input_field{
		margin: 20px 0 20px 160px;
    	width: 717px;
	}
</style>
