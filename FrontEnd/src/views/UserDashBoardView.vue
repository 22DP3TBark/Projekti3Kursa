<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";



const user = ref(null);
const token = localStorage.getItem('token');

const getUserInfo = async () => {
    
//27|Y2zeOwKtHvi5QfZVtkbNfKthvfzedaqJ83Beroda5abb5cba
    if (!token) {
    console.error('No token found, user might not be logged in.');
    return;
  }
    try{
        const response = await axios.get("http://127.0.0.1:8000/api/user", {
            headers: {
                Authorization: `Bearer ${token.value}`,
            },

        });
        user.value = response.data.user; // stores the users info 
        localStorage.setItem('user', JSON.stringify(user.value));
    } catch (error){
        console.error('Error fetching user info:', error);
    }
};



onMounted(() => {
    if(token.value) getUserInfo();
});



/*  
<div class="userDash">
        <div class="userinfo-container">
            <p>Welcom</p>
            <span>name: {{ user.name }}</span>
            <span>email: {{ user.email }}</span>
        </div>
    </div>
*/

</script>

<template>
    <div class="User-container">
        <div className="main-content">
            <div className="header">
                <div className="title-container">
                    <div className="title-bar"></div>
                    <h1 className="title">User Info</h1>
                </div>
            
                <div className="header-buttons">
                    <button className="btn btn-secondary">
                    This Year
                    </button>
                    <button className="btn btn-primary">
                    Download Info
                    </button>
                </div>
            </div>
        </div>
            
            <div className="profile-section">
                <img
                    src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                    alt="Natashia"
                    className="profile-image"
                />
                <div  className="profile-details">
                    <h2  className="profile-name-large">{{ user.name }}, {{ user.lastname }} </h2>
                    <div className="details-grid">
                        <div className="detail-item">
                            <label>User Name</label>
                            <div >{{user.username}}</div>
                        </div>
                        <div className="detail-item">
                            <label>Phone Number</label>
                            <div >{{user.phone}}</div>
                        </div>
                        <div className="detail-item">
                            <label>Email Address</label>
                            <div>{{ user.email }}</div>
                        </div>

                    </div>
                </div>
                
            </div>
    </div>
    <section>
    
    </section>
</template>

<style scoped>
@import '../assets/UDB.css';
</style>