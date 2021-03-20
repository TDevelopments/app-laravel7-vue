// import axios from "axios";
// import Vue from 'vue'

// const devInstance = createInstance("http://applaravel.test/api/v1");
// const productionInstance = createInstance("http://applaravel.test"); // will change later

// function createInstance(baseURL){
//     return axios.create({
//         baseURL,
//         headers: {
//             'Content-Type': 'application/json',
//             'Authorization': `Bearer ${localStorage.getItem('access_token')}`
//         }
//     });
// }

// export default {
//     install () {
//         Vue.prototype.$http = devInstance
//     }
// }; // Check debug/build mode