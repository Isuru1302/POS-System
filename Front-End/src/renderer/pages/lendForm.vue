<template>
  <div id="app">

    <div class="action-buttons">
      <button class="pr-btn" uk-tooltip="Print Invoice" @click="printDiv" v-print="'#printDetails'">
        <i class="fa fa-print" aria-hidden="true"></i>
      </button><br><br>
      <button @click="goBack" class="bc-btn" uk-tooltip="Go Back">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
      </button><br><br>
      <button class="cl-btn" uk-tooltip="Delete Invoice" @click="deleteInvoice">
        <i class="fa fa-times" aria-hidden="true"></i>
      </button>
    </div>

    <h3 style="text-align: center;margin-top: 1em"><u>Lend Invoice</u></h3>

    <div class="invoice">

      <div class="container">

        <div class="lend-cus-details mb-3">
          <div class="container">
            <div class="row">

              <div class="col-4">
                <input type="text" placeholder="NIC NO" required v-model="customerDetails.NIC">
              </div>

              <div class="col-4">
                <input type="text" placeholder="Address" required v-model="customerDetails.Address">
              </div>

              <div class="col-4">
                <input type="text" placeholder="Water/Current Bill Id" required v-model="customerDetails.BillingProof">
              </div>

            </div>
          </div>

        </div>

        <div class="invoice-area" id="">
          <div id="printInvoice">
            <div class="row">

              <div class="col-7">
                <p class="co-header">||Aqua Mobile</p>
                <p class="c-text-1">Sales Invoice</p>

                <div class="bill-to">
                  <h6>Bill To</h6>
                  <p><b>Customer :</b>&nbsp;<span>{{invoiceData.customerName}}</span></p>
                  <p style="margin-top: -1em;"><b>Phone :</b>&nbsp;<span>{{invoiceData.contactNumber}}</span></p>
                  <p style="margin-top: -1em;"><b>Nic :</b>&nbsp;<span>{{customerDetails.NIC}}</span></p>
                  <p style="margin-top: -1em;"><b>Address :</b>&nbsp;<span>{{customerDetails.Address}}</span></p>
                  <p style="margin-top: -1em;"><b>Proof :</b>&nbsp;<span>{{customerDetails.BillingProof}}</span></p>
                </div>
              </div>

              <div class="col-5 right-area">

                <img class="text-center" src="static/images/bfb7f1596737660.png" style="height:10em;width: 10em">

                <p class="c-date" ><b>Date: &nbsp;</b>{{today}}</p>
              </div>

              <div class="items-table col-12">
                <table class="uk-table">
                  <thead>
                  <tr>
                    <th class="text-center">Qty</th>
                    <th>Name</th>
                    <th>Warranty</th>
                    <th>Unit&nbsp;<i>(Rs)</i></th>
                    <th>Total&nbsp;<i>(Rs)</i></th>
                  </tr>
                  </thead>

                  <tbody>
                  <tr v-for="item in reversedArr" v-if="item.id">
                    <td class="text-center ">{{item.itemQty}}</td>
                    <td class="">{{item.itemName}}</td>
                    <td>{{item.warranty}} <span style="font-size: 13px;text-style:italic">(month/s)</span></td>
                    <td class="">{{item.unitPrice}}</td>
                    <td class="">{{item.totalPrice}}</td>
                  </tr>
                  </tbody>
                </table>

                <table class="uk-table" style="margin-top: -1.3em">
                  <tbody>
                  <tr style="border-top: none">
                    <td class="col-10" style="text-align: right">Total Discount: <i>(Rs)</i></td>
                    <td class="text-center col-2">{{invoiceData.totalAmount-invoiceData.payValue}}</td>
                  </tr>

                  <tr class="final-price">
                    <td class="col-10" style="text-align: right;background: #00bbff">Total: <i>(Rs)</i></td>
                    <td class="text-center col-2" style="background: #00bbff;">{{invoiceData.payValue}}/=</td>
                  </tr>
                  </tbody>
                </table>
              </div>

              <div class="details-area col-12">
                <p class="thanks-text mb-2">Thank you for your business!</p>
                <p class="cus-sign" style="display: none">Customer Signature</p>
              </div>

              <div class="container c-details mt-4">
                <p><b>Aqua mobile</b></p>
                <p>{{details.addLine1}},&nbsp;{{details.addLine2}}</p>
                <p>{{details.conNo}}</p>
              </div>
            </div>
          </div>
        </div>


        <div id="printDetails" style="width: 300px;font-size: 12px!important;
            text-align: center;border:1px solid black;padding:20px 10px; ">
          <div class="com-logo text-center" id="com-logo">
            <img src="static/images/bfb7f1596737660.png" id="com-logo-img" style="height:10em;width: 10em">
            <h4><b><strong>Aqua Mobile</strong></b></h4>
          </div>
          <p>{{details.addLine1}},&nbsp;{{details.addLine2}}</p>
          <p>T.P :- {{details.conNo}}</p>

          <table style="border:1px solid black;width: 100%;padding: 10px" id="print-table">
            <tr style="width: 90%;text-align: left;" id="table-tr">
              <td style="padding-left: 10px;" id="table-td">Date :- <span id="curDate">{{currentDate}}</span></td>

            </tr>
            <tr style="width: 90%;text-align: left;" id="table-tr2">
              <td style="padding-left: 10px;"  id="table-td2">Bil no :- <span>{{invoiceNo}}</span></td>

            </tr>
          </table>
          <p style="font-size: 9px;font-style: italic;margin-top: 4px;">*(Phone 1 month warranty
            Accessories 3 months warranty)</p>
          <hr>
          <table style="width: 100%;" id="print-table2">
            <tr style="background-color: black;color: #ffffff;font-weight: bold;font-size: 12px;" id="table2-tr">
              <th>Name</th>
              <th>Qty</th>
              <th>Warranty</th>
              <th>Price</th>
            </tr>

            <tr v-for="item in reversedArr" v-if="item.id" style="
                border-top: 1px solid transparent;border-left: 1px solid transparent;border-right: 1px solid transparent;border-bottom: 1px solid black;border-style: dotted;
              " id="item-tr">
              <td>{{item.itemName}}</td>
              <td>{{item.itemQty}}</td>
              <td>{{item.warranty}}&nbsp;<span style="font-size: 10px;" id="span1">Months</span></td>
              <td>{{item.totalPrice}}</td>
            </tr>
          </table>

          <div class="payments" id="payments-area" style="background-color: black;color: #ffffff;font-weight: bold;font-size: 12px">

            <table style="text-align: right;width: 90%;margin-right: 1em!important;" id="payments-table">
              <tr>
                <th></th>
                <th style="text-align: right;margin-right: 1em;" id="payments-tb-th"></th>
              </tr>

              <tr>
                <td>Total: </td>
                <td>{{invoiceData.payValue}}</td>
              </tr>

              <tr>
                <td>Discount: </td>
                <td>{{invoiceData.totalAmount-invoiceData.payValue}}</td>
              </tr>

              <tr>
                <td>Cash: </td>
                <td>{{invoiceData.cPayment}}</td>
              </tr>

              <tr>
                <td>Balance: </td>
                <td>{{invoiceData.balance}}</td>
              </tr>
            </table>
          </div>
          <hr>

          <div class="thank-you">
            <p style="text-align:center;font-size: 15px;font-weight: bold" id="thank-you-text">Thank you - Come back</p>
            <p>Software By @Bartline - 075 472 2834</p>
          </div>

        </div>

      </div>

    </div>


  </div>
</template>

<script>
  import router from "../router";
  import axios from "axios";
  import * as html2pdf from 'html2pdf.js'
  import print from 'vue-print-nb'
  const pdf2base64 = require('pdf-to-base64')


  export default {
    directives:{
      print
    },

    data(){
      return{
        isAdmin:false,
        seller:"",
        invoiceData:{
          totalAmount:0,
          totalQty:0,
          discount:0,
          payValue:0,
          cPayment:null,
          balance:0,
          customerName:"",
          contactNumber:"",
        },
        invoiceTable:[],
        today:'',

        details:{},

        currentDate:"",
        invoiceNo:"",
        pdf:"",

        customerDetails:{
          NIC:"",
          Address:"",
          BillingProof:"",
        },
      }
    },

    created() {
      this.invoiceDetails();
      this.getData();
      this.getToday();
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

          this.seller = this.$session.get('name');
        }else{
          alert("You should Login First!!")
          router.push('/');
        }
      },

      invoiceDetails(){
        var date =  new Date().toDateString();
        var time = new Date().toLocaleTimeString()
        this.currentDate = date + " " +  time.replace('GMT+0530 (Sri Lanka Standard Time)','');

        var ran = this.stringGen();
        var year = new Date().getFullYear();
        var month = (new Date().getMonth() < 10 ? '0' : '') + new Date().getMonth();
        var date = (new Date().getDate() < 10 ? '0' : '') + new Date().getDate();
        var time = new Date().getHours()+new Date().getMinutes();

        this.invoiceNo = ran+year.toString().substring(2,4)+month+date+time;

      },

      stringGen() {
        var text = "";

        var charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        for (var i = 0; i < 3; i++)
          text += charset.charAt(Math.floor(Math.random() * charset.length));

        return text;
      },

      getData(){
        if(this.$route.params.salesInvoice && this.$route.params.salesData) {
          var str = this.$route.params.salesInvoice;
          var str2 = this.$route.params.salesData;
          var obj = [{}];
          var obj2 = {};
          try {
            obj = JSON.parse(str);
            obj2 = JSON.parse(str2);
          } catch (e) {
            console.error(e);
          }

          var times = obj.length;
          for (var i = 0; i < times; i += 1) {
            this.invoiceTable.push(obj[i]);
          }

          this.invoiceData.totalAmount = obj2.totalAmount;
          this.invoiceData.totalQty = obj2.totalQty;
          this.invoiceData.discount = obj2.discount;
          this.invoiceData.payValue = obj2.payValue;
          this.invoiceData.cPayment = obj2.cPayment;
          this.invoiceData.balance = obj2.balance;
          this.invoiceData.customerName = obj2.customerName;
          this.invoiceData.contactNumber = obj2.contactNumber;
        }
      },



      goBack(){
        router.push({path:'/dashboard', name: 'dashboard',
          params: {salesData: JSON.stringify(this.invoiceData),salesInvoice: JSON.stringify(this.invoiceTable)} })
      },

      getToday(){
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = mm + '/' + dd + '/' + yyyy;
        this.today = today;
      },

      async savePdf() {
        var token = this.$token;
        var inNo = this.invoiceNo;
        var element = document.getElementById('printInvoice');



        var opt = {
          margin: 1,
          filename: 'myfile.pdf',
          image: {type: 'jpeg', quality: 0.98},
          html2canvas: {scale: 2},
          jsPDF: {unit: 'in', format: 'letter', orientation: 'portrait'}
        };


        html2pdf().from(element).set(opt).outputPdf().then(function(pdf) {
          var pdfData={
            pdfBase64:""
          };

          pdfData.pdfBase64 = btoa(pdf);

          axios.post("http://localhost:8000/api/newsaleInvoice/" + inNo, pdfData, {
            headers: {
              "token": token
            }
          });

        });
      },

      async printDiv() {

        await axios.post("http://localhost:8000/api/newSale/"+this.seller+"/"+this.invoiceNo,this.invoiceData,{
          headers:{
            "token":this.$token
          }
        })
                .then(response=>{
                  this.savePdf();

                });

        var payment;
        if(this.invoiceData.cPayment===null) {
          payment = 0;
        }
        else{
          payment = this.invoiceData.cPayment;
        }

        var fullName = this.invoiceData.customerName;

        var newLend = {
          FullName:fullName,
          Nic:this.customerDetails.NIC,
          Total:this.invoiceData.payValue,
          Payment:payment,
        }

        await axios.post("http://localhost:8000/api/newLend/"+this.invoiceNo,newLend,{
          headers:{
            "token":this.$token,
              headers:{"Content-Type" : "application/json"}
          }
        }).then(response=>{
          console.log(response)
        })


        for (const item of this.invoiceTable) {
         if(item.id){
            await axios.get("http://localhost:8000/api/reduceStock/"+item.id+"/"+item.itemQty,{
             headers:{
               "token":this.$token
             }
           }).then(router.push('/dashboard'));
         }
        }
      },


      deleteInvoice(){
        router.push("/dashboard");
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

      getPdf(formData){
        var fileReader = new FileReader();
        fileReader.readAsDataURL(formData.target.files[0]);
        fileReader.onload = (formData)=>{
          this.pdf = formData.target.result;
        }
      },

    },

    beforeMount() {
      this.checkLogin();
    },

    computed:{
      reversedArr() {
        return this.invoiceTable.slice().reverse()
      }
    },

  }
</script>

<style scoped>

  .lend-cus-details input[type=text]{
    padding: 0.3em 0.5em;
    width: 100%;
    border-radius: 5px;
    border:1px solid #dddddd;
  }

  #app{
    height: 100vh;
    overflow-y: scroll;
  }

  .action-buttons{
    position: absolute;
    top:30%;
    left: 7%;
  }

  .pr-btn{
    background: lawngreen;
    border:1px solid yellowgreen;
  }

  .cl-btn{
    background: red;
    border:1px solid red;
  }

  .bc-btn{
    background: #0b75c9;
    border:1px solid #0b75c9;
  }

  .action-buttons button{
    padding: 1em 1.3em;
    border-radius: 50%;
    transition: 0.5s;
  }

  .action-buttons button:hover{
    transform: scale(1.1);
  }

  .action-buttons button i{
    font-size: 2.7em;
    color: #ffffff;
  }

  .invoice-area{
    padding: 1.5em 1.5em 0.7em 1.5em;
    border:4px solid #0b75c9;
    width: 70%;
    margin: 0 auto;
  }

  .uk-table{
    width: 100%;
  }

  p{
    cursor: default;
    line-height: 0.7;
  }

  .uk-table th{
    background: #f5f5f0;
    color: black;
    font-weight: bold;
  }

  .uk-table tr,.uk-table td,.uk-table th{
    border:1px solid #00bbff;
    padding: 7px 12px!important;
    cursor: default;
  }

  .co-header{
    color: #0b75c9;
    font-weight: bold;
    font-size: 27px;
    text-transform: uppercase;
    margin-bottom: 1.5em;
  }

  .c-text-1{
    text-transform: uppercase;
    color: #0b75c9;
    font-size: 20px;
  }

  .bill-to{
    border:1px solid #00bbff;
    margin-bottom: 1.5em;
  }

  .bill-to h6{
    padding: 0.5em;
    border-bottom:1px solid #00bbff;
    background: #f5f5f0;
  }

  .bill-to p{
    padding: 0.5em;
  }

  .thanks-text{
    color: #0b75c9;
    font-weight: 600;
    font-size: 18px;
  }

  .c-details{
    margin-top: 2em!important;
  }

  div.right-area{
    text-align: center;
    width: 75%;
  }

  .c-date{
    border:1px solid #00bbff;
    padding: 0.5em;
    background: #f5f5f0;
    position: absolute;
    bottom: 0;
    right: 0;
    margin-right: 1em;
    margin-left: 3.5em;
    left: 0;
    margin-bottom: 1.5em;
  }

  .final-price td{
    color: #ffffff;
    font-weight: bold;
  }

  .cus-sign{
    float: right;
    font-size: 14px;
    font-style: italic;
    border-top:1px solid;
    border-top-style: dotted;
    padding-top: 2px;
  }

  #printDetails{
    position: absolute;
    right: 0;
    top: 10%;
    z-index: -1;
  }




    /*#printDetails{width: 300px;font-size: 12px}*/
    /*#com-logo{text-align:center;}*/
    /*#print-table{border:1px solid black;width: 100%;padding: 10px;}*/
    /*#table-tr{width: 90%;text-align: left;}*/
    /*#table-td{padding-left: 10px;}*/
    /*#table-tr2{width: 90%;text-align: left;}*/
    /*#table-td2{padding-left: 10px;}*/
    /*#print-table2{width: 100%;}*/
    /*#table2-tr{background-color: black;color: #ffffff;font-weight: bold;font-size: 12px;}' +*/
    /*#item-tr{border-top: 1px solid transparent;border-left: 1px solid transparent;border-right: 1px solid transparent;border-bottom: 1px solid black;border-style: dotted;}*/
    /*#span1{font-size: 10px;}*/
    /*#payments-area{background-color: black;color: #ffffff;font-weight: bold;font-size: 12px;}*/
    /*#payments-table{text-align: right;width: 90%;margin-right: 1em!important;}*/
    /*#payments-tb-th{text-align: right;margin-right: 1em;}*/
    /*#thank-you-text{text-align:center;font-size: 15px;font-weight: bold;}*/

</style>
