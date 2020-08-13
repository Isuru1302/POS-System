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

                        <li class="nav-item active" v-if="isAdmin">
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

                        <div class="add-product">


                            <form @submit.prevent="addProduct" id="inputform">
                            <div class="container">
                                <div class="row">

                                    <div class="col-6">

                                        <div class="form-group ">
                                            <label for="itemName">Item Name:</label>
                                            <input type="text" id="itemName" v-model="newItem.itemName" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="itemCode">Item Code:</label>
                                            <input type="text" id="itemCode" v-model="newItem.itemCode" @input="checkItem" required>
                                            <p class="error-message" id="error1">This item code is already available!!</p>
                                        </div>

                                        <div class="form-group">
                                            <label for="itemPrice">Item Price <i>(Rs)</i>:</label>
                                            <input type="text" id="itemPrice" min="0" v-model="newItem.itemPrice" required
                                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '')
                                                    .replace(/(\..*)\./g, '$1');">
                                        </div>

                                        <div class="form-group">
                                            <label for="itemWarranty">Warranty<i>(Months)</i>:</label>
                                            <input type="number" min="0" id="itemWarranty" v-model="newItem.itemWarranty" required>
                                        </div>

                                    </div>

                                    <div class="col-6">

                                        <label for="itemImage">Item Image:</label><br>
                                        <input type="file" id="itemImage" accept="image/*" @change="getImage($event)">
                                        <img :src="newItem.itemImage" style="max-width: 8em;text-align: center" class="img-fluid">

                                        <div class="form-group">
                                            <label for="itemCate">Category:</label>
                                            <select id="itemCate" v-model="newItem.itemCategory" required>
                                                <option value="">--Select Category--</option>
                                                <option v-for="category in categories" :value="category.Name">{{category.Name}}</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group col-12">
                                        <label >Description:</label>
                                        <ckeditor v-model="newItem.itemDescription" :editor="editor" :config="editorConfig"></ckeditor>
                                    </div>

                                    <input type="submit" value="Add Product">
                                </div>
                            </div>

                            </form>

                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

</template>

<script>
    import router from '../router'
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
    import axios from 'axios'

    export default {

        data(){
            return{
                editor:ClassicEditor,
                editorConfig:{
                },
                isAdmin:false,
                categories:[],
                readQR:"",
                newItem:{
                    itemName:"",
                    itemCode:"",
                    itemImage:"",
                    itemPrice:null,
                    itemWarranty:0,
                    itemCategory:"",
                    itemDescription:"",
                },
            }
        },

        created() {
            this.getCategories();

        },

        destroyed() {
            this.$barcodeScanner.destroy()
        },

        methods:{

            destroyed() {
                this.$barcodeScanner.destroy()
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

            userLogout(){
                this.$session.destroy();
                this.$router.push('/')
            },

            async getCategories(){
                await axios.get("http://localhost:8000/api/categories",{
                    headers:{
                        "token":this.$token
                    }
                })
                    .then(response=>{
                        this.categories = response.data.categories;
                    });
            },

             checkItem(){
                var itemCode = $("#itemCode").val();

                if(itemCode.length>0) {
                    axios.get("http://localhost:8000/api/checkItemCode/" + itemCode,{
                        headers:{
                            "token":this.$token
                        }
                    })
                        .then(response => {

                            if (response.data.itemFound === "no") {
                                $("#error1").css("display", "none");
                            } else {
                                $("#error1").css("display", "block");
                            }

                        });
                }
            },

            getImage(e){
                var fileReader = new FileReader();
                fileReader.readAsDataURL(e.target.files[0]);
                fileReader.onload = (e)=>{
                    this.newItem.itemImage = e.target.result;
                }
            },

             async addProduct(){
                var item_Code = this.newItem.itemCode;
                 await axios.post("http://localhost:8000/api/addItem",this.newItem,{
                     headers:{
                         "token":this.$token
                     }
                 })
                 await this.$router.push({path: '/barcode', query: {itemCode: item_Code,backPage:"false"}});
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

    .add-product label{
        font-size: 15px;
        color: black;
    }

    .add-product input[type=text],.add-product input[type=email]
    ,.add-product input[type=email],.add-product input[type=file]{
        width: 80%!important;
        border:1px solid #dddddd!important;
        border-radius: 5px!important;
        padding: 0.5em;
    }

    .add-product input[type=submit]{
        background: #0c7cd5;
        color:#ffffff;
        padding: 0.5em 1em;
        border:1px solid #0c7cd5;
        margin-left: 2em;
    }

    .add-product select{
        width: 100%!important;
        padding: 0.5em;
    }

    .form-group label{
        color:#000000;
    }

    .form-group input[type=text],.form-group input[type=number]{
        width: 100%!important;
        border:1px solid #dddddd!important;
        border-radius: 5px!important;
        padding: 0.5em;
    }

    .form-group select{
        border:1px solid #dddddd;
        border-radius: 5px;
    }

    input[type=file]{
        background: #ffffff;
        border:1px solid #dddddd;
        padding: 0;
        width: 100%;
    }

    .back-btn{
        position: absolute;
        top:5%;
        right: 5%;

    }

    .back-btn .fa{
        cursor: pointer;
        font-size: 4em;
    }

    .add-product{
        max-height: 88vh;
        overflow-y: scroll;
    }

    .error-message{
        color: red;
        font-size: 13px;
        font-style: italic;
        font-weight: bold;
    }

    #error1,#error2{
        display: none;
    }

</style>
