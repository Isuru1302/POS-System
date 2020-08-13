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

            <li class="nav-item active">
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

            <div class="uk-overflow-auto col-12">
              <table class="uk-table uk-table-striped" id="lendTable">

                <thead>
                <tr>
                  <td>ID</td>
                  <td>Customer Name</td>
                  <td>Nic</td>
                  <td>Total Payment</td>
                  <td>Paid</td>
                  <td>Amount</td>
                  <td>Invoice</td>
                  <td class="text-center pointer">Action</td>
                </tr>
                </thead>

                <tbody>
                <tr v-for="lend in lends" :key="render_table">
                  <td>{{lends.findIndex(x => x.id === lend.id)+1}}</td>
                  <td>{{lend.fullName}}</td>
                  <td>{{lend.NIC}}</td>
                  <td>{{lend.total}}</td>
                  <td>{{lend.paid}}</td>
                  <td>{{lend.remaining}}&nbsp;<a href="#addFund" @click="setId(lend.id)" uk-toggle>
                    <span class="pointer"><i class="fa fa-plus"></i></span>
                  </a></td>
                  <td class="pointer">
                    <i class="fa fa-file-pdf-o" aria-hidden="true" @click="openPdf(lend.invoice)"></i>
                  </td>
                  <td class="text-center pointer">
                    <span class="red-btn" @dblclick="deleteLend(lend.id)">x</span>
                  </td>
                </tr>
                </tbody>

              </table>

              <div id="addFund" uk-modal>
                <div class="uk-modal-dialog uk-modal-body">

                    <form>
                      <div class="form-group">
                        <label for="fundAdd">Add</label>
                        <input type="text" placeholder="Rs" id="fundAdd" oninput="this.value = this.value.replace(/[^0-9.]/g, '')
                                     .replace(/(\..*)\./g, '$1');">
                      </div>
                    </form>

                    <p class="uk-text-right">
                      <button class="uk-button uk-button-default uk-modal-close"  type="button" onclick="document.getElementById('fundAdd').value = ''">Cancel</button>
                      <button class="uk-button uk-button-primary" type="button" @click="addMoney">Add</button>
                  </p>
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
        lends:[],
        selectedInvoice:0,
        render_table:0,
      }
    },

    async mounted(){

      await this.getLends();

      await $("#lendTable").DataTable({
           "order": [[ 1, "desc" ]]
      });
    },

    methods:{

      async getLends(){
        await axios.get("http://localhost:8000/api/lends",{
          headers:{
            "token":this.$token
          }
        })
                .then(response=>{
                  this.lends = response.data;
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

      userLogout(){
        this.$session.destroy();
        this.$router.push('/')
      },

      openPdf(url){

        const { BrowserWindow } = require('electron').remote
        const PDFWindow = require('electron-pdf-window')

        const win = new BrowserWindow({ width: 800, height: 600 })

        PDFWindow.addSupport(win)

        win.loadURL(url)
      },

      setId(id){
        this.selectedInvoice = id;
      },

      async addMoney(){

        var fund = $("#fundAdd").val();
        if(fund){

          if (confirm("Add Rs"+fund+"?")){
            await axios.get("http://localhost:8000/api/addMoney/"+this.selectedInvoice+"/"+fund,{
              headers:{
                "token":this.$token
              }
            })
            this.renderPage();
            UIkit.modal("#addFund").hide();
          }else{
            UIkit.modal("#addFund").hide();
          }

          $("#fundAdd").val("");
        }
      },

      async deleteLend(id){
        if (confirm("Are you sure you want to remove this lend?")){
          await axios.delete("http://localhost:8000/api/deleteLend/"+id,{
            headers:{
              "token":this.$token
            }
          })
          this.renderPage();
          UIkit.modal("#addFund").hide();
        }
      },

      renderPage(){
        this.$forceUpdate();
        this.getLends();
        this.render_table +=1;
      },

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

  .form-group input[type=text]{
    width: 100%;
    padding: 0.5em 1em;
  }

</style>
