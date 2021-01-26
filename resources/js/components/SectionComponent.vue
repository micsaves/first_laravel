<template>
  <v-card>
    <v-row dense class="mt-2 ml-2">
        <v-col cols="2">
            <v-select 
                solo 
                dense
                class="mt-3"
                v-model="company_code"  
                label="Select Company"
                :items="companies"
                item-text="company_name"
                item-value="company_code"
                background-color="#FFFBE6"
            >
            </v-select>
        </v-col>

        <v-col cols="2">
            <v-select 
                solo 
                dense
                class="mt-3"
                v-model="department_code"  
                label="Select Department"
                :items="filteredDepartment"
                item-text="department_name"
                item-value="department_code"
                background-color="#FFFBE6"
            >
            </v-select>
            {{test}}
        </v-col>

        <v-col cols="3">
          <v-text-field
            v-model="section_name"
            label="Enter Section Name"
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
            <th class="text-left">
              Section
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(item,index) in sections"
            :key="index"
          >
            <td>{{ index + 1 }}</td>
            <td>{{ item.company_name }}</td>
            <td>{{ item.department_name }}</td>
            <td>{{ item.section_name }}</td>
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
        department_code: null,
        section_name: null,
        companies: [],
        departments: [],
        sections: []
      }
    },

    created(){
      axios.get('company').then(res1 => {
          this.companies = res1.data
          axios.get('department').then(res2 => {
              this.departments = res2.data
              axios.get('section').then(res3 => {
                  this.sections = res3.data
              })
          })
      })
    },

    computed:{
        filteredDepartment(){
            return this.departments.filter(rec => {
                return rec.company_code == this.company_code
            })
        },

        test(){
          return this.departments.map(rec => {
            return rec.department_name
          })
        }
    },

    methods:{
      save(){
        axios.post('section', 
            {
                company_code: this.company_code, 
                department_code: this.department_code, 
                section_name: this.section_name
            }).then(res => {
                if(res.data.length > 0){
                    this.sections = res.data
                }
        })
      }
    }
  }
</script>