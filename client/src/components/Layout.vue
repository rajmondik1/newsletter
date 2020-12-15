<template>
  <section>
    <div class="columns">
      <div class="column is-12 is-12-desktop">
        <Title title="Subscribe to newsletter"
               subtitle="Select category and input your email to get latest newsletters on your selected category"/>
      </div>
    </div>
    <div class="columns">
      <div class="column is-half is-offset-one-quarter">
        <CategorySelector/>
      </div>
    </div>
    <div class="columns">
      <div class="column is-half is-offset-one-quarter">
        <EmailInput/>
        <b-button icon-pack="far" icon-left="envelope" size="is-medium" type="is-primary" outlined :disabled="!isValid"
                  @click="submit">Subscribe to newsletter!
        </b-button>
      </div>
    </div>
  <b-loading :is-full-page="true" :active="getLoading"></b-loading>
  </section>
</template>
<!-- Add loader and success message  -->
<script>
import Title from "@/components/Title";
import EmailInput from "@/components/EmailInput";
import CategorySelector from "@/components/CategorySelector";
import {mapActions, mapGetters} from "vuex";

export default {
  name: "Layout",
  data() {
    return {
      isDisabled: true,
    }
  },
  components: {
    CategorySelector,
    Title,
    EmailInput
  },
  computed: {
    ...mapGetters(['isValid', 'getLoading', 'getSuccessMsg']),
  },
  methods: {
    ...mapActions(['subscribe']),
    async submit() {
      await this.subscribe();
      await this.success()
    },
    success() {
      this.$buefy.notification.open({
        message: 'Successfully subscribed!',
        type: 'is-success'
      })
    },
  },
}
</script>

<style scoped>
section {
  padding-top: 10%;
}
</style>