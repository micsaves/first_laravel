<template>
    <v-container fluid>
        <v-card color="#FFFBE6">
            <v-tabs 
                v-model="tabs_index" 
                background-color="transparent"
                color="#356859"
                grow
            >   
                <template v-for="(item, index) in tabs_name">
                    <v-tab :key="index" style="font-weight:bold;">{{item}}</v-tab>
                </template>
            </v-tabs>

                <company-component v-if="tabs_index == 0"></company-component>
                <department-component v-if="tabs_index == 1"></department-component>
                <section-component v-if="tabs_index == 2"></section-component>
                <employee-component v-if="tabs_index == 3"></employee-component>
                <test-component v-if="tabs_index == 4"></test-component>
        </v-card>
    </v-container>
</template>

<script>
import CompanyComponent from './CompanyComponent.vue'
import DepartmentComponent from './DepartmentComponent.vue'
import EmployeeComponent from './EmployeeComponent.vue'
import SectionComponent from './SectionComponent.vue'
import TestComponent from './TestComponent.vue'


export default {
  components: 
        { 
            CompanyComponent, 
            DepartmentComponent, 
            SectionComponent, 
            EmployeeComponent, 
            TestComponent 
        },

    data(){
                
        return {
            tabs_index: null,
            tabs_name:['Company', 'Department', 'Section', 'Employee', 'Test']
        }
    }
}
</script>