<template>
  <div class="padding-print">
    <div class="btn-print mb-5"><v-btn @click="print">Guardar / Imprimir</v-btn></div>
    <v-row>
      <v-col>
        <div class="d-flex">
          <v-img max-height="50" max-width="50" contain src="/images/LogoPNG.png" />
          <div class="ml-2">
            <strong>
              AGENCIA DE <br />
              IMPORTACIONES
            </strong>
          </div>
        </div>
      </v-col>
      <v-spacer></v-spacer>
      <v-col cols="5" class="text-right">
        <h3 class="htext">ORDEN DE COMPRA</h3>
      </v-col>
    </v-row>
    <v-row>
      <v-col class="pb-0">
        <h3 class="pb-0 mb-0"><strong>BIZZPERU SA</strong></h3>
      </v-col>
      <v-col cols="3" class="text-center align-center justify-center pb-0">
        <h4 class="mb-0 mt-auto size-print">
          <strong>
            OC{{ new Date().getFullYear() }} - {{ catalogue.name[0]
            }}{{ $route.params.id | number }}
          </strong>
        </h4>
      </v-col>
    </v-row>
    <v-row>
      <v-col class="pt-0">
        <div>RUC 20559212378</div>
        <div>Calle Don Bosco 107</div>
        <div>Arequipa, Perú</div>

        <br />
        <br />

        <strong>Emitido para:</strong>
        <div class="text-capitalize">Nombre: {{ user.name }}</div>
        <div>Cel: {{ user.phone }}</div>
        <div>DNI: {{ user.dni }}</div>
        <div>Correo: {{ user.email }}</div>
        <div>RUC: {{ user.ruc }}</div>
        <div>Razón Social:</div>
        <div>Cuidad: {{ user.city }}</div>
      </v-col>
      <v-spacer></v-spacer>
      <v-col cols="3" class="text-center pt-0">
        <table class="table text-left table-information">
          <tbody>
            <tr>
              <td class="table-information">
                Fecha de Emisión
              </td>
            </tr>
            <tr>
              <td class="table-information">
                {{ new Date() | date }}
              </td>
            </tr>
            <tr>
              <td class="table-information">
                Transporte:
              </td>
            </tr>
            <tr>
              <td class="table-information">Vendedor: {{ userAdmin }}</td>
            </tr>
          </tbody>
          <tfoot v-for="(arr, index) in order.arrivals" :key="index">
            <tr>
              <td class="table-information">
                <div>
                  Fecha estimada de reparto/recojo
                  <strong class="text-uppercase">{{ arr.city }}</strong>
                </div>
              </td>
            </tr>
            <tr>
              <td class="table-information">{{ arr.arrival_date | date }}</td>
            </tr>
          </tfoot>
        </table>
      </v-col>
    </v-row>
    <br />
    <br />
    <table class="table text-center">
      <thead>
        <tr>
          <th class="table-product">ITEM</th>
          <th colspan="2" class="table-product">DESCRIPCIÓN</th>
          <th class="table-product">PU</th>
          <th class="table-product">CANTIDAD</th>
          <th class="table-product">Q CAJAS</th>
          <th class="table-product">TOTAL SOLES</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(p, index) in product" :key="index">
          <td class="table-item">
            {{ p.product ? p.product.model : p.product_range.model }}
          </td>
          <td class="table-item">
            <br />
          </td>
          <td class="table-item">
            <br />
          </td>
          <td class="table-item">
            {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}
            {{ p.product ? p.product.price_unit : p.price | currency }}
          </td>
          <td class="table-item">
            {{ p.quantity }}
          </td>
          <td class="table-item">
            <br />
          </td>
          <td class="text-right table-item">
            {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}
            {{ p.total | currency }}
          </td>
        </tr>
        <tr>
          <td class="table-product">
            <br />
          </td>
          <td class="table-product">
            <br />
          </td>
          <td class="table-product">
            <br />
          </td>
          <td class="table-product">
            <br />
          </td>
          <td class="table-product">
            <br />
          </td>
          <td class="table-product">
            <br />
          </td>
          <td class="table-product">
            <br />
          </td>
        </tr>
        <tr>
          <td colspan="5" class="text-right table-foot">
            Subtotal
          </td>
          <td class="table-foot">
            <br />
          </td>
          <td class="text-right table-total">
            {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}
            {{ totalOrderPayment | currency }}
          </td>
        </tr>
        <tr>
          <td colspan="5" class="text-right table-foot">
            <br />
          </td>
          <td class="table-foot">
            <br />
          </td>
          <td class="text-right table-product">
            <br />
          </td>
        </tr>
        <tr>
          <td colspan="5" class="text-right table-foot">
            <strong>Total</strong>
          </td>
          <td class="table-foot">
            <br />
          </td>
          <td class="text-right table-total">
            {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}

            {{ totalOrderPayment | currency }}
          </td>
        </tr>
        <tr>
          <td colspan="5" class="text-right table-foot">
            <br />
          </td>
          <td class="table-foot">
            <br />
          </td>
          <td class="text-right table-foot ">
            <br />
          </td>
        </tr>
      </tbody>
      <tbody v-for="(pa, index) in pay" :key="index" class="table-foot">
        <tr>
          <td colspan="5" class="text-right table-foot">
            {{ pa.payment_concept_name }}
          </td>
          <td class="table-foot">
            {{ pa.payment_date | date }}
          </td>
          <td class="text-right table-foot">
            {{ pa.mount == '' ? '' : (pa.type_coin == 'soles' ? 'S/.' : '$') + ' ' }}
            {{ pa.mount | currency }}
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5" class="text-right table-foot">
            Pagado
          </td>
          <td class="table-foot">
            <br />
          </td>
          <td class="text-right table-foot table-pagado">
            {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}

            {{ totalPayments | currency }}
          </td>
        </tr>
        <tr>
          <td colspan="5" class="text-right table-foot">
            Saldo
          </td>
          <td class="table-foot">
            <br />
          </td>
          <td class="text-right table-foot table-saldo">
            {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}
            {{ (totalOrderPayment - totalPayments) | currency }}
          </td>
        </tr>
      </tfoot>
    </table>
    <div class="d-flex mt-5">
      <div class="mx-auto d-block">
        *Costo de envio a otras ciudades diferentes a Arequipa, asumido por Cliente
        <br />
        *Comisiones bancarias son asumidas por cliente, se recomienda realizar tranferencia BCP-BCP
        <br />
        misma moneda de cuenta origen/destino
        <br />
        <br />
        Número de Cuenta BCP Ahorros Soles BIZZPERU SA<br />
        215-31690893-0-98<br />
        Código de Cuenta Interbancaria <br />
        00221513169089309824 <br />
        <br />
        <br />
        Número de Cuenta BBVA Ahorros soles BIZZPERU COMPANY EIRL <br />
        0011-0220-0201770773 <br />
        Código de Cuenta Interbancaria <br />
        01122000020177077314 <br />
        00221513169089309824 <br />
      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios';
import moment from 'moment';

export default {
  data: () => ({
    order: [],
    valid: true,
    product: [],
    catalogue: {
      name: '',
    },
    user: {
      name: '',
    },
    payments: [],
    pay: [],
    concept: [],
    state: [],
    bank: [],
    itemSelected: '',
    idDelete: [],
    typeCoin: ['soles', 'dolares'],
    totalPayments: null,
    totalOrderPayment: null,
    userAdmin: '',
  }),
  computed: {},
  methods: {
    printWindow() {
      this.hbtn = false;
      window.print();
    },

    getUser() {
      axios
        .get('http://applaravel7.test/api/v1/user')
        .then(r => {
          this.userAdmin = r.data.data.name;
        })
        .catch(error => {
          console.log(error);
          // reject(error);
        });
    },

    getOrders() {
      axios
        .get(`/api/v1/orders/${this.$route.params.id}`)
        .then(response => {
          console.log('response', response);
          this.product = response.data.data.orderDetails;
          this.order = response.data.data;
          this.user = response.data.data.user;
          this.catalogue = response.data.data.catalogue;
          this.payments = response.data.data.payment;
          this.totalOrderPayment = this.order.total_order;
          this.totalPayments = 0;
          if (this.payments.length != 0 && this.payments != null) {
            this.payments.forEach(payment => {
              if (this.catalogue.coin == 'soles') {
                if (payment.type_coin == 'soles') {
                  this.totalPayments = this.totalPayments + parseFloat(payment.mount);
                } else {
                  this.totalPayments =
                    this.totalPayments +
                    parseFloat(payment.mount) * parseFloat(payment.dollar_price);
                }
              } else {
                if (payment.type_coin == 'soles') {
                  this.totalPayments =
                    this.totalPayments +
                    parseFloat(payment.mount) / parseFloat(payment.dollar_price);
                } else {
                  this.totalPayments = this.totalPayments + parseFloat(payment.mount);
                }
              }
            });
          }
          this.pay = response.data.data.payment;
          console.log('payment', this.product);
        })
        .catch(error => {
          console.log(error);
          // reject(error);
        });
    },
    print() {
      window.print();
    },
  },
  mounted() {
    this.getOrders();
    this.getUser();
  },
  filters: {
    currency: function(value) {
      if (value == '') {
        return ' ';
      } else {
        return parseFloat(value).toFixed(2);
      }
    },
    porcent: function(value) {
      return parseFloat(value) * 100 + ' %';
    },
    date: function(value) {
      return moment(value).format('DD-MM-YYYY');
    },
    number: function(value) {
      return value.toString().padStart(5, '0');
    },
  },
};
</script>
<style scoped>
td,
th {
  padding: 0 10px 0 10px !important;
}
.htext {
  color: #808080;
  font-weight: bolder;
}
.table-information {
  border: 2px solid black;
  background-color: white !important;
}
.table-product {
  border: 2px solid black;
}
.table-item {
  border-bottom: 0;
  border-top: 0;
  border-right: 2px solid black;
  border-left: 2px solid black;
}
.table-foot {
  border-bottom: 0;
  border-top: 0;
  border-right: 0;
  border-left: 0;
}
.table-total {
  border: 2px solid black;
  background-color: #ffffcc;
}
.table-saldo {
  background-color: #ffc000;
}
.table-pagado {
  background-color: #ffffcc;
}
.padding-print {
  margin: 10% 10% 10% 10%;
}
@media print {
  html,
  body {
    width: 210mm;
    height: 297mm;
    padding-top: 50px;
    margin-right: 50px;
    margin-left: 50px;
    background-color: white !important;
    -webkit-print-color-adjust: exact;
  }
  .padding-print {
    margin: 0 10% 10% 10%;
  }
  .table-total {
    border: 2px solid black;
    background-color: #ffffcc !important;
  }
  .table-saldo {
    background-color: #ffc000 !important;
  }
  .table-pagado {
    background-color: #ffffcc !important;
  }
  .btn-print {
    visibility: hidden;
  }
  .size-print {
    font-size: 20px;
  }
}
</style>
