import './bootstrap';
import Vue from 'vue'
import AppComponent from './components/App.vue'
// import router from './components/router/index.js';
import axios from 'axios';

// axios.defaults.baseURL = 'http://localhost:8000/api/';

axios.defaults.headers['Authorization'] = `Bearer ${sessionStorage.getItem('token')}`;

new Vue({
    render: h=>h(AppComponent)
    // components: {
    //     AppComponent
    // }
}).$mount("#app")

// app.use(router)
// app.mount('#app')