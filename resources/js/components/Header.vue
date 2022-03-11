<template>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="left">
                <a class="navbar-brand" href="/">Contacts DB</a>
                <router-link :to="{ name: 'contacts' }">Contacts</router-link>
                <router-link :to="{ name: 'companies'}">Companies</router-link> 
            </div>

            <Search/>
        </nav>
    </header>
</template>

<script>
    import Search from './Search'

    export default {
        name: 'Header',
        components: {
            Search
        },
        data() {
            return {
                newContactVisible: false
            }
        },
        methods: {
            showNewContactModal() {
                this.newContactVisible = true
            },
            hideNewContactModal() {
                this.newContactVisible = false
            }
        },
        props: {
            searchContacts: Function,
            searchOptions: Object
        }
    }
</script>

<style lang="scss">
    .filterForm {
        color: white;
    }
    .navbar {
        z-index: 10;

        .left {
            float: left;
            width: 50%;

            a {
                margin: 0.25em;
                padding: 0.25em;
                font-weight: bold;
            }
        }
        .right {
            float: right;
            width: 50%;
            
            .searchFilters {
                text-align: right;  
                width: 100%;
                display: block;
                float: right;
            }
        }
        
    }
</style>