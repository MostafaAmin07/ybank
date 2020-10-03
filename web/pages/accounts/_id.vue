<template>
  <div>
    <div class="container" v-if="isLoading">loading...</div>

    <div class="container" v-if="!isLoading">
      <AccountComponent />

      <TransactionsListComponent />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, namespace } from "nuxt-property-decorator";

import AccountComponent from "../../components/AccountComponent.vue";
import TransactionsListComponent from "../../components/TransactionsListComponent.vue";


const account = namespace('account');
@Component({
  components: {
    AccountComponent,
    TransactionsListComponent
  }
})
export default class AccountPage extends Vue {
  @account.Getter
  public isLoading!: boolean;

  mounted() {
    this.$store.dispatch('account/fetchAllAccountDetails', this.$route.params.id);
  }
}
</script>
