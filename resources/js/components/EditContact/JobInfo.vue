<template>
<div class="form-group">
    <div class="form-group">
        <label for="company">Company</label>
            <select v-model="contact.position.department.company.id" @change="getDepartments(contact.position.department.company.id)">
            <option v-for="company in $store.state.companies" 
                :value="company.id"
                :key="company.id">
                {{ company.name }}
            </option>
        </select>
    </div>
    <div class="form-group" v-if="contact.position.department.company.id">
        <label for="department">Department</label>
        <select name="department" id="department" v-model="contact.position.department.id" @change="getPositions(contact.position.department.id)" v-if="departments.length > 0">
            <option v-for="department in departments"
                :value="department.id"
                :key="department.id">
                {{ department.name }}
            </option>
        </select>
        <div v-if="departments.length <= 0">No departments for this company</div>
    </div>
    <div class="form-group" v-if="contact.position.department.id">
        <label for="position">Position:</label>
        <select name="position" id="position" v-model="contact.position.id" v-if="positions.length > 0">
            <option v-for="position in positions"
                :value="position.id"
                :key="position.id">
                {{ position.title }}
            </option>
        </select>
        <div v-if="positions.length <= 0">No positions for this department</div>
    </div>
    <div class="form-group" v-if="contact.position.id && positions.length > 0">
        <input type="checkbox" v-model="contact.position.is_liason" :true-value="true" :false-value="false"> Position is IT liason
    </div>
</div>
</template>

<script>
    export default {
        name: 'JobInfo',
        created() {
            if (!this.contact.position) {
                this.contact.position = {
                    id: null,
                    title: null,
                    is_liason: false,
                    department: {
                        id: null,
                        company: {
                            id: null
                        }
                    }
                }
            } else {    
                const companyId = this.contact.position.department.company.id || null
                const departmentId = this.contact.position.department.id || null

                companyId ? this.getDepartments(companyId) : null
                departmentId ? this.getPositions(departmentId) : null
            }
        },
        data() {
            return {
                departments: [],
                positions: []
            }
        },
        methods: {
             getDepartments(companyId) {
                this.positions = []

                axios.get(`/api/department/${companyId}`).then(response => {
                    this.departments = response.data
                    return response.data
                }).then(() => {
                    return true
                }).catch(error => {
                    console.error(error)
                })
            },
            getPositions(departmentId) {
                axios.get(`/api/department/positions/${departmentId}`).then(response => {
                    this.positions = response.data
                    return true
                }).catch(error => {
                    console.error(error)
                })
            }
        },
        props: {
            contact: Object,
            companies: Array
        }
    }
</script>