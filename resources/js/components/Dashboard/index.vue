<template>
    <div>
        <panel-group :departments="departments" :students="students" />

        <el-row :gutter="8">
            <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 24}" :xl="{span: 24}" style="padding-right:8px;margin-bottom:30px;">
                <department-student-table :departmentStudents="department_students" />
            </el-col>
        </el-row>
        <el-row :gutter="8">
            <el-col :xs="{span: 24}" :sm="{span: 24}" :md="{span: 24}" :lg="{span: 24}" :xl="{span: 24}" style="padding-right:8px;margin-bottom:30px;">
                <semester-student-table :semesterStudents="semester_students" />
            </el-col>
        </el-row>
    </div>
</template>

<script>
import PanelGroup from './PanelGroup.vue';
import DepartmentStudentTable from './DepartmentStudentTable.vue';
import SemesterStudentTable from './SemesterStudentTable.vue';
import axios from 'axios';
export default {
  name: 'DashboardAdmin',
  components: {
    PanelGroup,
    DepartmentStudentTable,
    SemesterStudentTable,
  },
  data(){
    return {
      departments: null,
      students: null,
      department_students: null,
      semester_students: null,
    };
  },
  async mounted(){
    await axios.get('/api/get-dashboard-data').then((res) => {
      console.log('mounted', this.departments, res);
      this.departments = res.data.departments;
      this.students = res.data.students;
      this.department_students = res.data.department_students;
      this.semester_students = res.data.semester_students;
    });
  },
  methods: {
  },
};
</script>

<style scoped>
.warning-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
}

.content-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.content-wrapper img {
    max-width: 100%;
    height: auto; /* Maintain the aspect ratio of the image */
    margin-bottom: 16px; /* Add margin below the image */
}
</style>
