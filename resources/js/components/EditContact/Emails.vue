<template>
    <div class="form-group" v-if="contact.emails">
        <h5>Emails:</h5>

        <Email v-for="email in contact.emails"
            :email="email" :key="email.id" :contact_id="contact.id">
        </Email>

        <button type="button" class="btn btn-success" @click="newEmail">New email</button>

        <div v-if="contact.emails.length <= 0">No emails for this contact</div>
    </div>
</template>

<script>
    import Email from './Email'

    export default {
        name: 'Emails',
        components: {
            Email
        },
        methods: {
            newEmail() {
                this.contact.emails.push({
                    id: null,
                    contact_id: this.contact.id,
                    address: '',
                    is_business: false
                })
            }
        },
        props: {
            contact: Object
        }
    }
</script>