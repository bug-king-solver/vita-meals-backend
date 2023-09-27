import axios from "axios";

const Api = axios.create({
    // Base url of server side rest apis
    baseURL: 'http://localhost:8082/api/',
    headers: {
        'Accept': 'application/json'
    }
});

export default Api;