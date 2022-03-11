<template>
    <div v-if="visible" class="py-1">
        <button type="button" class="btn btn-secondary" @click="toggleFullAddress">{{ address.line_1 }}</button>
        <div v-if="fullAddressVisible" class="fullAddress">
            <div><label>Line 1:</label><input type="text" v-model="address.line_1"></div>

            <div><label>Line 2:</label><input type="text" v-model="address.line_2"></div>

            <div><label>City:</label><input type="text" v-model="address.city"></div>

            <div><label>State:</label><input type="text" v-model="address.state"></div>

            <div><label>Zip:</label><input type="text" v-model="address.zip" @input="zipLookup"></div>

            <div><label>Business:</label><input type="checkbox" v-model="address.is_business" :true-value="true" :false-value="false"></div>

            <div>
                <a 
                    v-if="address.line_1 && ((address.city && address.state) || (address.zip))" 
                    :href="`https://google.com/maps/place/${address.line_1} ${address.line_2 || ''} ${address.city || ''} ${address.state || ''} ${address.zip || ''}`" 
                    target="_blank">
                    Map
                </a>
            </div>

            <div><button type="button" @click="setAddressForDelete" class="btn btn-danger ml-2">Delete</button></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Address',
        created() {
            
        },
        data() {
            return {
                isNew: false,
                fullAddressVisible: false,
                visible: true,
                cachedZip: null
            }
        },
        methods: {
            setAddressForDelete: function() {
                this.toggleFullAddress()
                this.visible = false
                this.address.contact_id = null;
            },
            toggleFullAddress: function() {
                this.fullAddressVisible = !this.fullAddressVisible
            },
            zipLookup: function() {
                if (this.address.zip && this.address.zip.length === 5) {
                    axios.get(`/api/address/ziplookup/${Number(this.address.zip)}`).then(response => {
                        const zip = response.data[0].zipcodes[0]
                        const city = zip.default_city;
                        const state = zip.state;

                        // move to emit
                        this.address.city = city
                        this.address.state = state
                    }).catch(error => { console.error(error) })
                }
            }
        },
        props: {
            contact_id: Number,
            address: Object
        }
    }
</script>

<style lang="scss" scoped>
    .fullAddress {
        label, input {
            display: block;
        }

        div {
            display: inline-block;
            width: 49%;
        }

        padding: 1em;
    }
</style>