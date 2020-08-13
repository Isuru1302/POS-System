<template>
    <div id="app">

        <div class="container">
            <div class="barcode-area" >

                <div class="go-back" v-if="goBack">
                    <i class="fa fa-backward" @click="goBackPage" aria-hidden="true"></i>
                </div>

                <div id="qrCode">
                    <qrcode ref="printBarcode" id="barcode" v-if="barcodeValue!==''" :value="barcodeValue" :options="{ width: 300 }"></qrcode>
                    <button class="genBtn" v-if="barcodeValue===''" @click="generateQR">Generate</button>
                    <p class="mt-1" v-if="barcodeValue===''">Or Scan</p>
                </div>
            </div>

            <div class="generate-barcode-save" v-if="barcodeValue!==''">

                <button class="download" v-if="!downloaded" @click="downloadQR">Download</button>
                <button class="save ml-3" v-if="downloaded" @click="saveQR">Save</button>
            </div>

        </div>

    </div>
</template>

<script>

    import Vue from 'vue';
    import VueQrcode from '@chenfengyuan/vue-qrcode'
    Vue.component(VueQrcode.name, VueQrcode);
    import axios from 'axios'
    import html2canvas from 'html2canvas'
    import jsPDF from 'jspdf'

    export default {
        data(){
            return{
                loading: false,
                barcodeValue:"",
                downloaded:false,
                itemCode:"",
                goBack:false,
            }
        },

        created() {
            const eventBus = this.$barcodeScanner.init(this.onBarcodeScanned, { eventBus: true })
            if (eventBus) {
                eventBus.$on('start', () => { this.loading = true })
                eventBus.$on('finish', () => { this.loading = false })
            }

        },

        methods:{

            async generateQR(){
              var ran = this.createRandom();
                await axios.get("http://localhost:8000/api/searchByBarcode/"+ran,{
                    headers:{
                        "token":this.$token
                    }
                })
                .then(response=>{
                   if(response.data.barcodeRes==="Not found"){
                       this.barcodeValue = ran;
                   }else{
                       this.generateQR();
                   }
                });
            },

            async onBarcodeScanned (barcode) {
                var code = barcode.replace("Enter",'')
                await axios.get("http://localhost:8000/api/searchByBarcode/"+code,{
                    headers:{
                        "token":this.$token
                    }
                })
                    .then(response=>{
                        if(response.data.barcodeRes==="Not found"){
                            this.barcodeValue = code;
                            console.log(code)
                        }else{
                            alert("Barcode is already available!!")
                        }
                    });

            },

            async downloadQR(){
                var doc = new jsPDF('p', 'mm');
                html2canvas(document.querySelector("#barcode")).then(canvas => {
                    var canvasData = canvas.toDataURL('image/png');
                    doc.addImage(canvasData, 'PNG', 0, 0);
                    doc.save(this.itemCode+'.pdf');
                });
                this.downloaded=true;

            },

            async saveQR(){
                await axios.get("http://localhost:8000/api/barcode/"+this.itemCode+"/"+this.barcodeValue,{
                    headers:{
                        "token":this.$token
                    }
                })
                await this.$router.push('/products')
            },

            createRandom(){
                return Math.floor(Math.random() * 10000000000);
            },

            getItemCode(){
                this.itemCode = this.$route.query.itemCode;
            },

            goBackPage(){
                this.$router.push('/products')
            },

            checkPath(){
                if(this.$route.query.backPage) {
                    var path = this.$route.query.backPage;
                    if(path === "true"){
                        this.goBack=true;
                    }else{
                        this.goBack=false;
                    }
                }
            },
        },

        beforeMount() {
            this.getItemCode();
            this.checkPath();
        },

    }
</script>

<style scoped>

    .barcode-area,.generate-barcode-save{
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .generate-barcode-save{
        margin-top: 4em;
    }

    #qrCode{
        text-align: center;
    }

    .barcode-area #qrCode{
        margin-top: 1em;
        border-style: double;
        border-color: red;
        min-height: 300px;
        width: 300px;
    }

    #app{
        min-height: 100vh;
    }

    .genBtn{
        background: red;
        color: #ffffff;
        font-size: 20px;
        font-weight: bold;
        padding: 1em 2em;
        border:1px solid lawngreen;
        border-radius: 5px;
        transition: 0.5s;
        margin-top: 100px;
    }

    .genBtn:hover{
        transform: scale(1.1);
    }

    .generate-barcode-save button{
        width: 8em;
        font-size: 18px;
        font-weight: bold;
        padding: 0.5em;
        color: #ffffff;
    }

    .generate-barcode-save .save{
        background: #0b75c9;
        border:1px solid #0b75c9;
        border-radius: 5px;
        transition: 0.5s;
    }

    .generate-barcode-save .download{
        background: lawngreen;
        border:1px solid lawngreen;
        border-radius: 5px;
        transition: 0.5s;
    }

    .generate-barcode-save .save:hover,
    .generate-barcode-save .download:hover{
        transform: scale(1.1);
    }

    .go-back{
        position: absolute;
        top:5%;
        left: 5%;
    }

    .go-back i{
        font-size: 1.5em;
        cursor: pointer;
        border:1px solid black;
        border-radius: 50%;
        padding: 0.5em 0.7em 0.5em 0.4em;
    }
</style>
