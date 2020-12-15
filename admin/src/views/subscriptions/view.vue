<template>
  <div class="app-container">
    <el-form ref="form" :model="form" label-width="120px">
      <el-form-item label="Category">
        <el-select v-model="form.category" placeholder="Select category">
          <el-option v-for="category in categories" :label="category" :value="category" />
        </el-select>
      </el-form-item>
      <el-form-item label="Email">
        <el-input v-model="form.email" />
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">Save</el-button>
        <el-button @click="onCancel">Cancel</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import {getCategories, getSubscription, putSubscription} from '@/api/subscription'

export default {

  props: {
    id: String
  },
  data() {
    return {
      form: {
        email: '',
        category: '',
      },
      categories: []
    }
  },
  created() {
    this.fetchSubscription();
  },
  methods: {
    fetchSubscription() {
      getSubscription(this.id).then(res => {
        console.log(res);
        this.form.email = res.data.email;
        this.form.category = res.data.category;
      })
      getCategories().then(response => {
        this.categories = response.data
      })
    },
    onSubmit() {
      // call to put
      putSubscription({ id: this.id, email: this.form.email, category: this.form.category }).then( res => {
        console.log(res);
        if (res.status === 200) {
          this.goBack()
          this.$message('Subscription saved!')
        } else {
          this.$message({
            message: 'Server error',
            type: 'error'
          })
        }
      })
    },
    onCancel() {
      this.goBack()
    },
    goBack() {
      this.$router.push({ name: 'subscription-list'});
    }
  }
}
</script>

<style scoped>
 div.app-container {
   width: 50%;
 }
</style>
