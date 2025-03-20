new Vue({
    el: '#app',
    data: {
        loginData: {
            email: '',
            password: ''
        },
        registerData: {
            name: '',
            email: '',
            password: '',
            ktp: null,
            captcha: ''
        },
        csrf: '',
        captchaImage: '',
        registerForm: false,
        loggedIn: localStorage.getItem('api_token') ? true : false,
        userData: {}
    },
    mounted() {
        this.getCsrfToken();
        this.getCaptcha();
        if (this.loggedIn) {
            this.getUserData();
        }
    },
    methods: {
        getCsrfToken() {
            // Ambil CSRF token dari server
            fetch('/sanctum/csrf-cookie')
                .then(response => {
                    if (response.ok) {
                        this.csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    }
                });
        },
        getCaptcha() {
            // Ambil gambar captcha dari server
            fetch('/captcha')
                .then(response => response.text())
                .then(data => {
                    this.captchaImage = data;
                });
        },
        handleFileUpload(event) {
            this.registerData.ktp = event.target.files[0];
        },
        login() {
            fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(this.loginData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.user) {
                    localStorage.setItem('api_token', data.user.api_token);
                    this.loggedIn = true;
                    this.userData = data.user;
                } else {
                    alert('Login gagal');
                }
            });
        },
        register() {
            const formData = new FormData();
            formData.append('name', this.registerData.name);
            formData.append('email', this.registerData.email);
            formData.append('password', this.registerData.password);
            formData.append('ktp', this.registerData.ktp);
            formData.append('captcha', this.registerData.captcha);

            fetch('/api/register', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrf
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.user) {
                    alert('Registrasi berhasil');
                    this.registerForm = false;
                } else {
                    alert('Registrasi gagal');
                }
            });
        },
        getUserData() {
            fetch('/api/user', {
                headers: {
                    'Authorization': localStorage.getItem('api_token')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.user) {
                    this.userData = data.user;
                } else {
                    this.logout();
                }
            });
        },
        logout() {
            localStorage.removeItem('api_token');
            this.loggedIn = false;
            this.userData = {};
        }
    }
});