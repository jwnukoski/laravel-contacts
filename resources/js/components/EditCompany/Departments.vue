<template>
    <div class="form-group" v-if="departments && company.id">
        <h5>Departments:</h5>

        <Department v-for="department in departments"
            :key="department.id" :company="company" 
            :department="department" @refresh="$emit('refresh')"
            :ref="`department${department.id}`">
        </Department>

        <button type="button" class="btn btn-success" @click="newDepartment">New {{ company.name }} department</button>

        <div v-if="departments.length <= 0">No deparments for this company</div>
    </div>
</template>

<script>
    import Department from './Department'

    export default {
        name: 'Departments',
        components: {
            Department
        },
        created() {
            
        },
        data() {
            return {
                
            }
        },
        methods: {
            newDepartment() {
                this.departments.push({
                    id: null,
                    name: null,
                    company_id: this.company.id
                })
            },
            savePositions() {
                this.departments.forEach((department) => {
                    const refName = `department${department.id}`
                    this.$refs[refName][0].savePositions()
                })
            }
        },
        props: {
            company: Object,
            departments: Array
        }
    }
</script>