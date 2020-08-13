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

            <li class="nav-item active" v-if="isAdmin">
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

          <hr>

<!--            <div class="search-area">-->
<!--                <input type="text" placeholder="search" id="searchItem"-->
<!--                       @keypress="searchItem" @keydown="searchItem" @keyup="searchItem" @input="searchItem">-->
<!--            </div>-->

            <div class="stock-table uk-overflow-auto">

              <table class="uk-table uk-table-striped" id="stockTable">

                <thead>
                  <tr>
                    <th class="col-5">Name</th>
                    <th class="col-4 text-center">Code</th>
                    <th class="col-1">Image</th>
                    <th class="col-1">Quantity</th>
                    <th class="col-1">Status</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-for="item in items" :key="render_table">
                    <td>{{item.itemName}}</td>
                    <td class="text-center">{{item.itemCode}}</td>
                    <td class="text-center"><img :src="item.itemImage" class="img-fluid stock-img"></td>
                    <td class="text-center item-qty">
                      <input type="number" :value="item.itemQty" readonly="true" ondblclick="this.readOnly='';"
                      @blur="updateQty(item.id)" :id="'itemQTY'+item.id">
                    </td>
                    <td class="pointer">
                      <p class="available" v-if="item.itemStatus===1" @dblclick="updateStatus(item.id)">Available</p>
                      <p class="not-available" v-if="item.itemStatus!==1" @dblclick="updateStatus(item.id)">Out</p>
                    </td>
                  </tr>

<!--                  <tr v-if="enableSearch" v-for="item in searchResults">-->
<!--                    <td>{{item.itemName}}</td>-->
<!--                    <td class="text-center">{{item.itemCode}}</td>-->
<!--                    <td class="text-center"><img :src="item.itemImage" class="img-fluid stock-img"></td>-->
<!--                    <td class="text-center item-qty">-->
<!--                      <input type="number" :value="item.itemQty" readonly="true" ondblclick="this.readOnly='';"-->
<!--                             @blur="updateQty(item.id)" :id="'itemQTY'+item.id">-->
<!--                    </td>-->
<!--                    <td class="pointer">-->
<!--                      <p class="available" v-if="item.itemStatus===1" @dblclick="updateStatus(item.id)">Available</p>-->
<!--                      <p class="not-available" v-if="item.itemStatus!==1" @dblclick="updateStatus(item.id)">Out</p>-->
<!--                    </td>-->
<!--                  </tr>-->
                </tbody>

              </table>

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
        items:[],
        render_table: 1,
        sugWord:"",
        enableSearch:false,
        searchResults:[],
      }
    },

    created() {

    },

    async mounted() {
      await this.getItems();
      await $("#stockTable").DataTable();
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

      renderPage(){
        this.$forceUpdate();

        if(this.enableSearch===true){
          this.searchItem();
        }else{
          this.getItems();
        }
        this.render_table +=1;
      },

      async getItems(){
        await axios.get("http://localhost:8000/api/getItems",{
          headers:{
            "token":this.$token
          }
        })
        .then(response=>{
          this.items = response.data.items;
        });
      },

      updateQty(id){
        var value = $("#itemQTY"+id).val();
        axios.get("http://localhost:8000/api/updateQty/"+id+"/"+value,{
          headers:{
            "token":this.$token
          }
        })
        $("#itemQTY"+id).prop("readonly", true);
      },

      updateStatus(id){
        axios.get("http://localhost:8000/api/updateStatus/"+id,{
          headers:{
            "token":this.$token
          }
        }).then(this.renderPage);

      },

      searchItem(){
        this.sugWord = $("#searchItem").val();

        if(this.sugWord.length>1){
          this.enableSearch = true;
          axios.get("http://localhost:8000/api/searchItem/"+this.sugWord,{
            headers:{
              "token":this.$token
            }
          })
                  .then(response=>{
                    this.searchResults = response.data.results;
                  });
        }else{
          this.enableSearch=false;
        }
      }

    },


    beforeMount() {
      this.checkLogin();
    },

  }
</script>

<style scoped>
  @import "../../../static/styles/material-dashboard.css";

  .stock-img{
    height: 1.5em;
  }

  .stock-table tbody p{
    padding: 2px 5px;
    font-size: 12px;
    text-align: center;
    color: #ffffff;
    border-radius: 5px;
  }

  .available{
    background: green;
  }

  .not-available{
    background: red;
  }

  .item-qty input[type=number]{
    width: 4em;
    text-align: center;
    border:none;
    background: transparent;
  }

  .item-qty input[type=number]:focus{
    border:1px solid #dddddd;
    background: #ffffff;
  }

  .stock-table tbody .fa-pencil{
    background: #00a5bb;
    padding: 0.2em;
    color:#ffffff;
    border-radius: 5px;
  }
</style>
