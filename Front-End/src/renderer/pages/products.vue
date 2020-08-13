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
            <div class="add-new" uk-tooltip="title: Add Product; pos: bottom-left">
              <router-link to="/addProduct">
                <i class="fa fa-plus"></i>
              </router-link>
            </div>
            <hr>

<!--            <div class="search-area">-->
<!--                <input type="text" placeholder="search" id="searchItem"-->
<!--                       @input="searchItem">-->
<!--            </div>-->
            <div class="category-area d-none">
              <select>
                <option>--Select Category--</option>
                <option v-for="category in categories">{{category}}</option>
              </select>
            </div>



            <div class="stock-table uk-overflow-auto">

              <table class="uk-table uk-table-striped"  id="productsTable">

                <thead>
                <tr>
                  <td ></td>
                  <th >Name</th>
                  <th>Code</th>
                  <th>Image</th>
                  <th class=" text-center">Price</th>
                  <th class="">Warranty</th>
                  <th class="">Category</th>
                  <th class="">Edit</th>
                  <th class=" text-center">Delete</th>
                </tr>
                </thead>

                <tbody>
                <tr v-if="enableSearch===false" v-for="product in products" :key="render_table">
                  <td>{{products.findIndex(x => x.id === product.id)+1}}</td>
                  <td @dblclick="editBarcode(product.itemCode)" class="pointer" uk-tooltip="Double click to change barcode">{{product.itemName}}</td>
                  <td>{{product.itemCode}}</td>
                  <td class=""><img :src="product.itemImage" class="img-fluid stock-img"></td>
                  <td class="">{{product.itemPrice}}</td>
                  <td>{{product.itemWarranty}}<span style="font-size: 12px">(Months)</span></td>
                  <td class="" style="font-size: 14px">{{product.itemCategory}}</td>
                  <td class=" pointer">
                    <a href="#editProduct" uk-toggle @click="getProductByID(product.id)">
                      <i class="fa fa-pencil"></i>
                    </a>
                  </td>
                  <td class="text-center"><span class="red-btn pointer" @dblclick="deleteItem(product.id)">x</span></td>
                </tr>

<!--                <tr v-if="enableSearch" v-for="product in searchResults">-->
<!--                  <td @dblclick="editBarcode(product.itemCode)" class="pointer" uk-tooltip="Double click to change barcode">{{product.itemName}}</td>-->
<!--                  <td>{{product.itemCode}}</td>-->
<!--                  <td class="text-center"><img :src="product.itemImage" class="img-fluid stock-img"></td>-->
<!--                  <td class="text-center">{{product.itemPrice}}</td>-->
<!--                  <td>{{product.itemWarranty}}<span style="font-size: 12px">(Months)</span></td>-->
<!--                  <td class="text-center" style="font-size: 14px">{{product.itemCategory}}</td>-->
<!--                  <td class="text-center pointer">-->
<!--                    <a href="#editProduct" uk-toggle @click="getProductByID(product.id)">-->
<!--                      <i class="fa fa-pencil"></i>-->
<!--                    </a>-->
<!--                  </td>-->
<!--                  <td class="text-center"><span class="red-btn pointer" @dblclick="deleteItem(product.id)">x</span></td>-->
<!--                </tr>-->

                </tbody>

              </table>

            </div>



            <div id="newProduct" uk-modal>
              <div class="uk-modal-dialog uk-modal-body">
                <h4 class="uk-modal-title"><b>Add New Product</b></h4>
                <hr class="uk-divider-icon">
                <form>

                  <div class="form-group">
                    <label for="itemName">Item Name:</label>
                    <input type="text" id="itemName">
                  </div>

                  <div class="form-group">
                    <label for="itemCode">Item Code:</label>
                    <input type="text" id="itemCode">
                  </div>


                    <label for="itemImage" style="color: black">Item Image:</label>
                    <input type="file" id="itemImage" accept="image/*">


                  <div class="form-group">
                    <label for="itemPrice">Item Price:</label>
                    <input type="text" id="itemPrice">
                  </div>

                  <div class="form-group">
                    <label for="itemWarranty">Warranty<i>(Months)</i>:</label>
                    <input type="number" min="0" id="itemWarranty">
                  </div>

                  <div class="form-group">
                    <label for="itemCate">Category:</label>
                    <select id="itemCate">
                      <option>--Select Category--</option>
                      <option v-for="category in categories">{{category.Name}}</option>
                    </select>
                  </div>


                  <div class="form-group">
                    <label for="EditItemCate">Description:</label>
                    <ckeditor :editor="editor" :config="editorConfig"></ckeditor>
                  </div>

                </form>
                <hr class="uk-divider-icon">
                <p class="uk-text-right">
                  <button class="uk-button uk-button-default uk-button-primary" type="button">Add</button>
                  <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                </p>
              </div>
            </div>


            <div id="editProduct" uk-modal>
              <div class="uk-modal-dialog uk-modal-body">
                <h4 class="uk-modal-title"><b>Edit Product</b></h4>
                <hr class="uk-divider-icon">
                <form>

                  <div class="form-group">
                    <label for="EditItemName">Item Name:</label>
                    <input type="text" id="EditItemName" v-model="singleProduct.itemName">
                  </div>

                  <div class="form-group">
                    <label for="EditItemCode">Item Code:</label>
                    <input type="text" id="EditItemCode" v-model="singleProduct.itemCode">
                  </div>


                  <label for="EditItemImage" style="color: black">Item Image:</label>
                  <input type="file" id="EditItemImage" accept="image/*" @change="getImage($event)">
                  <img :src="singleProduct.itemImage" style="height: 4em;">

                  <div class="form-group">
                    <label for="EditItemPrice">Item Price:</label>
                    <input type="text" id="EditItemPrice" v-model="singleProduct.itemPrice"
                           oninput="this.value = this.value.replace(/[^0-9.]/g, '')
                           .replace(/(\..*)\./g, '$1');">
                  </div>

                  <div class="form-group">
                    <label for="EditItemWarranty">Warranty<i>(Months)</i>:</label>
                    <input type="number" min="0" id="EditItemWarranty" v-model="singleProduct.itemWarranty">
                  </div>

                  <div class="form-group">
                    <label for="EditItemCate">Category:</label>
                    <select id="EditItemCate" v-model="singleProduct.itemCategory">
                      <option value="">--Select Category--</option>
                      <option v-for="category in categories" v-bind:class="{'selected':category===singleProduct.itemCategory}">{{category.Name}}</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="EditItemCate">Description:</label>
                    <ckeditor :editor="editor" :config="editorConfig" v-model="singleProduct.itemDescription"></ckeditor>
                  </div>

                </form>
                <hr class="uk-divider-icon">
                <p class="uk-text-right">
                  <button class="uk-button uk-button-default uk-button-primary" type="button" @click="updateProduct(singleProduct.id)">Add</button>
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
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
  import axios from 'axios'

  export default {

    data(){
      return{
        editor:ClassicEditor,
        editorConfig:{
        },
        categories:[],
        isAdmin:false,
        products:[],
        sugWord:"",
        searchResults:[],
        noResults:false,
        enableSearch:false,
        render_table:1,
        singleProduct:{
          itemName:"",
          itemCode:"",
          itemImage:"",
          itemPrice:null,
          itemWarranty:0,
          itemCategory:"",
          itemDescription:"",
        }
      }
    },

    created() {
      this.getCategories();

    },

    async mounted() {
      await this.getProducts();
      await $("#productsTable").DataTable({
         "order": [[ 1, "desc" ]]
      });
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

      async getProducts(){
        await axios.get("http://localhost:8000/api/getItems",{
          headers:{
            "token":this.$token
          }
        })
        .then(response=>{
          this.products = response.data.items;
        });
      },

      async updateProduct(id){
        UIkit.modal("#editProduct").hide();
        await axios.post("http://localhost:8000/api/updateItem/"+id,this.singleProduct,{
          headers:{
            "token":this.$token
          }
        })
        await this.renderPage();

      },

      getImage(e){
        var fileReader = new FileReader();
        fileReader.readAsDataURL(e.target.files[0]);
        fileReader.onload = (e)=>{
          this.singleProduct.itemImage = e.target.result;
        }
      },

      async getProductByID(id){
        await axios.get("http://localhost:8000/api/getItem/"+id,{
          headers:{
            "token":this.$token
          }
        })
                .then(response=>{
                  this.singleProduct = response.data.item;
                });
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
      },

      async deleteItem(id){
        axios.delete("http://localhost:8000/api/deleteItem/"+id,{
          headers:{
            "token":this.$token
          }
        }).then(this.renderPage)
      },

      renderPage(){
        this.$forceUpdate();
        this.getProducts();
        this.render_table +=1;
      },

      editBarcode(itemCode){
        this.$router.push({path: '/barcode', query: {itemCode: itemCode,backPage:"true"}});
      },

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

  .category-area{
    position: absolute;
    right: 3%;
    top: 10%;
  }

  .category-area select{
    padding: 0.5em;
    border:1px solid #dddddd;
    border-radius: 5px;
  }

  .stock-table tbody .fa-pencil{
    background: #00a5bb;
    padding: 0.2em;
    color:#ffffff;
    border-radius: 5px;
  }

  .add-new{
    position: absolute;
    right: 3%;
    top: 1%;
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

  .form-group select{
    border:1px solid #dddddd;
    border-radius: 5px;
  }

  input[type=file]{
    width: 100%;
    border:1px solid #dddddd;
  }

</style>
