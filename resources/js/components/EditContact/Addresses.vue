<template>
    <div class="form-group" v-if="contact.addresses">
        <h5>Addresses:</h5>

        <Address v-for="address in contact.addresses"
            :address="address" :key="address.id" :contact_id="contact.id">
        </Address>

        <button type="button" class="btn btn-success" @click="newAddress">New address</button>

        <div v-if="contact.addresses.length <= 0">No addresses for this contact</div>
    </div>
</template>

<script>
    import Address from './Address'

    export default {
        name: 'Addresses',
        components: {
            Address
        },
        methods: {
            newAddress() {
                this.contact.addresses.push({
                    id: null,
                    contact_id: this.contact.id,
                    line_1: 'New Address',
                    line_2: '',
                    city: '',
                    state: '',
                    zip: '',
                    is_business: 0
                })
            }
        },
        props: {
            contact: Object
        }
    }
</script>