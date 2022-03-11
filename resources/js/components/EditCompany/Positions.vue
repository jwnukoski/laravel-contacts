<template>
    <div>
        <div class="form-group positions" v-if="positions && department.id">
            <h5>Positions:</h5>

            <Position v-for="position in positions"
                :key="position.id" :position="position" :department="department">
            </Position>

            <button type="button" class="btn btn-success" @click="newPosition">New {{ department.name }} position</button>

            <div v-if="positions.length <= 0">No positions for this department</div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import Position from './Position'

    export default {
        name: 'Positions',
        components: {
            Position
        },
        created() {
            this.getPositions()
        },
        data() {
            return {
                positions: []
            }
        },
        methods: {
            newPosition() {
                this.positions.push({
                    id: null,
                    department_id: this.department.id,
                    title: null,
                    is_liason: false
                })
            },
            savePositions() {
                axios.post('/api/position/update/all', this.positions).then(response => {
                    if (response.status === 200) {
                        this.$emit('refresh')
                        return true
                    }
                    
                    throw new Error(response.status)
                }).catch(error => {
                    console.error(error)
                })
            },
            getPositions() {
                if (this.department.id === null) {
                    return
                }

                axios.get(`/api/department/positions/${this.department.id}`).then(response => {
                    this.positions = response.data
                }).catch(error => {
                    console.error(error)
                })
            }
        },
        props: {
            department: Object
        }
    }
</script>

<style lang="scss" scoped>
    .positions {
        margin-left: 1em;
    }
</style>