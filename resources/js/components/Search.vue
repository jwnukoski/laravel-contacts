<template>
  <div class="right" v-if="$route.path != '/companies'">
    <form class="navbar-form navbar-right" @submit.prevent>
      <input
        class="form-control mr-sm-2"
        type="text"
        placeholder="Search"
        aria-label="Search"
        v-model="searchOptions.terms"
        v-on:input="searchContacts(searchOptions.terms)"
      />
    </form>

    <div class="searchFilters">
      <button
        type="button"
        @click="filtersVisible = !filtersVisible"
        class="btn btn-primary"
      >
        {{ filtersVisible ? "Hide search filters" : "Search Filters" }}
      </button>
      <form class="filterForm" v-if="filtersVisible" @submit.prevent>
        Search on...
        <label for="first_names">First names:</label>
        <input
          id="first-names"
          type="checkbox"
          v-model="searchOptions.fields.first_name"
          :true-value="true"
          :false-value="false"
          @change="searchContacts(searchOptions.terms)"
        />
        <label for="last_names">Last names:</label>
        <input
          id="Last names:"
          type="checkbox"
          v-model="searchOptions.fields.last_name"
          :true-value="true"
          :false-value="false"
          @change="searchContacts(searchOptions.terms)"
        />
        <label for="suffixes">Suffixes:</label>
        <input
          id="suffixes"
          type="checkbox"
          v-model="searchOptions.fields.suffix"
          :true-value="true"
          :false-value="false"
          @change="searchContacts(searchOptions.terms)"
        />
        <label for="positions">Positions:</label>
        <input
          id="positions"
          type="checkbox"
          v-model="searchOptions.fields.position"
          :true-value="true"
          :false-value="false"
          @change="searchContacts(searchOptions.terms)"
        />
        <label for="departments">Departments:</label>
        <input
          id="departments"
          type="checkbox"
          v-model="searchOptions.fields.department"
          :true-value="true"
          :false-value="false"
          @change="searchContacts(searchOptions.terms)"
        />
        <label for="companies">Companies:</label>
        <input
          id="companies"
          type="checkbox"
          v-model="searchOptions.fields.company"
          :true-value="true"
          :false-value="false"
          @change="searchContacts(searchOptions.terms)"
        />
        <label for="liasons">Only liasons:</label>
        <input
          id="liasons"
          type="checkbox"
          v-model="searchOptions.fields.liasons_only"
          :true-value="true"
          :false-value="false"
          @change="searchContacts(searchOptions.terms)"
        />
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "Search",
  components: {},
  data() {
    return {
      filtersVisible: false,
      searchOptions: {
        terms: "",
        fields: {
          first_name: true,
          last_name: true,
          suffix: true,
          position: true,
          department: true,
          company: true,
          liasons_only: false,
        },
      },
    };
  },
  methods: {
    searchContacts(search = this.searchOptions.terms, fields = this.searchOptions.fields) {
      const regex = new RegExp(search.split(" ").join("|"), "gi");
      const contacts = [...this.$store.state.contacts];

      for (const contact of contacts) {
        if (!contact) {
          continue;
        }

        let show = false;

        if (contact.first_name && fields.first_name && !show) {
          show = Boolean(contact.first_name.match(regex));
        }
        if (contact.last_name && fields.last_name && !show) {
          show = Boolean(contact.last_name.match(regex));
        }
        if (contact.suffix && fields.suffix && !show) {
          show = Boolean(contact.suffix.match(regex));
        }
        if (contact.position && fields.position && !show) {
          show = Boolean(contact.position.title.match(regex));
        }
        if (contact.position && fields.department && !show) {
          show = Boolean(contact.position.department.name.match(regex));
        }
        if (contact.position && fields.company && !show) {
          show = Boolean(contact.position.department.company.name.match(regex));
        }
        if (fields.liasons_only && show) {
          show = contact.position ? Boolean(contact.position.is_liason) : false;
        }

        contact.visible = show;
      }

      this.$store.commit("setContacts", contacts);
    },
  }
};
</script>

<style lang="scss" scoped>
  .searchFilters {
    button {
      float: right;
      display: block;
      text-align: right;
    }
    .filterForm {
      color: white;
    }
  }
</style>