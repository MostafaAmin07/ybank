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
//   methods: {
//     getCookie(cname: string): string {
//       var name = cname + "=";
//       var ca = document.cookie.split(';');
//       for(var i = 0; i < ca.length; i++) {
//         var c = ca[i];
//         while (c.charAt(0) == ' ') {
//           c = c.substring(1);
//         }
//         if (c.indexOf(name) == 0) {
//           return c.substring(name.length, c.length);
//         }
//       }
//       return "";
//     },
</script>
