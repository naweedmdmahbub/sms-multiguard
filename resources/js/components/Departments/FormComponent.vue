<template>
  <div class="form-container">
    <el-form
      ref="departmentForm"
      :model="department"
      label-position="left"
      label-width="150px"
      style="max-width: 500px;"
    >
      <el-form-item label="Name" prop="name">
        <el-input
          v-model="department.name"
          :disabled="mode == 'show'"
        />
      </el-form-item>
      <el-form-item label="Number" prop="number">
        <el-input
          v-model="department.number"
          :disabled="mode == 'show'"
        />
      </el-form-item>
      <el-form-item label="Total Credit" prop="total_credit">
        <el-input-number
          v-model="department.total_credit"
          style="width:100%;"
          :disabled="mode == 'show'"
          controls-position="right"
        />
      </el-form-item>
      <el-form-item label="Department Head" prop="department_head">
        <el-input
          v-model="department.department_head"
          :disabled="mode == 'show'"
        />
      </el-form-item>
      <el-form-item label="Email" prop="email">
        <el-input
          v-model="department.email"
          type="email"
          :disabled="mode == 'show'"
        />
      </el-form-item>
      
    </el-form>
    <!-- <template #footer>
      <span class="dialog-footer">
        <el-button @click="dismissDialog">Cancel</el-button>
        <el-button 
            v-if="mode !== 'show'"
            type="primary" 
            @click="handleSubmit"
        >
          Confirm
        </el-button>
      </span>
    </template> -->
    <div
      slot="footer"
      class="dialog-footer"
    >
      <el-button @click="dismissDialog">
        Cancel
      </el-button>
      <el-button
        v-if="mode !== 'show'"
        type="primary"
        @click="handleSubmit"
      >
        Confirm
      </el-button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { showErrors } from '@/utils/helper.js'
export default {
  props: ['mode', 'department'],
  data() {
    return {
      loading: true,
      downloading: false,
      errors: [],
    };
  },
  methods: {
    dismissDialog() {
      this.$emit('dismissDialog');
    },
    async handleSubmit() {
      this.errors = [];
      if (this.department.id !== undefined) {
        axios
          .put('api/departments/'+this.department.id, this.department)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Department info has been updated successfully',
              duration: 5 * 1000,
            });
            this.dismissDialog();
          })
          .catch(error => {
            console.log('error:', error);
            showErrors(error);
          });
      } else {
        axios
          .post('api/departments', this.department)
          .then(response => {
            this.$message({
              message: 'New department ' + this.department.name + ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.dismissDialog();
          })
          .catch(error => {
            showErrors(error);
          });
      }
    },
  }
};
</script>
