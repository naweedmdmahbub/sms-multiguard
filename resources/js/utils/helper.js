import { ElNotification, ElMessage } from 'element-plus'
export function showErrors(error){
    const errors = error.response.data.errors;
    var offset = 0;
    console.log('errors:', errors);
    Object.entries(errors).forEach(([key, value]) => {
        console.log(key, value)
        ElNotification({
            type: 'error',
            title: 'Error',
            message: value[0],
            offset: offset,
        });
        offset += 60;
    });
}
export function showMessage(message, type, duration){
    ElMessage({
      message: message,
      type: type,
      duration: duration,
    });
}
