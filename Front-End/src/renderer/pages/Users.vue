<template>

    <div id="app">

        <div class="wrapper">

            <div class="sidebar" data-color="purple" data-background-color="white">

                <div class="logo">
                    <a href="" class="simple-text logo-normal">
                        Aqua Mobile
                    </a>
                </div>

                <div class="sidebar-wrapper">
                    <ul class="nav">

                        <li class="nav-item">
                            <router-link to="/dashboard" class="nav-link admin-nav-link active">
                                <i class="material-icons"></i>
                                <p>Dashboard</p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/lend" class="nav-link admin-nav-link active">
                                <i class="material-icons"></i>
                                <p>Lend</p>
                            </router-link>
                        </li>

                        <li class="nav-item" v-if="isAdmin">
                            <router-link to="/products" class="nav-link admin-nav-link active">
                                <i class="material-icons"></i>
                                <p>Products</p>
                            </router-link>
                        </li>

                        <li class="nav-item" v-if="isAdmin">
                            <router-link to="/stock" class="nav-link admin-nav-link active">
                                <i class="material-icons"></i>
                                <p>Stock</p>
                            </router-link>
                        </li>

                        <li class="nav-item" v-if="isAdmin">
                            <router-link to="/categories" class="nav-link admin-nav-link active">
                                <i class="material-icons"></i>
                                <p>Categories</p>
                            </router-link>
                        </li>

                        <li class="nav-item" v-if="isAdmin">
                            <router-link to="/sales" class="nav-link admin-nav-link active">
                                <i class="material-icons"></i>
                                <p>Sales</p>
                            </router-link>
                        </li>

                        <li class="nav-item active" v-if="isAdmin">
                            <router-link to="/details" class="nav-link admin-nav-link active">
                                <i class="material-icons"></i>
                                <p>Details</p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link admin-nav-link" @click="userLogout">
                                <i class="material-icons"></i>
                                <p>Logout</p>
                            </a>
                        </li>


                        <!-- your sidebar here -->
                    </ul>
                </div>

            </div>

            <div class="main-panel">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                    <div class="container-fluid">

                        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="navbar-toggler-icon icon-bar"></span>
                            <span class="navbar-toggler-icon icon-bar"></span>
                            <span class="navbar-toggler-icon icon-bar"></span>
                        </button>

                    </div>
                </nav>
                <!-- End Navbar -->
                <div class="content" style="margin-top: 0em!important;">
                    <div class="container-fluid">


                        <div class="com-details">
                            <div class="row">

                                <div class="col-6 forms">
                                    <h4 class="text-center"><b>Main Admin</b></h4>
                                    <form @submit.prevent="">
                                        <p>Name: </p>
                                        <input type="text" placeholder="Name" v-model="Admin.Name">

                                        <p>UserName: </p>
                                        <input type="text" placeholder="UserName" v-model="Admin.UserName">

                                        <p>Password: </p>
                                        <input type="password" placeholder="Password" v-model="Admin.Pass1">

                                        <p>Retype-Password: </p>
                                        <input type="password" placeholder="Password" v-model="Admin.Pass2">

                                        <input class="mt-2"  style="float: right" type="submit" value="Submit" @click="submitAdmin">
                                    </form>
                                </div>

                                <div class="col-6 forms">
                                    <h4 class="text-center"><b>Seller</b></h4>
                                    <form @submit.prevent="">
                                        <p>Name: </p>
                                        <input type="text" placeholder="Name" v-model="Seller.Name">

                                        <p>UserName: </p>
                                        <input type="text" placeholder="UserName" v-model="Seller.UserName">

                                        <p>Password: </p>
                                        <input type="password" placeholder="Password" v-model="Seller.Pass1">

                                        <p>Retype-Password: </p>
                                        <input type="password" placeholder="Password" v-model="Seller.Pass2">

                                        <input class="mt-2"  style="float: right" type="submit" value="Submit" @click="submitSeller">
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

</template>

<script>
    import router from '../router'
    import axios from "axios";

    export default {

        data(){
            return{
                isAdmin:false,

                Admin:{
                    Name:"",
                    UserName:"",
                    Password:"",
                    Pass1:null,
                    Pass2:null,
                },

                Seller:{
                    Name:"",
                    UserName:"",
                    Password:"",
                    Pass1:null,
                    Pass2:null,
                }
            }
        },

        async created() {
            await this.getUsers();
        },

        methods:{

            checkLogin(){
                this.$session.start();
                var log_status = this.$session.get('user');

                if(log_status) {
                    if (log_status === 1) {
                        this.isAdmin = true;
                    } else {
                        this.isAdmin = false;
                    }
                }else{
                    alert("You should Login First!!")
                    router.push('/');
                }
            },

            async getUsers(){
                await axios.get("http://localhost:8000/api/getAdmin",{
                    headers:{
                        "token":this.$token
                    }
                })
                    .then(response=>{
                        this.Admin.Name = response.data.name;
                        this.Admin.UserName = response.data.userName;
                    });

                await axios.get("http://localhost:8000/api/getSeller",{
                    headers:{
                        "token":this.$token
                    }
                })
                    .then(response=>{
                        this.Seller.Name = response.data.name;
                        this.Seller.UserName = response.data.userName;
                    });
            },

            async submitAdmin(){

                if(this.Admin.Pass2) {
                    if (this.Admin.Pass1 !== this.Admin.Pass2) {
                        alert("Passwords are not matching!!")
                    } else {
                        this.Admin.Password = this.Admin.Pass2;
                        await axios.post("http://localhost:8000/api/updateAdmin", this.Admin, {
                            headers: {
                                "token": this.$token
                            }
                        }).then(alert("Successfully updated!!"))
                    }
                }
                else{
                    alert("Passwords cannot be empty!!")
                }


            },

            async submitSeller(){

                if(this.Seller.Pass2) {
                    if (this.Seller.Pass1 !== this.Seller.Pass2 && this.Seller.Pass2 === null) {
                        alert("Passwords are not matching!!")
                    } else {
                        this.Seller.Password = this.Seller.Pass2;
                        await axios.post("http://localhost:8000/api/updateSeller", this.Seller, {
                            headers: {
                                "token": this.$token
                            }
                        }).then(alert("Successfully updated!!"))
                    }
                } else{
                    alert("Passwords cannot be empty!!")
                }
            },


            userLogout(){
                this.$session.destroy();
                this.$router.push('/')
            },

        },


        beforeMount() {
            this.checkLogin();


        },

    }
</script>

<style scoped>
    @import "../../../static/styles/material-dashboard.css";

    .com-details{
        border:1px solid #d2d2d2;
        padding:3em;
    }

    .com-details label{
        font-size: 15px;
        color: black;
    }

    .com-details input[type=text],.com-details input[type=email]
    ,.com-details input[type=email],.com-details input[type=password]{
        width: 100%!important;
        border:1px solid #dddddd!important;
        border-radius: 5px!important;
        padding: 0.5em;
        margin-bottom: 1em;
        margin-top: -1em;
    }

    .com-details input[type=submit]{
        background: #0c7cd5;
        color:#ffffff;
        padding: 0.5em 1em;
        border:1px solid #0c7cd5;
    }

    .com-details .forms{
        border:1px solid #dddddd;
        padding: 1em;
    }



</style>
