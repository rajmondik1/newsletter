<template>
  <div class="app-container">
    <el-container style="margin: 10px">

      <el-select v-model="category" placeholder="Select newsletter category">
        <el-option label="All categories" value=""/>
        <el-option v-for="category in categories" :label="category" :value="category"/>
      </el-select>
    </el-container>

    <el-table
      v-loading="listLoading"
      :data="list"
      element-loading-text="Loading"
      border
      fit
      highlight-current-row
      @sort-change="sort"
    >
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          {{ scope.$index }}
        </template>
      </el-table-column>
      <el-table-column label="Email" prop="email" align="center" sortable="custom">
        <template slot-scope="scope">
          <span>{{ scope.row.email }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Category" prop="category" align="center" sortable="custom">
        <template slot-scope="scope">
          {{ scope.row.category }}
        </template>
      </el-table-column>
      <el-table-column label="Actions">
        <template slot-scope="scope">
          <router-link :to="{ name: 'subscription-view', params: { id: scope.row.id }}">
            <el-button size="mini">
              <svg-icon icon-class="edit"/>
            </el-button>
          </router-link>
          <el-button size="mini" type="danger" @click="remove(scope.row.id)">
            <svg-icon icon-class="trash"/>
          </el-button>

        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import {getCategories, getList, removeSubscription} from '@/api/subscription'

export default {
  data() {
    return {
      list: null,
      categories: null,
      listLoading: true,
      category: '',
      sortKey: ''
    }
  },
  created() {
    this.fetchData()
  },
  methods: {
    fetchData() {
      this.listLoading = true
      getList().then(response => {
        this.list = response.data
        this.listLoading = false
      })

      getCategories().then(response => {
        this.categories = response.data
      })
    },
    updateList() {
      this.listLoading = true
      getList({category: this.category, order: this.sortKey}).then(response => {
        this.list = response.data
        this.listLoading = false
      })
    },
    remove(id) {
      console.log(id);
      // remove
      removeSubscription(id).then(res => {
        if (res.status === 200) {
          this.$message({
            message: 'Subscription removes',
            type: 'success'
          })
          this.updateList();
        }
      });
    },
    sort(event) {
      let order = '';
      if (event.order === "descending") order = '-'
      if (event.order === "ascending") order = ''
      if (event.order == null) order = ''

      this.sortKey = order + event.prop;
      this.updateList();
    }
  },
  watch: {
    category() {
      this.updateList()
    }
  }
}
</script>
