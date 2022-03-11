<template>
    <div>
        <h1>Companies</h1>
        <button class="btn btn-success" @click="openNewCompany">New company</button>

        <EditCompany :company="selectedCompany" :companies="companies" 
            v-if="showEditCompany" @close="closeEditCompany" @close-and-refresh="closeEditCompanyThenRefresh"/>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Name:</th>
                </tr>
            </thead>
            <tbody v-for="company in sortedCompanies" :key="company.id">
                <Company :company="company" @open-company-modal="openEditCompany"/>
            </tbody>
        </table>
    </div>
</template>

<script>
    import Company from './Company'
    import EditCompany from './EditCompany/EditCompany.vue'
    
    export default {
        name: 'Companies',
        components: {
            Company,
            EditCompany
        },
        data() {
            return {
                showEditCompany: false,
                selectedCompany: {}
            }
        },
        computed: {
            sortedCompanies() {
                return [...this.$store.state.companies].sort((a, b) => {
                    const a_temp = a.name ? a.name.toLowerCase() : ''
                    const b_temp = b.name ? b.name.toLowerCase() : ''

                    if (b_temp > a_temp) {
                        return -1
                    } else {
                        return 1
                    }
                })
            }
        },
        methods: {
            closeEditCompany() {
                this.toggleScrollBlock();
                this.showEditCompany = false
                this.selectedCompany = {}
            },
            closeEditCompanyThenRefresh() {
                this.closeEditCompany()
                this.$store.dispatch('getData')
            },
            openNewCompany(e, company = {}) {
                this.openEditCompany(company)
            },
            openEditCompany(company) {
                this.toggleScrollBlock()

                if (this.showEditCompany) {
                    this.closeEditCompany()
                }

                this.selectedCompany = company
                this.showEditCompany = true
            }
        },
        props: {
            companies: Array,
            toggleScrollBlock: Function
        }
    }
</script>