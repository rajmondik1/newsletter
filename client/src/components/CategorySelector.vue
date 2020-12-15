<template>
  <b-dropdown aria-role="list">
    <button class="button is-primary" slot="trigger" slot-scope="{ active }">
      <span>{{ getCategory ? getCategory : 'Select category'}}</span>
      <b-icon :icon="active ? 'menu-up' : 'menu-down'"></b-icon>
    </button>

    <b-dropdown-item @click="setCategory(category)" aria-role="listitem" v-for="category in getCategories" :key="category">{{ category }}</b-dropdown-item>
  </b-dropdown>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
  name: "CategorySelector",
  methods: {
    ...mapActions(['fetchCategories', "modifyCategory"]),
    setCategory: function (category) {
      this.selectedCategory = category;
      this.modifyCategory(category);
    }
  },
  computed: {
    ...mapGetters(['getCategories', "getCategory"]),
  },
  created() {
    this.fetchCategories();
  },
}
</script>

<style scoped>

</style>