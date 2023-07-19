
<template>
    <div style="padding: 10px;">
        <h1>
            Student List
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


        <el-table :data="students">
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

            <el-table-column prop="department_name" align="center" sortable label="Department">
                <template #default="scope">
                    <span>{{ scope.row.department_name }}</span>
                </template>
            </el-table-column>
            <el-table-column prop="number" align="center" sortable label="Number">
                <template #default="scope">
                    <span>{{ scope.row.number }}</span>
                </template>
            </el-table-column>

            <el-table-column prop="guardian_number" align="center" sortable label="Guardian Number">
                <template #default="scope">
                    <span>{{ scope.row.guardian_number }}</span>
                </template>
            </el-table-column>

            <el-table-column prop="image" align="center" sortable label="Image">
                <template #default="scope">
                <img
                    v-if="scope.row.image !==null"
                    :src="'/uploads/students/' + scope.row.image.filename"
                    width="100"
                    height="100"
                >
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
                :student="currentStudent"
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
    name: 'StudentList',
    components: { FormComponent },
    data() {
        return {
            students: [],
            logged_in_user: null,
            downloading: false,
            loading: false,
            mode: 'create',
            dialogFormVisible: false,
            formTitle: 'Create Student',
            currentStudent: {
                name: '',
                email: '',
                number: '',
                image: null,
                guardian_number: '',
                department_id: '',
            },
            query: {
                page: 1,
                limit: 10,
                keyword: '',
            },
            total: null,
            totalPages: null,
            pageSize: 10,
            errors: [],
        };
    },
    async mounted() {
        await axios.get(`/logged_in_user`).
                then((res) => {
                    this.logged_in_user = res.data;
                    // console.log('logged_in_user:', this.logged_in_user);
                });
        await this.getList();
    },
    methods: {
        dismissDialog() {
            this.dialogFormVisible = false;
            this.currentStudent = {
                name: '',
                email: '',
                number: '',
                image: null,
                guardian_number: '',
                department_id: '',
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
            // console.log('params', params);
            await axios.get(`/api/students`, {params}).
                    then((res) => {
                        console.log('res:', res);
                        this.students = res.data.data;
                        this.query.page = res.data.meta.current_page;
                        this.total = res.data.meta.total;
                        this.totalPages = Math.ceil(this.total / this.pageSize); // Calculate the total number of pages
                    });
            this.loading = false;
        },
        handleFilter() {
            this.query.page = 1;
            this.getList();
        },
        handleCreate(){
            this.mode = 'create';
            this.currentStudent = {
                name: '',
                email: '',
                number: '',
                image: null,
                guardian_number: '',
                department_id: '',
            };
            this.dialogFormVisible = true;
        },
        handleEdit(id){
            this.currentStudent = this.students.find(student => student.id === id);
            this.mode = 'edit';
            this.formTitle = 'Edit Student';
            this.dialogFormVisible = true;
        },
        handleShow(id){
            this.currentStudent = this.students.find(student => student.id === id);
            this.mode = 'show';
            this.formTitle = 'Show Student';
            this.dialogFormVisible = true;
        },

        handleDelete(id, name) {
            this.$confirm('This will permanently delete student ' + name + '. Continue?', 'Warning', {
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Cancel',
                        type: 'warning',
                    }).then(() => {
                        axios
                        .delete('api/students/'+id)
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
