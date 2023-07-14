<template>
    <el-form ref="ruleFormRef" :model="department" class="demo-department"
        label-position="top"
        status-icon
    >
        <el-text tag="b" type="primary" size="large">View Department</el-text>


        <el-card class="box-card">
            <h4>Invoice for AccBeez</h4>
            <p><strong>Description:</strong> {{ department.description }}</p>
            <p><strong>Date:</strong> {{ department.date }}</p>


            <el-row>
                <el-col :span="24">
                     <table>
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in department.items" :key="item.id">
                                <td>{{ item.sku }}</td>
                                <td>{{ item.quantity }}</td>
                                <td>{{ formatCurrency(item.rate) }}</td>
                                <td style="text-align: right;">{{ formatCurrency(item.total) }}</td>
                            </tr>
                            <tr>
                                <td style="border: none;" colspan="2"></td>
                                <td style="border: none;">Invoice Total</td>
                                <td colspan="2" style="text-align: right;">{{ formatCurrency(department.invoice_total) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </el-col>
            </el-row>


            <el-row>
                <el-col>
                    <router-link :to="'/'+ $route.params.slug + '/departments'">
                        <el-button type="info" class="me-2">Back</el-button>
                    </router-link>
                    <el-button type="primary" @click="downloadPdf" class="me-2">Download PDF</el-button>
                    <el-button type="primary" @click="exportDepartmentXLS" class="me-2">Export Excel</el-button>
                    <el-button type="primary" @click="exportDepartmentCSV" class="me-2">Export CSV</el-button>
                </el-col>
            </el-row>
        </el-card>
    </el-form>
</template>

<script>
export default {
    name: 'DepartmentShow',
    data() {
        return {
            department : {
                id: null,
                description: '',
                invoice_total: 0,
                date: '',
                items: [{
                    'sku': null,
                    'quantity': 0,
                    'rate': 0,
                    'total': 0,
                }]
            },
        };
    },

    async created() {3
        this.department.id = this.$route.params.id;
        console.log('Route Name: ', this.$route.name);
        await axios.get(`/api/departments/edit/`+this.department.id).
                then((res) => {
                    console.log('res:', res);
                    this.department.id = res.data.id;
                    this.department.description = res.data.description;
                    this.department.invoice_total = res.data.invoice_total;
                    this.department.date = res.data.date;
                    this.department.items = res.data.department_items;
                });
    },
    methods: {
        downloadPdf(){
            window.location.href = `/departments/download-pdf/`+this.department.id;
        },
        exportDepartmentXLS(){
            let format = 'xls';
            window.location.href = `/api/department/blade/`+this.department.id+`/export/`+format;
        },
        exportDepartmentCSV(){
            let format = 'csv';
            window.location.href = `/api/department/blade/`+this.department.id+`/export/`+format;
        },
        formatCurrency(value) {
            return parseFloat(value).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        },
    },
};
</script>


<style scoped>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 8px;
    }
</style>>
