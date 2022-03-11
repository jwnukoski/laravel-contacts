<template>
    <div class="form-group" v-if="position && visible">
        <label>Title:</label><input type="text" v-model="position.title"/>
        <button type="button" @click="deletePosition" class="btn btn-danger">X</button>
    </div>
</template>

<script>
    export default {
        name: 'Position',
        components: {
        },
        created() {
            
        },
        data() {
            return {
                visible: true
            }
        },
        methods: {
            deletePosition() {
                this.visible = false
                this.position.department_id = null
            }
        },
        props: {
            position: Object
        }
    }
</script>