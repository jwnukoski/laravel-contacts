<template>
    <div class="form-group" v-if="contact.phones">
        <h5>Phone Numbers:</h5>

        <Phone v-for="phone in contact.phones"
            :phone="phone" :key="phone.id" :contact_id="contact.id">
        </Phone>

        <button type="button" class="btn btn-success" @click="newPhone">New phone</button>

        <div v-if="contact.phones.length <= 0">No phones for this contact</div>
    </div>
</template>

<script>
    import Phone from './Phone'

    export default {
        name: 'Address',
        components: {
            Phone
        },
        methods: {
            newPhone() {
                this.contact.phones.push({
                    id: null,
                    contact_id: this.contact.id,
                    number: '',
                    is_business: false
                })
            }
        },
        props: {
            contact: Object
        }
    }
</script>