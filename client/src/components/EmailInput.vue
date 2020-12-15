<template>
  <b-field label="Email">
    <b-input type="email"
             :value="getEmail"
             @input="setEmail"
             ref="emailValidation"
             maxlength="30">
    </b-input>
  </b-field>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';

export default {
  name: "EmailInput",
  computed: mapGetters(['getEmail']),
  methods: {
    ...mapActions(['modifyEmail', "modifyValid"]),
    setEmail: function(email) {
      this.modifyEmail(email);
      this.modifyValid(this.validate());
    },
    validate() {
      return this.$refs.emailValidation.checkHtml5Validity();
    }
  },
}
</script>

<style scoped>

</style>