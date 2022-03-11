<template>
    <tr @click="openCompanyModal">
        <td>{{ this.company.name || '' }}</td>
    </tr>
</template>

<script>
    export default {
        name: 'Company',
        methods: {
            openCompanyModal() {
                this.$emit('open-company-modal', this.company)
            }
        },
        props: {
            company: Object
        }
    }
</script>