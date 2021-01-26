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

        <v-col cols="2">
            <v-select 
                solo 
                dense
                v-model="department_code" 
                class="mt-3" 
                label="Select Department"
                :items="filteredDepartment"
                item-text="department_name"
                item-value="department_code"
                background-color="#FFFBE6"
            >
            </v-select>
        </v-col>

        <v-col cols="2">
            <v-select 
                solo 
                dense
                v-model="section_code"  
                class="mt-3"
                label="Select Section"
                :items="filteredSection"
                item-text="section_name"
                item-value="section_code"
                background-color="#FFFBE6"
            >
            </v-select>
        </v-col>

        <v-col cols="3">
          <v-text-field
            v-model="employee_name"
            label="Enter Employee Name"
            background-color="#FFFBE6"
            class="mt-3"
            dense
            solo
          ></v-text-field>
        </v-col>
    </v-row>

    <v-row dense class="mt-n8 ml-2">
        <v-col cols="2">
            <v-select 
                solo 
                dense
                v-model="gender"  
                class="mt-3"
                label="Select Gender"
                :items="gender_array"
                item-text="text"
                item-value="val"
                background-color="#FFFBE6"
            >
            </v-select>
        </v-col>

        <v-col cols="3">
            <v-select 
                solo 
                dense
                v-model="contract_status"  
                class="mt-3"
                label="Select Contract Status"
                :items="contract_status_array"
                item-text="text"
                item-value="val"
                background-color="#FFFBE6"
            >
            </v-select>
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
              Employee Name
            </th>
            <th class="text-left">
              Gender
            </th>
            <th class="text-left">
              Contract Status
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
            v-for="(item,index) in employees"
            :key="index"
          >
            <td>{{ index + 1 }}</td>
            <td>{{ item.employee_name }}</td>
            <td>{{ item.gender }}</td>
            <td>{{ item.contract_status }}</td>
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
        section_code: null,
        employee_name: null,
        gender:null,
        contract_status: null,
        companies: [],
        departments: [],
        sections: [],
        employees: [],
        gender_array: [
            {val: 0, text: "Female"},
            {val: 1, text: "Male"}
        ],
        contract_status_array: [
            {val: "C", text: "Contractual"},
            {val: "R", text: "Regular"}
        ]
      }
    },

    created(){
      axios.get('company').then(res1 => {
          this.companies = res1.data
          axios.get('department').then(res2 => {
              this.departments = res2.data
              axios.get('section').then(res3 => {
                  this.sections = res3.data
                  axios.get('employee').then(res4 => {
                      this.employees = res4.data
                  })
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

        filteredSection(){
            return this.sections.filter(rec => {
                return rec.company_code == this.company_code 
                    && rec.department_code == this.department_code
            })
        }
    },

    methods:{
      save(){
        axios.post('employee', 
            {
                company_code: this.company_code, 
                department_code: this.department_code, 
                section_code: this.section_code, 
                employee_name: this.employee_name, 
                gender: this.gender, 
                contract_status: this.contract_status
            }).then(res => {
                if(res.data.length > 0){
                    this.employees = res.data
                }
        })
      }
    }
  }
</script>