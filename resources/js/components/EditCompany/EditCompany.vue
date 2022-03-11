<template>
    <div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ company.name }}</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="company_name"></label>
                            <input type="text" class="form-control" id="company_name" placeholder="Company name" v-model="company.name">
                        </div>
                        <div class="form-group" v-if="company.id">
                            <Departments :company="company" :departments="departments" @refresh="$emit('rerfresh')"
                            ref="departments"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" @click="deleteCompany" v-if="company.id">Delete</button>

                    <button type="button" class="btn btn-success" @click="saveCompany">Save</button>
                    
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="close">Close</button>
                </div>
            </div>    
        </div>
        <div class="dark-bkg" @click="close"></div>
    </div>
</template>

<script>
    import axios from 'axios'
    import Departments from './Departments.vue'

    export default {
        name: 'EditCompany',
        components: {
            Departments
        },
        data() {
            return {
                departments: []
            }
        },
        created() {
            this.getDepartments()
        },
        methods: {
            close() {
                this.$emit('close')
            },
            deleteCompany() {
                axios.post(`/api/company/destroy/${this.company.id}`, this.company).then(response => {
                    if (response.status === 200) {
                        return true
                    }
                    throw new Error(response.status)
                }).then(() => {
                    this.$emit('close-and-refresh')
                }).catch(error => {
                    console.error(error)
                })
            },
            getDepartments() {
                axios.get(`/api/department/${this.company.id}`).then(response => {
                    this.departments = response.data
                }).catch(error => {
                    console.error(error)
                })
            },
            async saveCompany() {
                const companyRoute = this.company.id ? `/api/company/update/${this.company.id}` : '/api/company'

                await axios.post(companyRoute, this.company).then(response => {
                    if (response.status === 200) {
                        return true
                    }
                }).catch(error => {
                    console.error(error)
                    return false
                })

                try {
                    this.$refs.departments.savePositions()
                } catch (error) {}

                if (this.departments.length > 0) {
                    await this.saveDepartments();
                }

                this.$emit('close-and-refresh')
            },
            async saveDepartments() {
                return axios.post('/api/department/update/all', this.departments).then(response => {
                    if (response.status === 200) {
                        return true
                    }
                    throw new Error(response.status)
                }).catch(error => {
                    console.error(error)
                })
            }
        },
        props: {
            company: Object
        }
    }
</script>

<style scoped>
    .dark-bkg {
        position: fixed;
        background-color: rgba(0, 0, 0, 0.5);
        width: 100vw;
        height: 100vh;
        left: 0;
        top: 0;
    }
    .modal-dialog {
        position: fixed;
        width: 75vw;
        max-width: 100vw;
        top: 0;
        left: 12.5vw;
        z-index: 30;
    }
    .modal-content {
        max-height: 75vh !important;
        overflow-y: auto;
        overflow-x: auto;
    }
</style>