<template>
  <el-table
    :data="semesterStudents"
    style="width: 100%;padding-top: 15px;"
  >
    <el-table-column label="Semester" min-width="200">
      <template #default="scope">
        {{ scope.row.name }}
      </template>
    </el-table-column>
    <el-table-column label="Students" min-width="200">
      <template #default="scope">
        {{ scope.row.students_count }}
      </template>
    </el-table-column>
  </el-table>
</template>

<script>
export default {
  props: ['semesterStudents'],
};
</script>
