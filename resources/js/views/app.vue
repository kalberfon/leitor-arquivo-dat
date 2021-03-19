<template>
    <v-container style="max-width: 500px">
        <v-row>
            <v-col>
                <v-form ref="form">
                    <input type="file" @change="selectFile">
                    <v-btn block v-on:click.prevent="submit()">Processar Arquivo</v-btn>
                </v-form>
            </v-col>

        </v-row>

        <v-row v-if="fileOutput">
           <v-col>
               <v-card
                   elevation="2"
               >
                   <v-card-title>
                       Metricas
                   </v-card-title>
                   <v-card-subtitle>
                       <v-list class="transparent">
                           <v-list-item>
                               <v-list-item-title>Total de Clientes</v-list-item-title>

                               <v-list-item-subtitle class="text-right">
                                   {{fileOutput.customer.count}}
                               </v-list-item-subtitle>
                           </v-list-item>
                           <v-list-item>
                               <v-list-item-title>Total de Vendedores</v-list-item-title>

                               <v-list-item-subtitle class="text-right">
                                   {{fileOutput.salesman.count}}
                               </v-list-item-subtitle>
                           </v-list-item>
                           <v-list-item>
                               <v-list-item-title>Media salarial</v-list-item-title>

                               <v-list-item-subtitle class="text-right">
                                   {{fileOutput.salesman.avarage_wage}}
                               </v-list-item-subtitle>
                           </v-list-item>
                           <v-list-item>
                               <v-list-item-title>Id melhor compra</v-list-item-title>

                               <v-list-item-subtitle class="text-right">
                                   {{fileOutput.sale.most_expensive}}
                               </v-list-item-subtitle>
                           </v-list-item>
                           <v-list-item>
                               <v-list-item-title>Pior Vendedor</v-list-item-title>

                               <v-list-item-subtitle class="text-right">
                                   {{fileOutput.salesman.worst_seller[2]}}
                               </v-list-item-subtitle>
                           </v-list-item>
                       </v-list>
                   </v-card-subtitle>
               </v-card>
           </v-col>
        </v-row>
    </v-container>

</template>

<script>
  export default {
    name: "App",
    data: () => ({
      file: null,
      fileOutput: null
    }),
    methods: {
      selectFile(event) {
        // `files` is always an array because the file input may be in multiple mode
        this.file = event.target.files[0];
      },
      submit() {
        const data = new FormData();
        data.append('file', this.file);
        axios.post("/upload", data)
          .then(r => r.data)
          .then(r => this.fileOutput = r);
      }
    }
  }
</script>

<style scoped>

</style>
