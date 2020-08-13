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

                        <li class="nav-item active" v-if="isAdmin">
                            <router-link to="/sales" class="nav-link admin-nav-link active">
                                <i class="material-icons"></i>
                                <p>Sales</p>
                            </router-link>
                        </li>

                        <li class="nav-item" v-if="isAdmin">
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

                        <hr>

                        <h3><b>Daily Income</b></h3>

                        <div class="add-new" uk-tooltip="title: Add Dealer; pos: bottom-left">
                            <a href="#addDealer" uk-toggle>
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>

                        <div class="uk-overflow-auto col-12">
                            <table class="uk-table uk-table-striped" id="dealerTable" >

                                <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Phone</td>
                                    <td>Address</td>
                                    <td>Edit</td>
                                    <td class="text-center">Action</td>
                                </tr>
                                </thead>

                                <tbody >
                                <tr v-for="(dealer,render_table) in dealers"  :key="render_table">
                                    <td>{{dealer.name}}</td>
                                    <td>{{dealer.email}}</td>
                                    <td>{{dealer.tp_num}}</td>
                                    <td>{{dealer.address}}</td>
                                    <th class="text-center"><a @click="getDealerByID(dealer.id)" href="#editDealer" uk-toggle><i class="fa fa-pencil"></i></a></th>
                                    <td class="text-center">
                                        <span  @dblclick="deleteDealer(dealer.id)" class="red-btn pointer">x</span>
                                    </td>
                                </tr>
                                </tbody>

                            </table>
                        </div>

                        <div id="addDealer" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body">
                                <h4 class="uk-modal-title"><b>Add New Dealer</b></h4>
                                <hr class="uk-divider-icon">

                                <form  id="addDealerForm">
                                    <div class="form-group">
                                        <label for="dealerName">Full Name:</label>
                                        <input type="text" id="dealerName" v-model="newDealer.Name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="dealerPhone">Phone Number:</label>
                                        <input type="text" id="dealerPhone" maxlength="10" v-model="newDealer.Phone" required
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>

                                    <div class="form-group">
                                        <label for="dealerEmail">Email:</label>
                                        <input type="email" id="dealerEmail" v-model="newDealer.Email" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="dealerAddress">Address:</label>
                                        <input type="text" id="dealerAddress" v-model="newDealer.Address" required>
                                    </div>

                                </form>

                                <hr class="uk-divider-icon">
                                <p class="uk-text-right">
                                    <button class="uk-button uk-button-default uk-button-primary" type="button"
                                            @click="addDealer" >Add</button>
                                    <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                                </p>

                            </div>
                        </div>


                        <div id="editDealer" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body">
                                <h4 class="uk-modal-title"><b>Add New Dealer</b></h4>
                                <hr class="uk-divider-icon">

                                <form  id="editDealerForm">
                                    <div class="form-group">
                                        <label for="editDealerName">Full Name:</label>
                                        <input type="text" id="editDealerName" v-model="dealerDetails.name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="editDealerPhone">Phone Number:</label>
                                        <input type="text" id="editDealerPhone" maxlength="10" v-model="dealerDetails.tp_num" required
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>

                                    <div class="form-group">
                                        <label for="editDealerEmail">Email:</label>
                                        <input type="email" id="editDealerEmail" v-model="dealerDetails.email" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="editDealerAddress">Address:</label>
                                        <input type="text" id="editDealerAddress" v-model="dealerDetails.address" required>
                                    </div>

                                </form>

                                <hr class="uk-divider-icon">
                                <p class="uk-text-right">
                                    <button class="uk-button uk-button-default uk-button-primary" type="button"
                                            @click="updateDealer(dealerDetails.id)" >Add</button>
                                    <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                                </p>

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
                dealers:[],
                newDealer:{
                  Name:"",
                  Phone:null,
                  Email:"",
                  Address:"",
                },
                dealerDetails:{},
                render_table:1,
            }
        },

        async mounted() {
            await this.getDealers();

            await $("#dealerTable").DataTable({
                // "order": [[ 1, "desc" ]]
            });
        },

        methods:{

            async getDealers(){
                await axios.get("http://localhost:8000/api/dealers",{
                    headers:{
                        "token":this.$token
                    }
                })
                    .then(response=>{
                        this.dealers = response.data;
                    });
            },

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

            async addDealer(){
                UIkit.modal("#addDealer").hide(),
                await axios.post("http://localhost:8000/api/addDealer",this.newDealer,{
                    headers:{
                        "token":this.$token
                    }
                })
                    .then(this.renderPage);

            },

            userLogout(){
                this.$session.destroy();
                this.$router.push('/')
            },

            renderPage(){
                this.getDealers();
                this.$forceUpdate();
                this.render_table +=1;
            },

            async deleteDealer(id){
                await axios.delete("http://localhost:8000/api/deleteDealer/"+id,{
                    headers:{
                        "token":this.$token
                    }
                })
                    .then(this.renderPage);
            },

            async getDealerByID(id){
                await axios.get("http://localhost:8000/api/dealers/"+id,{
                    headers:{
                        "token":this.$token
                    }
                })
                    .then(response=>{
                        this.dealerDetails = response.data;
                    });
            },

            async updateDealer(){
                UIkit.modal("#editDealer").hide(),
                await axios.post("http://localhost:8000/api/updateDealer/"+this.dealerDetails.id,this.dealerDetails,{
                    headers:{
                        "token":this.$token
                    }
                }).then(this.renderPage);
            }

        },


        beforeMount() {
            this.checkLogin();
        },

    }
</script>

<style scoped>
    @import "../../../static/styles/material-dashboard.css";

    .uk-card{
        text-align: center;
    }

    .uk-card-title{
        font-weight: bold;
    }

    .add-new{
        text-align: right;
        margin-bottom: 1em;
    }

    .form-group label{
        color:#000000;
    }

    .form-group input[type=text],.form-group input[type=number],.form-group input[type=email]{
        width: 100%!important;
        border:1px solid #dddddd!important;
        border-radius: 5px!important;
    }

    .add-new .fa-plus{
        cursor: pointer;
        background: #00a5bb;
        padding: 0.5em;
        color:#ffffff;
        border-radius: 5px;
    }

</style>
