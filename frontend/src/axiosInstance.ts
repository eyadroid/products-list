import axios from 'axios';
import { axiosETAGCache } from 'axios-etag-cache';

axios.defaults.baseURL = `${import.meta.env.VITE_VUE_API_HOST}${import.meta.env.VITE_VUE_API_PATH}`;
axios.defaults.headers.common = {
    Accept: "application/json",
};

const axiosWithETAGCache = axiosETAGCache(axios);

export default axiosWithETAGCache;