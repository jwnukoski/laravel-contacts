<template>
    <div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ contact.first_name }} {{ contact.last_name }} {{ contact.suffix }}</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="firstname"></label>
                            <input type="text" class="form-control" id="firstname" placeholder="First name" v-model="contact.first_name">
                        </div>
                        <div class="form-group">
                            <label for="lastname"></label>
                            <input type="text" class="form-control" id="lastname" placeholder="Last name" v-model="contact.last_name">
                        </div>
                        <div class="form-group">
                            <label for="suffix"></label>
                            <input type="text" class="form-control" id="suffix" placeholder="Suffix" v-model="contact.suffix">
                        </div>

                        <JobInfo :contact="contact" v-if="contact.id"/>
                        
                        <Addresses :contact="contact" v-if="contact.id"/>

                        <Emails :contact="contact" v-if="contact.id"/>

                        <Phones :contact="contact" v-if="contact.id"/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" @click="deleteContact" v-if="contact.id">Delete</button>

                    <button type="button" class="btn btn-success" @click="saveContact">Save</button>

                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="closeEditContact">Close</button>
                </div>
            </div>    
        </div>
        <div class="dark-bkg" @click="closeEditContact"></div>
    </div>
</template>

<script>
    import axios from 'axios'
    
    import JobInfo from './JobInfo'
    import Addresses from './Addresses'
    import Emails from './Emails'
    import Phones from './Phones'

    export default {
        name: 'EditContact',
        components: {
            Addresses,
            Emails,
            JobInfo,
            Phones
        },
        methods: {
            closeEditContact() {
                this.$emit('close')
            },
            deleteContact() {
                return axios.delete(`/api/contact/${this.contact.id}`).then(response => {
                    if (response.status === 200) {
                        return true
                    }

                    throw new Error('Error deleting record')
                }).then(() => {
                   this.$emit('close-and-refresh') 
                }).catch(error => {
                    alert('Failed to delete record!')
                })
            },
            async saveContact() {
                const isNewContact = !this.contact.id
                let hadErrors = false
                
                if (isNewContact) {
                    const newContactResponse = await this.basicSave(`/api/contact`, this.contact)
                    console.log(newContactResponse)
                    if (newContactResponse.status !== 200) {
                        hadErrors = true
                        window.alert('First and last name are required for a new contact')
                    } else {
                        this.contact.id = newContactResponse.data.id
                    }
                }

                if (!isNewContact) {
                    const contactResponse = await this.basicSave(`/api/contact/update/${this.contact.id}`, this.contact)
                    if (contactResponse.status !== 200) {
                        hadErrors = true
                        window.alert('Contact requires a first and last name')
                    }

                    const positionResponse = await this.basicSave('/api/position/update/contact', this.contact)
                    if (positionResponse.status !== 200) {
                        hadErrors = true
                        window.alert('Position doesnt meet requirements')
                    }

                    if (this.contact.addresses.length > 0) {
                        const addressResponse = await this.basicSave('/api/address/update/all', this.contact.addresses)
                        if (addressResponse.status !== 200) {
                            hadErrors = true
                            window.alert('Address doesnt meet requirements')
                        }
                    }

                    if (this.contact.phones.length > 0) {
                        const phoneResponse = await this.basicSave('/api/phone/update/all', this.contact.phones)
                        if (phoneResponse.status !== 200) {
                            hadErrors = true
                            window.alert('Phone doesnt meet requirements')
                        }
                    }

                    if (this.contact.emails.length > 0) {
                        const emailResponse = await this.basicSave('/api/email/update/all', this.contact.emails)
                        if (emailResponse.status !== 200) {
                            hadErrors = true
                            window.alert('Email doesnt meet requirements')
                        }
                    }
                }

                if (!hadErrors) {
                    this.$emit('close-and-refresh')
                }
            },
            async basicSave(url, data) {
                return axios.post(url, data).then(response => {
                    if (response.status === 200) {
                        return response
                    } else {
                        throw new Error(`Response: ${response.status}`)
                    }
                }).catch(error => {
                    console.error(error)
                    return error
                })
            }
        },
        props: {
            contact: Object
        }
    }
</script>

<style scoped>
    .dark-bkg {
        position: fixed;
        background-color: rgba(0, 0, 0, 0.5);
        width: 100vw;
        height: 100vh;
        left: 0;
        top: 0;
        z-index: 20;
    }
    .modal-dialog {
        position: fixed;
        width: 75vw;
        max-width: 100vw;
        top: 0;
        left: 12.5vw;
        z-index: 30;
    }
    .modal-content {
        max-height: 75vh !important;
        overflow-y: auto;
        overflow-x: auto;
    }
</style>