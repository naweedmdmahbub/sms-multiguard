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


      <el-form-item label="Students" prop="students">
        <el-select v-model="selectedStudents" multiple filterable placeholder="Select">
          <el-option
            v-for="item in all_students"
            :key="item.id"
            :label="item.name"
            :value="item.id" />
        </el-select>
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
      all_students: false,
      errors: [],
      selectedStudents: [],
    };
  },
  async mounted(){
      await axios.get('api/semesters/students/'+ this.semester.id)
                  .then(response => {
                    this.all_students = response.data.all_students;
                    this.selectedStudents = response.data.semester_student_ids;
                    // console.log('semester-students', response, this.all_students);
                  })
                  .catch(error => {
                    console.log('error', error);
                    showErrors(error);
                  });
    // console.log('mounted in AssignStudent');
  },
  methods: {
    dismissDialog() {
      this.$emit('dismissDialog');
    },
    async handleSubmit() {
      this.errors = [];
      this.semester.students = this.selectedStudents;
      // console.log('handleSubmit', this.selectedStudents, this.semester);
      axios
        .post('api/semesters/students/'+this.semester.id, this.semester)
        .then(response => {
          console.log('response: ', response.data)
          this.$message({
            message: 'Students assigned to ' + this.semester.name,
            type: 'success',
            duration: 5 * 1000,
          });
          this.dismissDialog();
        })
        .catch(error => {
          showErrors(error);
        });
    },
  }
};
</script>
