<template>
  <div>
    Localización
    <v-row>
      <v-col cols="3" md="3">
        Nombre
        <v-text-field solo dense dense></v-text-field>
      </v-col>
      <v-col cols="3" md="3">
        Punto de Referencia
        <v-text-field solo dense></v-text-field>
      </v-col>
      <v-col cols="3" md="3">
        Ciudad
        <v-text-field solo dense></v-text-field>
      </v-col>
      <v-col cols="3" md="3">
        Codigo Postal
        <v-text-field solo dense></v-text-field>
      </v-col>
      <v-col cols="3" md="3">
        Pais
        <v-text-field solo dense></v-text-field>
      </v-col>
      <v-col cols="3" md="3">
        Precio grupal
        <v-text-field solo dense></v-text-field>
      </v-col>
      <v-col cols="3" md="3">
        Invoice Scheme
        <v-text-field solo dense></v-text-field>
      </v-col>
      <v-col cols="3" md="3">
        Invoice Layout for POS
        <v-text-field solo dense></v-text-field>
      </v-col>
      <v-col cols="3" md="3">
        Invoice Layout for Sale
        <v-text-field solo dense></v-text-field>
      </v-col>
    </v-row>
    <v-row>
      <v-spacer></v-spacer>
      <v-btn class="mx-1">Guardar</v-btn>
      <v-btn class="mx-1">Cancelar</v-btn>
    </v-row>
  </div>
</template>
<script>
export default {};
</script>
