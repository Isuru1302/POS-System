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

            <li class="nav-item active">
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

            <div class="row">
              <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                <div class="products">
                  <h5 class="d-b-title">Products</h5>

                    <input type="text" placeholder="Search" id="searchItem"
                           @input="searchItem">


                  <div class="container-fluid mt-3">
                    <div class="row uk-flex-1">

                      <div v-if="enableSearch===false" class="uk-card uk-card-default  col-3" v-for="suggestion in suggestions.slice(0,4)">
                        <div class="uk-card-media-top">
                          <img :src="suggestion.itemImage" class="img-fluid">
                          <div class="overlay"></div>
                          <div class="button">
                            <a class="mr-2" @click="addItem(suggestion.id)">
                              <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            </a>
                            <a @click="getItemDetails(suggestion.id)" href="#modal-item" uk-toggle>
                              <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>

                          </div>
                        </div>
                        <div class="uk-card-body">
                          <p>{{suggestion.itemName}}</p>
                          <p class="avb-text">Available</p>
                        </div>
                      </div>
                      <p style="text-align: center" v-if="enableSearch && searchResults.length===0">No results found</p>

                      <div v-if="enableSearch" class="uk-card uk-card-default  col-3" v-for="result in searchResults.slice(0,4)">

                        <div class="uk-card-media-top">
                          <img :src="result.itemImage" class="img-fluid">
                          <div class="overlay"></div>
                          <div class="button">
                            <a class="mr-2" v-if="result.itemStatus===1" @click="addItem(result.id)">
                              <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            </a>
                            <a @click="getItemDetails(result.id)" href="#modal-item" uk-toggle>
                              <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </a>

                          </div>
                        </div>
                        <div class="uk-card-body">
                          <p>{{result.itemName}}</p>
                          <p class="avb-text" v-if="result.itemStatus===1">Available</p>
                          <p class="not-avb-text" v-if="result.itemStatus===0">Out</p>
                        </div>
                      </div>

                      <div class="cart col-12">
                        <h5 class="d-b-title">Cart</h5>

                        <div class="uk-overflow-auto">
                          <table class="uk-table uk-table-striped">

                            <thead>
                            <tr>
                              <th>Name</th>
                              <th>Qty</th>
                              <th>Unit<i>(Rs)</i></th>
                              <th>Total<i>(Rs)</i></th>
                              <th class="text-center">action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="item in reversedArr" v-if="item.id">
                              <td>{{item.itemName}}</td>

                                <!--                              <input type="text" id="itemCount" v-model="item.itemQty" min="1" style="width: 2em;"-->
                                <!--                                     @input="" style="border:none;" readonly-->
                                <!--                                     oninput="this.value = this.value.replace(/[^0-9.]/g, '')-->
                                <!--                                     .replace(/(\..*)\./g, '$1').replace(/^0/, '');"-->
                                <!--                             >-->
                              <td>{{item.itemQty}}
                                <span v-if="item.totalQty>item.itemQty" class="green-btn pointer" @click="upItems(item.id)" >+</span>
                                <span class="red-btn pointer" @click="downItems(item.id)">-</span>
                              </td>
                              <td>{{item.unitPrice}}</td>
                              <td>{{item.totalPrice}}</td>
                              <td class="text-center" ><span class="red-btn pointer" @click="removeItem(item.id)">x</span></td>
                            </tr>
                            </tbody>

                          </table>
                        </div>
                      </div>

                    </div>
                  </div>

                </div>
              </div>

              <div class="col-12 col-sm-12 col-md-12 col-lg-6 mt-lg-0 mt-md-2 mt-sm-2 ">
                <div class="row">

                  <div class="bill col-12 " style="overflow-x: hidden!important;">

                    <div class="uk-overflow-auto" style="overflow-x: hidden!important;">
                      <table class="uk-table">

                        <tbody>
                        <tr>
                          <td>Total Quantity:</td>
                          <td class="float-right">{{product.totalQty}}</td>
                        </tr>

                        <tr>
                          <td>Total<i>(Rs)</i>:</td>
                          <td class="float-right">{{product.payValue}}</td>
                        </tr>
                        </tbody>

                      </table>

                      <div class="bill-details" style="overflow-x: hidden!important;">
                        <form @submit.prevent="">

                          <div class="row">
                            <div class="col-6">
                              <p>Customer Name:</p>
                              <input type="text" placeholder="Customer name" v-model="product.customerName">
                            </div>

                            <div class="col-6">
                              <p>Contact No:</p>
                              <input type="text" placeholder="Contact Number" maxlength="10"
                                     v-model="product.contactNumber"
                                     oninput="this.value = this.value.replace(/[^0-9.]/g, '')
                                     .replace(/(\..*)\./g, '$1');">
                            </div>

                            <div class="col-6">
                              <p class="mt-2">Total Amount<i>(Rs)</i>:</p>
                              <input type="text" v-model="product.totalAmount" readonly>
                            </div>

                            <div class="col-6">
                              <p class="mt-2" >Discount(%):</p>
                              <input type="number" v-model="product.discount" @input="calcDiscount" min="0">
                            </div>

                            <div class="col-6">
                              <p class="mt-2">Total Price<i>(Rs)</i>:</p>
                              <input type="text" v-model="product.payValue" readonly>
                            </div>

                            <div class="col-6">
                              <p class="mt-2">Pay<i>(Rs)</i>: </p>
                              <input type="text" v-model="product.cPayment" @input="calcPayment"
                                     oninput="this.value = this.value.replace(/[^0-9.]/g, '')
                                     .replace(/(\..*)\./g, '$1');">
                            </div>

                            <div class="col-12">
                              <p class="mt-2 mb-3">Balance<i>(Rs)</i>: </p>
                              <input type="text" v-model="product.balance" readonly>
                            </div>
                          </div>

                          <input v-if="product.totalQty>0" class="mt-3" type="submit" value="Submit" @click="addInvoice">
                          <input v-if="product.totalQty>0" class="mt-3" type="submit" value="Lend" @click="lendForm"
                                 style="float: left;background: red;border:1px solid red">
                        </form>
                      </div>

                    </div>
                  </div>



                </div>
              </div>

              <!-- This is the modal -->
              <div id="modal-item" uk-modal>
                <div class="uk-modal-dialog uk-modal-body" >
                  <h2 class="uk-modal-title">{{itemDetails.Name}}</h2>
                  <p>
                    <span class="modal-price">Rs: {{itemDetails.Price}}</span>
                    <span class="modal-warranty" style="margin-left: 1em">Warranty: {{itemDetails.Warranty}} months</span>
                  </p>
                  <img :src="itemDetails.Image" class="img-fluid model-item-img">
                  <hr class="uk-divider-icon">
                  <p v-html="itemDetails.Description"></p>
                  <hr class="uk-divider-icon">
                  <p class="uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
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
        loading: false,
        product:{
          totalAmount:0,
          totalQty:0,
          discount:0,
          payValue:0,
          cPayment:null,
          balance:0,
          customerName:'',
          contactNumber:'',
        },


        items:[
          {
            id:null,
            itemName:'',
            itemQty:1,
            unitPrice:0,
            totalPrice:0,
            totalQty:0,
            warranty:0,
          }
        ],



        suggestions:[],
        itemDetails:{
          Name:"",
          Warranty:0,
          Price:0,
          Description:"",
          Image:"",
        },
        sugWord:"",
        isAdmin:false,
        searchResults:[],
        noResults:false,
        enableSearch:false,
        barcodeScan:true,
      }
    },

    created() {

      this.getSuggestions();


    },

    mounted() {

        this.startBarcode();

    },

    destroyed() {
      this.$barcodeScanner.destroy()
    },

    methods:{

      enableBarcode(){
        this.barcodeScan = true;
      },

      disableBarcode(){
        this.barcodeScan = false;
      },

      startBarcode(){
        const eventBus = this.$barcodeScanner.init(this.onBarcodeScanned, { eventBus: true })
        if (eventBus) {
          eventBus.$on('start', () => { this.loading = true })
          eventBus.$on('finish', () => { this.loading = false })
        }

      },

      async onBarcodeScanned (barcode) {
        var itemID;

        await axios.get("http://localhost:8000/api/searchByBarcode/"+barcode.replace("Enter",''),{
          headers:{
            "token":this.$token
          }
        })
                .then(function (response) {
                  if(response.data.barcodeRes==="Not found"){
                    itemID = null;
                  }else{
                    itemID = response.data.barcodeRes.id;
                  }
                });

        if(itemID){
          console.log(itemID)
          await this.addItem(itemID)
        }

        this.resetBarcode();
      },

      // Reset to the last barcode before hitting enter (whatever anything in the input box)
      resetBarcode () {
        let barcode = this.$barcodeScanner.getPreviousCode()
        // do something...
      },

      addPayment(){
        console.log("a");
      },

       async getItemDetails(ID){
         await axios.get("http://localhost:8000/api/getItem/"+ID,{
           headers:{
             "token":this.$token
           }
         })
                 .then(response=>{
                   this.itemDetails.Name = response.data.item.itemName;
                   this.itemDetails.Description = response.data.item.itemDescription;
                   this.itemDetails.Price = response.data.item.itemPrice;
                   this.itemDetails.Warranty = response.data.item.itemWarranty;
                   this.itemDetails.Image = response.data.item.itemImage;
                 });
      },

       async addItem(itemId) {

         var details={
           Name:"",
           unitPrice: 0,
           warranty:0,
         };
         await axios.get("http://localhost:8000/api/getItem/"+itemId,{
           headers:{
             "token":this.$token
           }
         })
                 .then(function (response) {
                   details.Name = response.data.item.itemName;
                   details.unitPrice = response.data.item.itemPrice;
                   details.totalQTY = response.data.item.itemQty;
                   details.warranty = response.data.item.itemWarranty;
                 });

        if(this.checkItems(itemId)){
            var objIndex = this.items.findIndex((obj => obj.id === itemId));
            this.items[objIndex].itemQty += 1;
            this.items[objIndex].totalPrice = this.items[objIndex].itemQty*details.unitPrice;
        }else{
          this.items.push({
            id: itemId,
            itemName: details.Name,
            itemQty: 1,
            unitPrice: details.unitPrice,
            totalPrice: details.unitPrice,
            totalQty:details.totalQTY,
            warranty: details.warranty,
          })
        }

        this.billingDetails();
      },

      async upItems(itemID){
        var details={
          Name:"",
          unitPrice: 0,
          totalQty:0,
        };
        await axios.get("http://localhost:8000/api/getItem/"+itemID,{
          headers:{
            "token":this.$token
          }
        })
                .then(function (response) {
                  details.Name = response.data.item.itemName;
                  details.unitPrice = response.data.item.itemPrice;
                });
        var objIndex = this.items.findIndex((obj => obj.id === itemID));
        this.items[objIndex].itemQty += 1;
        this.items[objIndex].totalPrice = this.items[objIndex].itemQty*details.unitPrice;
        this.billingDetails();
      },

      async downItems(itemID) {

        var details = {
          Name: "",
          unitPrice: 0,
        };
        await axios.get("http://localhost:8000/api/getItem/" + itemID,{
          headers:{
            "token":this.$token
          }
        })
                .then(function (response) {
                  details.Name = response.data.item.itemName;
                  details.unitPrice = response.data.item.itemPrice;
                });
        var objIndex = this.items.findIndex((obj => obj.id === itemID));

        if (this.items[objIndex].itemQty > 1) {
          this.items[objIndex].itemQty -= 1;
          this.items[objIndex].totalPrice = this.items[objIndex].itemQty * details.unitPrice;
          this.billingDetails();
        } else {
          this.removeItem(itemID);
        }
      },

      lendForm(){
        router.push({path:'/lendForm', name: 'lend_form',
          params: { salesData: JSON.stringify(this.product),salesInvoice: JSON.stringify(this.items)} })
      },

      checkItems(itemID) {
         var item = this.items.find(x=> x.id === itemID)
         return !!item;
      },

      removeItem(itemId){
        var objIndex = this.items.findIndex((obj => obj.id === itemId));
        this.items.splice(objIndex, 1);
        this.billingDetails();
      },

      billingDetails(){
          this.product.totalAmount = this.totalCalculations(this.items, 'totalPrice');
          this.product.totalQty = this.totalCalculations(this.items, 'itemQty') - 1;

        if(this.product.totalQty<0){
          this.product.cPayment = null;
          this.product.discount = 0;
        }

          this.calcDiscount();
      },

      calcDiscount(){
        if(this.product.totalAmount && this.product.totalQty>0){
          this.product.payValue = Math.ceil(this.product.totalAmount*(100-this.product.discount)/100);
          this.calcPayment();
        }else{
          this.product.payValue = 0;
          this.product.balance = 0;
          this.product.cPayment = null;
          this.product.discount = 0;
        }

      },

      calcPayment(){

        if(this.product.totalQty<0){
          this.product.cPayment = null;
        }

        if(this.product.totalAmount && this.product.totalQty>0 && this.product.cPayment){
          this.product.balance  = this.product.cPayment-this.product.payValue;
        }else{
          this.product.balance = 0;
          this.product.cPayment = null;
        }
      },

      getSuggestions(){
        axios.get("http://localhost:8000/api/getAvailableItems",{
          headers:{
            "token":this.$token
          }
        })
        .then(response=>{
          this.suggestions = response.data.items;
        });
      },

      totalCalculations : function(items, prop){
        return items.reduce( function(a, b){
          return a + b[prop];
        }, 0);
      },


      addInvoice(){
        router.push({path:'/invoice', name: 'invoice',
          params: { salesData: JSON.stringify(this.product),salesInvoice: JSON.stringify(this.items)} })
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

    },


    computed:{
      reversedArr() {
        return this.items.slice().reverse()
      }
    },


    beforeMount() {
      this.checkLogin();

      if(this.$route.params.salesInvoice && this.$route.params.salesData) {

        var str =this.$route.params.salesInvoice;
        var str2 = this.$route.params.salesData;
        var obj = [{}];
        var obj2 = {};
        try{
          obj = JSON.parse(str);
          obj2 = JSON.parse(str2);
        }catch (e) {
          console.error(e);
        }

        var times = obj.length;

        for (var i = 0; i < times; i += 1) {
          this.items.push(obj[i]);
        }

        this.product.totalAmount=obj2.totalAmount;
        this.product.totalQty=obj2.totalQty;
        this.product.discount=obj2.discount;
        this.product.payValue=obj2.payValue;
        this.product.cPayment=obj2.cPayment;
        this.product.balance=obj2.balance;
        this.product.customerName=obj2.customerName;
        this.product.contactNumber=obj2.contactNumber;
      }
    },

  }
</script>

<style scoped>
  @import "../../../static/styles/material-dashboard.css";

  .d-b-title{
    background: #eeeeee;
    padding: 0.5em;
    border-radius: 5px;
    border:1px solid #dddddd;
  }

  .products,.cart{
    border: 1px solid #dddddd;
    padding: 1em 0.5em;
  }

  .navbar-nav{
    display: none!important;
  }

  .bill-details{
    width: 100% !important;
  }

  .bill{
    border: 1px solid #dddddd;
    background: #eeeeee;
    padding: 1em 2em;
  }

  .float-right{
    float: right;
  }

  .bill tr{
    background: #ffffff;
    border: 1px solid #dddddd;
  }

  .bill-details input[type=text],.bill-details input[type=number]{
    margin-top: -2em!important;
    width: 100%;
    padding: 0.5em 1em;
    border:1px solid #dddddd;
    border-radius: 4px;
  }

  .products input[type=text]{
    width: 100%;
    border:1px solid #dddddd;
    border-radius: 4px;
    padding: 0.5em;
  }

  .bill-details input[type=submit]{
    background: #00bbff;
    border:1px solid #00bbff;
    font-size: 1.2em;
    font-weight: bold;
    color: #ffffff;
    border-radius: 5px;
    padding: 0.3em 0.5em 0.35em 0.5em;
    float: right;
    width: 6em;
  }

  .uk-card-media-top img{
    height: 5em;
    width: 5em;
  }

  .uk-card-body{
    width: 100%;
    padding: 0;
    margin: 0;
    text-align: center;
  }

  .uk-card-media-top{
    text-align: center;
    vertical-align: center;
  }

  .uk-card{
    width: 5em!important;
    border:1px solid #dddddd;
    padding: 0.5em;
    cursor: pointer;
  }

  .button {
    position: absolute;
    top:2em;
    text-align: center;
    opacity: 0;
    transition: opacity .35s ease;
    left: 30%;
    vertical-align: center;
  }

  .uk-card:hover .button {
    opacity: 1;
  }

  .uk-card .button i{
    font-size: 2em;
    color: #ffffff;
    transition: 0.5s;
  }

  .uk-card .button i:hover{
    transform: scale(1.1);
  }

  .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0);
    transition: background 0.5s ease;
  }

  .uk-card:hover .overlay {
    display: block;
    background: rgba(0, 0, 0, .3);
  }

  .cart table tbody{
    height: 1em;
  }

  .uk-table td,.uk-table th{
    padding: 4px 12px!important;
  }

  .cart{
    height: 17em!important;
    overflow-y: scroll;
  }

  .model-item-img{
    width: 7em;
    height: 6em;
  }

  .avb-text{

    font-size: 10px;
    width: 5em;
    text-align: center;
    margin: -2em auto 0em auto;
    font-weight: bold;
    color: green;
    border-radius:5px;
    padding-top: 0.1em;
  }

  .not-avb-text{

    font-size: 10px;
    width: 5em;
    text-align: center;
    margin: -2em auto 0em auto;
    font-weight: bold;
    color: red;
    border-radius:5px;
    padding-top: 0.1em;
  }

  .modal-price{
    background: #0ffc03;
    border:1px solid #0ffc03;
    border-radius: 5px;
    color: #ffffff;
    padding: 0.2em 0.5em;
    font-size: 14px;
    font-weight: bold;
  }

  .modal-warranty{
    background: orange;
    border:1px solid orange;
    border-radius: 5px;
    color: #ffffff;
    padding: 0.2em 0.5em;
    font-size: 14px;
    font-weight: bold;
  }

</style>
