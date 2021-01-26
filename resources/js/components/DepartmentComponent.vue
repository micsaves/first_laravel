<template>
  <v-card>
    <v-row dense class="mt-2 ml-2">
        <v-col cols="2">
            <v-select 
                solo 
                dense
                v-model="company_code" 
                class="mt-3" 
                label="Select Company"
                :items="companies"
                item-text="company_name"
                item-value="company_code"
                background-color="#FFFBE6"
            >
            </v-select>
        </v-col>

        <v-col cols="3">
          <v-text-field
            v-model="department_name"
            label="Enter Department Name"
            background-color="#FFFBE6"
            class="mt-3"
            dense
            solo
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
            <th class="text-left">
              Department
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(item,index) in departments"
            :key="index"
          >
            <td>{{ index + 1 }}</td>
            <td>{{ item.company_name }}</td>
            <td>{{ item.department_name }}</td>
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
        company_code: null,
        department_name: null,
        companies: [],
        departments: [],
      }
    },

    created(){
      axios.get('company').then(res1 => {
          this.companies = res1.data
          axios.get('department').then(res2 => {
              this.departments = res2.data
          })
      })
    },

    methods:{
      save(){
        axios.post('department', 
          {
            company_code: this.company_code, 
            department_name: this.department_name
          }).then(res => {
            if(res.data.length > 0){
              this.departments = res.data
            }
        })
      }
    }
  }
</script>