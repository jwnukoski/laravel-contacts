<template>
    <div class="form-group" v-if="visible">
        <input type="text" v-model="department.name"/>
        <button type="button" @click="deleteDepartment" class="btn btn-danger">X</button>
        <Positions :department="department" @savedPositions="$emit('refresh')" ref="positions"/>
    </div>
</template>

<script>
    import Positions from './Positions.vue'

    export default {
        name: 'Department',
        components: {
            Positions        
        },
        data() {
            return {
                visible: true
            }
        },
        methods: {
            deleteDepartment() {
                this.department.company_id = null
                this.visible = false
            },
            savePositions() {
                this.$refs.positions.savePositions()
            }
        },
        props: {
            department: Object,
            company: Object
        }
    }
</script>