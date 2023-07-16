<template>
  <div class="form-container">
    <el-form
      :model="student"
      label-position="left"
      label-width="150px"
      style="max-width: 500px;"
    >
      <el-form-item label="Name" prop="name">
        <el-input
          v-model="student.name"
        />
      </el-form-item>
      <el-form-item label="Department" prop="department_id">
        <el-select v-model="selectedDepartmentID" placeholder="Please Select Department" style="width:100%;">
            <el-option v-for="department in departments"
                      :key="department.id"
                      :label="department.name"
                      :value="department.id" />
        </el-select>
      </el-form-item>
      <el-form-item label="Number" prop="number">
        <el-input
          v-model="student.number"
        />
      </el-form-item>
      <el-form-item label="Guardian Number" prop="guardian_number">
        <el-input
          v-model="student.guardian_number"
        />
      </el-form-item>
      <el-form-item label="Email" prop="email">
        <el-input
          v-model="student.email"
        />
      </el-form-item>
      
      
      <!-- <el-form-item label="Image" prop="image">
        <img v-if="student.image !==null && student.image.id"
            :src="'/uploads/students/' + student.image.filename"
            width="100"
            height="100"
        >
        <input type="file" @change="onFileChange">
      </el-form-item> -->
      
    </el-form>
    <div
      slot="footer"
      class="dialog-footer"
    >
      <el-button
        type="primary"
        @click="handleSubmit"
      >
        Update
      </el-button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { showErrors } from '@/utils/helper.js'
export default {
    data() {
        return {
            loading: true,
            downloading: false,
            selectedDepartmentID: null,
            errors: [],
            departments: [],
            imageUrl: '',
            student: {
                name: '',
                email: '',
                number: '',
                image: null,
                guardian_number: '',
                department_id: '',
            },
            logged_in_user: null,
        };
    },
    async mounted(){
        await axios.get('/api/departments').then((res) => {
            this.departments = res.data.data;
            console.log('mounted', this.departments);
        });
        await axios.get(`/logged_in_user`).
                then((res) => {
                    console.log('logged_in_user:', this.logged_in_user, res);
                    this.logged_in_user = res.data;
                    this.selectedDepartmentID = this.logged_in_user.department_id;
                    this.student = res.data;
                });
        
    },
    methods: {
        async handleSubmit() {
            this.student.department_id = this.selectedDepartmentID;
            let data = new FormData();
            await data.append('image', this.student.image);
            for (var key in this.student) {
                if (key !== 'image') {
                    data.append(key, this.student[key]);
                    console.log('key:', key, 'this.student[key]:', this.student[key]);
                }
                // data.append(key, this.student[key]);
            }
            console.log('data:', data, this.student);
            axios.put('api/students/'+this.student.id, this.student)
                .then(response => {
                    this.$message({
                        type: 'success',
                        message: 'Student info has been updated successfully',
                        duration: 5 * 1000,
                    });
                })
                .catch(error => {
                    console.log('error:', error);
                    showErrors(error);
                });
        },
        onFileChange(event){
            this.student.image = event.target.files[0];
            this.imageUrl = URL.createObjectURL(this.student.image);
            console.log('onFileChange: ', event.target.files);
            console.log('this.student.image: ', this.student.image);
            console.log('imageUrl: ', this.imageUrl);
            // this.imageUrl = event.target.files[0].name;
        },
    }
};
</script>
