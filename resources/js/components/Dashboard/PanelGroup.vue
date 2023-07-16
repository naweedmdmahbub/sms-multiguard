<template>
  <el-row :gutter="40" class="panel-group">
    <el-col :xs="12" :sm="12" :lg="12" class="card-panel-col">
      <el-card class="box-card">
          <h1>Students: {{ students }}</h1>
      </el-card>
    </el-col>
    <el-col :xs="12" :sm="12" :lg="12" class="card-panel-col">
      <el-card class="box-card">
          <h1>Departments: {{ departments }}</h1>
      </el-card>
    </el-col>
  </el-row>
</template>

<script>

export default {
  props: ['students', 'departments']
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.panel-group {
  margin-top: 1px;
  .card-panel-col{
    margin-bottom: 32px;
  }
}
</style>
