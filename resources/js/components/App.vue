<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav" v-if="loggedUser">
                    <router-link to="/" class="h4 text-decoration-none text-reset">Dashboard</router-link>
                    <router-link to="/product/add" class="nav-item nav-link ml-3">Add product</router-link>
                    <router-link to="/dashboard" class="nav-item nav-link ml-3">Products</router-link>
                    <a href="javascript:void(0)" @click="logout()" class="nav-item nav-link ml-3 pull-right">Logout</a>
                </div>
                <div v-else>
                    <router-link to="/login" class="nav-item nav-link ml-3 pull-right">Login</router-link>
                    <router-link to="/register" class="nav-item nav-link ml-3 pull-right">Register</router-link>
                </div>
            </div>
        </nav>
        <router-view @login="login">
        </router-view>
    </div>
</template>

<script>
import Auth from './../Auth.js';
export default {
    name: "App",
    data() {
        return {
            loggedUser: this.auth.user
        };
    },
    mounted() {
    },
    methods: {
        login() {
            this.loggedUser = this.auth.user;
        },
        logout() {
            this.axios.post('/api/logout')
                .then(({data}) => {
                    Auth.logout(); //reset local storage
                    this.$router.push('/login');
                    this.loggedUser = null;
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}
</script>

<style scoped>

</style>
