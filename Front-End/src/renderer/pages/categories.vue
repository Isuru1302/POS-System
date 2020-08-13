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
              <router-link to="/lend" class="nav-link admin-nav-link ">
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

            <li class="nav-item active" v-if="isAdmin">
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

            <div class="add-new" uk-tooltip="title: Add Category; pos: bottom-left">
              <a href="#addCat" uk-toggle>
                <i class="fa fa-plus"></i>
              </a>
            </div>

            <div class="category-table uk-overflow-auto">

              <table class="uk-table uk-table-striped" :key="render_table">

                <thead>
                  <tr>
                    <th class="col-8">Name</th>
                    <th class="col-2 text-center">Edit</th>
                    <th class="col-2 text-center">Action</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-for="category in categories">
                    <td>{{category.Name}}</td>
                    <th class="text-center"><a @click="getCategoryByID(category.id)" href="#editCat" uk-toggle><i class="fa fa-pencil"></i></a></th>
                    <th class=" text-center">
                      <span v-if="category.status===1" @dblclick="categoryAction(category.id)" class="red-btn pointer">x</span>
                      <span v-if="category.status===0" @dblclick="categoryAction(category.id)" class="green-btn pointer">+</span>
                    </th>
                  </tr>
                </tbody>

              </table>

            </div>


            <div id="addCat" uk-modal>
              <div class="uk-modal-dialog uk-modal-body">
                <h4 class="uk-modal-title"><b>Add New Category</b></h4>
                <hr class="uk-divider-icon">

                <form  id="addCategoryForm">
                  <div class="form-group">
                    <label for="catName">Category Name:</label>
                    <input type="text" id="catName" v-model="newCategory.Name" required>
                  </div>
                </form>

                <hr class="uk-divider-icon">
                <p class="uk-text-right">
                  <button class="uk-button uk-button-default uk-button-primary" type="button"
                          @click="addCategory" >Add</button>
                  <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                </p>

              </div>
            </div>

            <div id="editCat" uk-modal>
              <div class="uk-modal-dialog uk-modal-body">
                <h4 class="uk-modal-title"><b>Edit Category</b></h4>
                <hr class="uk-divider-icon">

                <form>
                  <div class="form-group">
                    <label for="editCatName">Category Name:</label>
                    <input type="text" id="editCatName" v-model="getCategory.Name" >
                  </div>
                </form>

                <hr class="uk-divider-icon">
                <p class="uk-text-right">
                  <button class="uk-button uk-button-default uk-button-primary" type="button" @click="updateCategory">Update</button>
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
  import axios from 'axios'

  export default {

    data(){
      return{
        render_table:1,
        isAdmin:false,
        categories:[],
        newCategory:{
          Name:"",
        },
        getCategory:{
          id:0,
          Name:"",
        },
      }
    },

    created() {
      this.getCategories();
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

      async addCategory(){
        if(this.newCategory.Name.length>1){
          await axios.post("http://localhost:8000/api/addCategory",this.newCategory,{
            headers:{
              "token":this.$token
            }
          })
                  .then(this.renderPage);
          UIkit.modal("#addCat").hide();
        }else{
          alert("Category Name cannot be empty!!")
        }
      },

      async getCategoryByID(id){
        await axios.get("http://localhost:8000/api/categories/"+id,{
          headers:{
            "token":this.$token
          }
        })
        .then(response=>{
          this.getCategory.id = response.data.category.id;
          this.getCategory.Name = response.data.category.Name;
        });
      },

      async updateCategory(){
        if(this.getCategory.Name.length>1){
          await axios.post("http://localhost:8000/api/updateCategory/"+this.getCategory.id,this.getCategory,{
            headers:{
              "token":this.$token
            }
          })
                  .then(this.renderPage);
          UIkit.modal("#editCat").hide();
        }else{
          alert("Category Name cannot be empty!!")
        }
      },

      categoryAction(id){
        axios.get("http://localhost:8000/api/deleteCategory/"+id,{
          headers:{
            "token":this.$token
          }
        })
        .then(this.renderPage)
      },

      renderPage(){
        this.$forceUpdate();
        this.getCategories();
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

  .category-table tbody .fa-pencil{
    background: #00a5bb;
    padding: 0.2em;
    color:#ffffff;
    border-radius: 5px;
  }

  .add-new .fa-plus{
    cursor: pointer;
    background: #00a5bb;
    padding: 0.5em;
    color:#ffffff;
    border-radius: 5px;
  }

  .form-group label{
    color:#000000;
  }

  .form-group input[type=text],.form-group input[type=number]{
    width: 100%!important;
    border:1px solid #dddddd!important;
    border-radius: 5px!important;
  }

  .close-btn{
    cursor: pointer;
  }

  .uk-table td,.uk-table th{
    padding: 6px 12px!important;
  }
</style>
