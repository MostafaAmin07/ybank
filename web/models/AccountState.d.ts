import { Account } from './Account';
import { Transaction } from "./Transaction";

export interface AccountState {
  account: Account | null;
  transactions: Transaction[];
}
