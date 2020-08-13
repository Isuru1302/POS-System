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

            <div class="container">
              <div class="row">

                <div class="col-4">

                    <div class="uk-card uk-card-default uk-card-body pointer">
                      <h3 class="uk-card-title">This Month Income</h3>
                      <p style="text-align: center">Rs: {{thisMonth.income}} /=</p>
                      <p style="text-align: center"><b>Total items: </b>{{thisMonth.total}}</p>
                    </div>

                </div>

                <div class="col-4">

                    <div class="uk-card uk-card-default uk-card-body pointer">
                      <h3 class="uk-card-title">Last Month Income</h3>
                      <p style="text-align: center">Rs: {{lastMonth.income}} /=</p>
                      <p style="text-align: center"><b>Total items: </b>{{lastMonth.total}}</p>
                    </div>

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
  import axios from 'axios'

  export default {

    data(){
      return{
        isAdmin:false,
        thisMonth:{
          income:0,
          total:0,
        },
        lastMonth:{
          income:0,
          total:0,
        },
      }
    },

    created() {
      this.thisMonthSales();
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

      userLogout(){
        this.$session.destroy();
        this.$router.push('/')
      },

      async thisMonthSales(){
        await axios.get('http://localhost:8000/api/incomeByMonth',{
          headers:{
            "token":this.$token
          }
        })
        .then(response=>{
          this.thisMonth = response.data.income[0];
        })

        await axios.get('http://localhost:8000/api/incomeLastMonth',{
          headers:{
            "token":this.$token
          }
        })
            .then(response=>{
           this.lastMonth = response.data.income[0];
         })
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

</style>
