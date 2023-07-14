
<template>
    <div style="padding: 10px;">
        <h1>
            Department List
        </h1>

        <div class="filter-container">
            <el-input
                v-model="query.keyword"
                placeholder="Keyword"
                style="width: 200px;"
            />
            <el-button type="primary" @click="handleFilter">
                <el-icon style="vertical-align: middle">
                    <Search />
                </el-icon>
                <span style="vertical-align: middle"> Search </span>
            </el-button>
            <el-button type="primary" @click="handleCreate">
                <span style="vertical-align: middle"> Add </span>
            </el-button>
        </div>


        <el-table :data="departments">
            <el-table-column align="center" label="ID" width="80">
                <template #default="scope">
                    <span>{{ scope.row.id }}</span>
                </template>
            </el-table-column>

            <el-table-column prop="name" align="center" sortable label="Name" width="200">
                <template #default="scope">
                    <span>{{ scope.row.name }}</span>
                </template>
            </el-table-column>

            <el-table-column prop="email" align="center" sortable label="Email" width="200">
                <template #default="scope">
                    <span>{{ scope.row.email }}</span>
                </template>
            </el-table-column>

            <el-table-column prop="number" align="center" sortable label="Number">
                <template #default="scope">
                    <span>{{ scope.row.number }}</span>
                </template>
            </el-table-column>

            <el-table-column prop="total_credit" align="center" sortable label="Total Credit">
                <template #default="scope">
                    <span>{{ scope.row.total_credit }}</span>
                </template>
            </el-table-column>
            <el-table-column prop="department_head" align="center" sortable label="Department Head">
                <template #default="scope">
                    <span>{{ scope.row.department_head }}</span>
                </template>
            </el-table-column>


            <el-table-column prop="id" label="Operations" >
                <template  #default="scope">
                    <!-- v-if="logged_in_user && logged_in_user.role === 'admin'" -->
                    <el-icon :size="20" :color="'blue'"
                            style="width: 1em; height: 1em; margin-right: 8px"
                            @click="handleEdit(scope.row.id);"
                    >
                        <Edit />
                    </el-icon>
                    <el-icon :size="20" :color="'orange'"
                            style="width: 1em; height: 1em; margin-right: 8px"
                            @click="handleShow(scope.row.id);"
                    >
                        <View />
                    </el-icon>
                    <el-icon :size="20" :color="'red'"
                            style="width: 1em; height: 1em; margin-right: 8px"
                            @click="handleDelete(scope.row.id, scope.row.name);"
                    >
                        <Delete />
                    </el-icon>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog
            :title="formTitle"
            v-model="dialogFormVisible"
        >
            <form-component
                v-if="dialogFormVisible"
                :department="currentDepartment"
                :mode="mode"
                @dismissDialog="dismissDialog"
            />
        </el-dialog>

        <div class="demo-pagination-block">
            <el-pagination
                v-show="total>0"
                :page-size="query.limit"
                layout="total, sizes, prev, pager, next"
                :total="total"
                :page-count="totalPages"
                :page-sizes="[1, 2, 5, 10, 20, 50, 100]"
                @size-change="handleSizeChange"
                @current-change="handlePageChange"
            />
        </div>

    </div>
</template>



<script >
import { ElMessage, ElMessageBox } from 'element-plus'
import FormComponent from "./FormComponent.vue";

export default {
    name: 'DepartmentList',
    components: { FormComponent },
    data() {
        return {
            departments: [],
            logged_in_user: null,
            downloading: false,
            loading: false,
            mode: 'create',
            dialogFormVisible: false,
            formTitle: 'Create Department',
            currentDepartment: {
                name: '',
                email: '',
                number: '',
                total_credit: '',
                department_head: '',
            },
            query: {
                page: 1,
                limit: 10,
                keyword: '',
            },
            total: 10,
            totalPages: null,
            pageSize: 5,
            errors: [],
        };
    },
    async mounted() {
        await axios.get(`/logged_in_user`).
                then((res) => {
                    this.logged_in_user = res.data;
                    console.log('logged_in_user:', this.logged_in_user);
                });
        await this.getList();
    },
    methods: {
        dismissDialog() {
            this.dialogFormVisible = false;
            this.currentDepartment = {
                name: '',
                email: '',
                number: '',
                total_credit: '',
                department_head: '',
            };
            this.getList();
        },

        async getList() {
            this.loading = true;
            let params = {
                limit: this.pageSize,
                keyword: this.query.keyword,
                page: this.query.page,
            }
            console.log('params', params);
            await axios.get(`/api/departments`, {params}).
                    then((res) => {
                        console.log('res:', res);
                        this.departments = res.data.data;
                        this.query.page = res.data.current_page;
                        this.total = res.data.total;
                        this.totalPages = Math.ceil(res.data.total / this.pageSize); // Calculate the total number of pages
                    });
            this.loading = false;
        },
        handleFilter() {
            this.query.page = 1;
            this.getList();
        },
        handleCreate(){
            this.mode = 'create';
            this.currentDepartment = {
                name: '',
                email: '',
                number: '',
                total_credit: '',
                department_head: '',
            };
            this.dialogFormVisible = true;
        },
        handleEdit(id){
            console.log('List in handleEdit', this.departments);
            this.currentDepartment = this.departments.find(department => department.id === id);
            this.mode = 'edit';
            this.formTitle = 'Edit Department';
            this.dialogFormVisible = true;
        },
        handleShow(id){
            this.currentDepartment = this.departments.find(department => department.id === id);
            this.mode = 'show';
            this.formTitle = 'Show Department';
            this.dialogFormVisible = true;
        },

        handleDelete(id, name) {
            this.$confirm('This will permanently delete department ' + name + '. Continue?', 'Warning', {
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Cancel',
                        type: 'warning',
                    }).then(() => {
                        axios
                        .delete('api/departments/'+id)
                        .then(response => {
                            this.$message({
                                type: 'success',
                                message: 'Delete completed',
                            });
                            this.getList();
                        }).catch(error => {
                            console.log(error);
                        });
                    }).catch(() => {
                        this.$message({
                            type: 'info',
                            message: 'Delete canceled',
                        });
                    });
        },

        handleSizeChange(val) {
            this.pageSize = val;
            this.getList();
        },
        handlePageChange(currentPage) {
            this.query.page = currentPage;
            this.getList();
        },

    }
};
</script>



<style scoped>
.filter-container {
  padding-bottom: 10px;
}
.demo-pagination-block  {
  margin-top: 10px;
}
.upload-demo {
    display: inline;
    margin-left: 12px;
}
</style>
