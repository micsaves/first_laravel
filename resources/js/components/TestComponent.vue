<template>
  <v-card>
    <v-row dense class="mt-2 ml-2">
      <v-col cols="2">
          <v-text-field
              v-model="val1"
              label="Enter 1st Number"
              class="mt-3"
              dense
              solo
              style="font-weight:bold"
              background-color="#FFFBE6"
          ></v-text-field>
      </v-col>

      <v-col cols="2">
          <v-select 
              solo 
              dense
              v-model="optr"  
              class="mt-3"
              label="Operator"
              :items="optr_array"
              style="font-weight:bold;"
              background-color="#FFFBE6"
          >
          </v-select>
      </v-col>

      <v-col cols="2">
          <v-text-field
              v-model="val2"
              label="Enter 2nd Number"
              class="mt-3"
              dense
              solo
              style="font-weight:bold"
              background-color="#FFFBE6"
          ></v-text-field>
      </v-col>
      <v-col cols="4">
          <h1 class="mt-3">  = {{computeData}}</h1>
      </v-col>
    </v-row>
  </v-card>
</template>
<script>
export default {
  data(){
    return {
      tabs_index: null,
      optr: '',
      val1: '',
      val2: '', 
      result: 0,
      optr_array: ["+", "-", "*", "/"]
    }
  },
  
  computed:{
    computeData(){
      if((this.val1 == '' || this.val2 == '' || this.optr == '')){
          return 0
      }else{
          return eval('(' + parseInt(this.val1) + this.optr + parseInt(this.val2) + ')')
      }
    }
  }
}
</script>