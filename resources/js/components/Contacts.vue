<template>
    <div>
        <header class="d-flex justify-content-between">
            <h1>Contacts</h1>
            <div></div>
            <button class="float-right btn btn-success" @click="openNewContact">New contact</button>
        </header>

        <EditContact :contact="selectedContact" :companies="companies" 
        v-if="showEditContact" @close="closeEditContact" @close-and-refresh="closeEditContactThenRefresh"/>
        
        <div class="overflow-auto">
            <div class="d-flex justify-content-center">
                <b-pagination
                class="paginationControls"
                v-model="table.currentPage"
                :total-rows="tableRows"
                :per-page="table.perPage"
                aria-controls="my-table"
                ></b-pagination>
            </div>

            <b-table
            responsive
            hover
            @row-dblclicked="openEditContact"
            id="my-table"
            :items="contacts"
            :per-page="table.perPage"
            :current-page="table.currentPage"
            small
            :fields="table.fields"
            ></b-table>

            <div class="d-flex justify-content-center">
                <b-pagination
                class="paginationControls"
                v-model="table.currentPage"
                :total-rows="tableRows"
                :per-page="table.perPage"
                aria-controls="my-table"
                ></b-pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import Contact from './Contact'
    import EditContact from './EditContact/EditContact.vue'

    export default {
        name: 'Contacts',
        components: {
            Contact,
            EditContact
        },
        computed: {
            tableRows() {
                return this.contacts.length
            },
            contacts() {
                return this.$store.state.contacts.filter((contact) => {
                    return contact.visible
                });
            }
        },
        data() {
            return {
                table: {
                    perPage: 25,
                    currentPage: 1,
                    fields: [{ key: 'first_name', sortable: true, label: 'First Name' },
                                { key: 'last_name', sortable: true, label: 'Last Name' },
                                { key: 'suffix', sortable: true, label: 'Suffix' },
                                { key: 'position.title', sortable: true, label: 'Position' },
                                { key: 'position.department.name', sortable: true, label: 'Department' },
                                { key: 'position.department.company.name', sortable: true, label: 'Company' }]
                },
                showEditContact: false,
                selectedContact: {}
            }
        },
        methods: {
            closeEditContact() {
                this.toggleScrollBlock();
                this.showEditContact = false
                this.selectedContact = {}
            },
            closeEditContactThenRefresh() {
                this.closeEditContact()
                this.$store.dispatch('getData')
            },
            openNewContact(e, contact = {}) {
                this.openEditContact(contact)
            },
            openEditContact(contact) {
                this.toggleScrollBlock()

                if (this.showEditContact) {
                    this.closeEditContact()
                }

                this.selectedContact = contact
                this.showEditContact = true
            }
        },
        props: {
            companies: Array,
            toggleScrollBlock: Function
        }
    }
</script>
