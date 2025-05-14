import { createApp } from 'vue'
import App from './App.vue'

function pingDatabase() {
    fetch('/ping')
        .then(response => response.json())
        .then(data => {
            console.log('Ping response:', data);
        })
        .catch(error => {
            console.error('Ping error:', error);
        });
}

pingDatabase();

createApp(App).mount('#app') 
