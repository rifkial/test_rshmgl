<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="app">
        <div v-if="!loggedIn">
            <div v-if="!registerForm">
                <div class="container">
                    <h2>Login</h2>
                    <form @submit.prevent="login">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" v-model="loginData.email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" v-model="loginData.password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                        <p>Belum punya akun? <a href="#" @click="registerForm = true">Register</a></p>
                    </form>
                </div>
            </div>
            <div v-else>
                <div class="container">
                    <h2>Register</h2>
                    <form @submit.prevent="register" enctype="multipart/form-data">
                        <input type="hidden" name="_token" :value="csrf">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" v-model="registerData.name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" v-model="registerData.email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" v-model="registerData.password" required>
                        </div>
                        <div class="form-group">
                            <label for="ktp">KTP</label>
                            <input type="file" class="form-control-file" ref="ktp" @change="handleFileUpload">
                        </div>
                        <div class="form-group">
                            <label>Captcha</label>
                            <div v-html="captchaImage"></div>
                            <input type="text" class="form-control" v-model="registerData.captcha" required>
                        </div>
                        <button type="submit" class="btn btn-success">Register</button>
                        <p>Sudah punya akun? <a href="#" @click="registerForm = false">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="container">
                <h2>Selamat Datang, {{ userData.name }}</h2>
                <button @click="logout" class="btn btn-danger">Logout</button>
            </div>
        </div>
    </div>
    <script src="js/vue.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>