<template>
  <div class="form-container">
    <el-form
      ref="semesterForm"
      :model="semester"
      label-position="left"
      label-width="150px"
      style="max-width: 500px;"
    >
      <el-form-item label="Name" prop="name">
        <el-input
          v-model="semester.name"
          :disabled="mode == 'show'"
        />
      </el-form-item>
      <el-form-item label="Year" prop="year">
        <el-input
          v-model="semester.year"
          :disabled="mode == 'show'"
        />
      </el-form-item>
    </el-form>
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
  props: ['mode', 'semester'],
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
      if (this.semester.id !== undefined) {
        axios
          .put('api/semesters/'+this.semester.id, this.semester)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Semester info has been updated successfully',
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
          .post('api/semesters', this.semester)
          .then(response => {
            this.$message({
              message: 'New semester ' + this.semester.name + ' has been created successfully.',
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
