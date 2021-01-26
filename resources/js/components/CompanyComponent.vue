<template>
  <v-card>
    <v-row dense class="mt-2 ml-2">
        <v-col cols="3">
          <v-text-field
            v-model="company_name"
            label="Enter Company Name"
            background-color="#FFFBE6"
            dense
            solo
            class="mt-3"
          ></v-text-field>
        </v-col>
        <v-col cols="2">
          <v-btn
            dark
            color="#356859"
            class="mt-3"
            @click="save()"
          >
            Submit
          </v-btn>
        </v-col>
    </v-row>

    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">
              No
            </th>
            <th class="text-left">
              Company
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(item,index) in companies"
            :key="index"
          >
            <td>{{ index + 1 }}</td>
            <td>{{ item.company_name }}</td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
  </v-card>
</template>
<script>
  export default {
    data () {
      return {
        company_name: null,
        companies: [],
      }
    },

    created(){
      axios.get('company').then(res => {
        this.companies = res.data
      })
    },

    computed:{
        count(){
          return this.companies.map(rec => {
            return rec.created_at
          })
        }
    },

    methods:{
      save(){
        axios.post('company', {company_name: this.company_name})
        .then(res => {
          if(res.data.length > 0){
            this.companies = res.data
          }
        })
      }
    }
  }
</script>