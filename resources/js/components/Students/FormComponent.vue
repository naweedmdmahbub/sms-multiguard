<template>
  <div class="form-container">
    <el-form
      ref="studentForm"
      :model="student"
      label-position="left"
      label-width="150px"
      style="max-width: 500px;"
    >
      <el-form-item label="Name" prop="name">
        <el-input
          v-model="student.name"
          :disabled="mode == 'show'"
        />
      </el-form-item>
      <el-form-item label="Department" prop="department_id">
        <el-select v-model="selectedDepartmentID" placeholder="Please Select Department" :disabled="mode === 'view'" style="width:100%;">
            <el-option v-for="department in departments"
                      :key="department.id"
                      :label="department.name"
                      :value="department.id" />
        </el-select>
      </el-form-item>
      <el-form-item label="Number" prop="number">
        <el-input
          v-model="student.number"
          :disabled="mode == 'show'"
        />
      </el-form-item>
      <el-form-item label="Guardian Number" prop="guardian_number">
        <el-input
          v-model="student.guardian_number"
          :disabled="mode == 'show'"
        />
      </el-form-item>
      <el-form-item label="Email" prop="email">
        <el-input
          v-model="student.email"
          :disabled="mode == 'show'"
        />
      </el-form-item>


      <el-form-item label="Image" prop="image">
        <img v-if="student.image !==null && student.image.id"
            :src="'/uploads/students/' + student.image.filename"
            width="100"
            height="100"
        >
        <input type="file" @change="onFileChange">
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
import { showErrors, showMessage } from '@/utils/helper.js'
export default {
  props: ['mode', 'student'],
  data() {
    return {
      selectedDepartmentID: null,
      errors: [],
      departments: [],
      imageUrl: '',
    };
  },
  async mounted(){
    await axios.get('/api/departments').then((res) => {
      this.departments = res.data.data;
    });
    if (this.mode !== 'create'){
      this.selectedDepartmentID = this.student.department_id;
    }
  },
  methods: {
    dismissDialog() {
      this.$emit('dismissDialog');
    },
    async handleSubmit() {
      this.student.department_id = this.selectedDepartmentID;
      let data = new FormData();
      let postUrl = 'api/students';
      let message = 'New student ' + this.student.name + ' has been created successfully.';

      for (var key in this.student) {
        if (this.student[key]) { // Check if the value is truthy
          data.append(key, this.student[key]);
        } else if (this.student[key] === null) { // Check if the value is explicitly null
          data.append(key, ''); // Set an empty string if the value is null
        }
        // console.log('key:', key, 'this.student[key]:', this.student[key]);
      }
      await data.append('image', this.student.image);
      for (const pair of data.entries()) {
        console.log(pair[0], pair[1]);
      }
      console.log('data:', data);
      console.log('this.student:', this.student);

      if (this.student.id) {
        postUrl = 'api/students/'+this.student.id;
        message = 'Student info has been updated successfully';
      }      
      console.log('postUrl:', postUrl);
      axios
        .post(postUrl, data)
        .then(response => {
          showMessage(message, 'success', 5*1000);
          this.dismissDialog();
        })
        .catch(error => {
          showErrors(error);
        });
    },
    onFileChange(event){
        this.student.image = event.target.files[0];
        this.imageUrl = URL.createObjectURL(this.student.image);
        // console.log('onFileChange: ', event.target.files);
        // console.log('this.student.image: ', this.student.image);
        // console.log('imageUrl: ', this.imageUrl);
    },
  }
};
</script>
