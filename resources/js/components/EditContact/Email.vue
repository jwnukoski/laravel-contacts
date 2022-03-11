<template>
    <div v-if="visible" class="py-1">
        <input type="text" v-model="email.address"/><button type="button" @click="deleteEmail" class="btn btn-danger ml-2">Delete</button>
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
            deleteEmail() {
                this.visible = false
                this.email.contact_id = null
            }
        },
        props: {
            contact_id: Number,
            email: Object
        }
    }
</script>