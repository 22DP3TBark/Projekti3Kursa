<script setup>

</script>

<template>
    <main >
        
        <form action="" class="form">
            <div class="container-register">
                <h1 class="title">Register a new account</h1>
                <hr>

                <label for="Name"><b>Name</b></label>
                <input type="text" placeholder="Enter Name" id="Name" required>

                <label for="LastName"><b>LastName</b></label>
                <input type="text" placeholder="Enter LastName " id="LastName" required>

                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" id="email" required>


                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter  Password" name="psw"  id="psw" required>

                <label for="email"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat password"  name="psw-repeat" id="psw-repeat" required>

                <button type="submit" class="registerbtn">Register</button>
                <hr>
            </div>
        </form>
    </main>
</template>

<style scoped>

main{
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f9f9f9;
}

.form {
    width: 50%;
    padding: 20px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.container-register {
    padding: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.container-register h1 {
    margin-bottom: 20px;
    font-size: 2rem;
    color: #333;
    font-weight: 500;
    font-family: 'Poppins', sans-serif;
}

.container-register hr {
    width: 100%;
    border: 1px solid #ddd;
    margin-bottom: 20px;
}


</style>