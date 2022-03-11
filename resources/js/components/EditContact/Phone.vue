<template>
    <div v-if="visible" class="py-1">
        <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" v-model="phone.number">
        <button type="button" @click="deletePhone" v-if="phone.number" class="btn btn-danger ml-2">Delete</button>
    </div>
</template>

<script>
    export default {
        name: 'Address',
        created() {
            
        },
        data() {
            return {
                visible: true
            }
        },
        methods: {
            deletePhone() {
                this.visible = false
                this.phone.contact_id = null
            }
        },
        props: {
            contact_id: Number,
            phone: Object
        }
    }
</script>