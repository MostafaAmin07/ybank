import { Module, VuexModule, Mutation, Action } from 'vuex-module-decorators'

// import axios from "axios";
import { AxiosResponse, AxiosError } from "axios";

import { $axios } from '~/utils/api';
import { AccountState } from "@/models/AccountState.d.ts";
import { Account } from "@/models/Account.d.ts";
import { Transaction } from "@/models/Transaction.d.ts";

@Module({
  stateFactory: true,
})
export default class AccountModule extends VuexModule {
  accountState: AccountState = {
    account: null,
    transactions: []
  };

  isFetchingData: boolean = true;

  get account(): Account | null {
    return this.accountState.account;
  }

  get transactions(): Transaction[] {
    return this.accountState.transactions;
  }

  get isLoading(): boolean {
    return this.isFetchingData;
  }

  @Mutation
  setAccountDetails(account: Account) {
    this.accountState = { ...this.accountState, account };
  }

  @Mutation
  setAccountTransactionsDetails(transactions: Transaction[]) {
    this.accountState = { ...this.accountState, transactions };
  }

  @Mutation
  clearAccountData() {
    this.accountState = { account: null, transactions: [] };
  }

  @Mutation
  setFetchingData(isFetching: boolean) {
    this.isFetchingData = isFetching;
  }

  @Action
  async fetchAllAccountDetails(id: number) {
    this.context.commit('setFetchingData', true);
    await this.context.dispatch('fetchAccount', id);
    await this.context.dispatch('fetchTransactions', id);
    this.context.commit('setFetchingData', false);
  }

  @Action
  async fetchAccount(id: number) {
    await $axios.get('accounts/' + id).then((response: AxiosResponse) => {
      this.context.commit('setAccountDetails', response.data.data);
    }).catch((error: AxiosError) => {
      location.href = "/";
    });
  }

  @Action
  async fetchTransactions(id: number) {
    await $axios.get('accounts/' + id + '/transactions').then((response: AxiosResponse) => {
      let transactions = response.data.data;
      for (let i = 0; i < transactions.length; i++) {
        transactions[i].amount =
          (this.context.getters['account'].currency === "usd" ? "$" : "€") +
          transactions[i].amount;

        if (this.context.getters['account'].id != transactions[i].to) {
          transactions[i].amount = "-" + transactions[i].amount;
        }
      }
      this.context.commit('setAccountTransactionsDetails', transactions);
    });
  }

  @Action
  logout() {
    this.context.commit('clearAccountData');
  }
}
