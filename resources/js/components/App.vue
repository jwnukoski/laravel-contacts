<template>
    <div class="container">
        <Header @toggleContactsPage="toggleContactsPage"/>

        <main>
            <router-view v-if="!this.$store.state.loading" :toggleScrollBlock="toggleScrollBlock"></router-view>
        </main>

        <div v-if="this.$store.state.loading" class="spinner-border" role="status"></div>
    </div>
</template>

<script>
    import Header from './Header'
    import Contacts from './Contacts.vue'
    import Companies from './Companies.vue'

    export default {
        name: 'App',
        components: {
            Header,
            Contacts,
            Companies
        },
        created() {
            this.$store.dispatch('getData')
        },
        methods: {
            toggleScrollBlock() {
                this.scrollDisabled = !this.scrollDisabled
                document.body.className = this.scrollDisabled ? 'stopOverflow' : ''
            },
            toggleContactsPage() {
                this.isContactsPage = !this.isContactsPage
            }
        }
    }
</script>

<style>
    .spinner-border {
        position: fixed;
        left: 50vw;
        top: 50vh;
        z-index: 5;
    }
    .stopOverflow {
        overflow-x: hidden !important;
        overflow-y: hidden !important;
    }
    main {
        padding-top: 8em;
    }
</style>
