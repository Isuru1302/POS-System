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
            <router-link to="/users">
              <button style="float: right;margin-right: 0.5em;margin-top: 0.5em" class="mb-2">Users</button>
            </router-link>
            <div class="com-details">

              <form @submit.prevent="submitDetails">

                <label for="itemImage">Item Image:</label><br>
                <input type="file" id="itemImage" accept="image/*" @change="getImage($event)">
                <img :src="details.logo" style="max-width: 8em;text-align: center" class="img-fluid">

                <div class="form-group">
                  <label for="conNo">Contact No:</label>
                  <input type="text" id="conNo" v-model="details.conNo" maxlength="10"
                         oninput="this.value = this.value.replace(/[^0-9.]/g, '')
                                     .replace(/(\..*)\./g, '$1');" required>
                </div>

                <div class="form-group">
                  <label for="comEmail">Email:</label>
                  <input type="email" id="comEmail" v-model="details.email" required>
                </div>

                <div class="form-group">
                  <label for="addressLine1">Address(Line 1):</label>
                  <input type="text" id="addressLine1" v-model="details.addLine1" required>
                </div>

                <div class="form-group">
                <label for="addressLine1">Address(Line 2):</label>
                <input type="text" id="addressLine2" v-model="details.addLine2" required>
                </div>
                <input class="mt-3" type="submit" value="Submit">

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
  import axios from "axios";

  export default {

    data(){
      return{
        isAdmin:false,
        details:{
          logo:"",
          conNo:null,
          email:"",
          addLine1:"",
          addLine2:"",
        }
      }
    },

    created() {
      this.getDetails();
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

      async submitDetails(){
        await axios.post("http://localhost:8000/api/updateDetails",this.details,{
          headers:{
            "token":this.$token
          }
        }).then(alert("Successfully updated!!") )
      },

      async getDetails(){
        await axios.get("http://localhost:8000/api/details",{
          headers:{
            "token":this.$token
          }
        })
                .then(response=>{
                  this.details = response.data;
                });
      },

      userLogout(){
        this.$session.destroy();
        this.$router.push('/')
      },

      getImage(e){
        var fileReader = new FileReader();
        fileReader.readAsDataURL(e.target.files[0]);
        fileReader.onload = (e)=>{
          this.details.logo = e.target.result;
        }
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
  ,.com-details input[type=email],.com-details input[type=file]{
    width: 100%!important;
    border:1px solid #dddddd!important;
    border-radius: 5px!important;
    padding: 0.5em;
  }

  .com-details input[type=submit]{
    background: #0c7cd5;
    color:#ffffff;
    padding: 0.5em 1em;
    border:1px solid #0c7cd5;

  }

</style>
