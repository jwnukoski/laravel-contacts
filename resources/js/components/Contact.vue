<template>
    <tr @click="openContactModal">
        <td>{{ filtered_contact.first_name }}</td>
        <td>{{ filtered_contact.last_name }}</td>
        <td>{{ filtered_contact.suffix }}</td>
        <td>{{ filtered_contact.position_title }}</td>
        <td>{{ filtered_contact.department_name }}</td>
        <td>{{ filtered_contact.company_name }}</td>
    </tr>
</template>

<script>
    export default {
        name: 'Contact',
        
        computed: {
            filtered_contact() {
                const fContact = {
                    first_name: this.contact.first_name || '',
                    last_name: this.contact.last_name || '',
                    suffix: this.contact.suffix || '',
                    position_title: '',
                    department_name: '',
                    company_name: ''
                }
                
                if (this.contact.position) {
                    fContact.position_title = this.contact.position.title
                    fContact.department_name = this.contact.position.department.name
                    fContact.company_name = this.contact.position.department.company.name
                }

                return fContact
            }
        },

        props: {
            contact: Object,
            required: true
        },

        methods: {
            openContactModal() {
                this.$emit('open-contact-modal', this.contact)
            }
        }
    }
</script>

<style scoped>
    .key {
        font-weight: bold;
    }
</style>