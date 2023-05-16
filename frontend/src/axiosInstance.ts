import axios from 'axios';

axios.defaults.baseURL = `${import.meta.env.VITE_VUE_API_HOST}${import.meta.env.VITE_VUE_API_PATH}`;
axios.defaults.headers.common = {
    Accept: "application/json",
};
  
export default axios;