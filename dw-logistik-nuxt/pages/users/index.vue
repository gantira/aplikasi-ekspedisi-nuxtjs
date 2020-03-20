<!-- /pages/users/index.vue -->

<template>
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">
          <!-- TOMBOL YANG KETIKA DIKLIK AKAN DIARAHKAN KE HALAMAN ADD USER -->
          <nuxt-link class="btn btn-primary float-right btn-sm" :to="{name: 'users-add'}">Add New</nuxt-link>
        </h4>
      </div>
      <div class="card-body">
        <!-- TAG BOOTSTRAP VUE UNTUK TABLE, DIMANA ITEMS ADALAH DATA YANG AKAN DITAMPILKAN, DAN FIELDS AKAN MENJADI HEADER DARI TABLE -->
        <b-table striped hover :items="users.data" :fields="fields" show-empty>
          <!-- MEMBUAT CUSTOM DATA YANG AKAN DI-RENDER DI DALAM KOLOM NAME -->
          <template v-slot:cell(name)="row">
            <p>
              <strong>{{ row.item.name }}</strong>
            </p>
            <p>
              ID:
              <span class="badge badge-success">{{ row.item.identity_id }}</span>
              <br />Gender:
              <span class="badge badge-success">{{ row.item.gender ? 'Male':'Female' }}</span>
            </p>
          </template>
        </b-table>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
  //KETIKA PAGE DILOAD, MAKA FUNGSI INI AKAN DIJALANKAN SECARA OTOMATIS
  //DIMANA KITA MEMANGGIL FUNGSI GETUSERSDATA DARI STORE USER
  async asyncData({ store }) {
    await Promise.all([store.dispatch("user/getUsersData")]);
    return;
  },
  data() {
    return {
      //FIELD UNTUK MENJADI HEADER TABLE
      fields: ["name", "address", "email", "phone_number"],
      items: []
    };
  },
  computed: {
    //SETIAP REQUEST KE API, DATANYA AKAN DISIMPAN KE DALAM STATE YANG ADA DIMASING-MASING MODULE STORE VUEX
    //DALAM HAL INI, DATA USER AKAN DISIMPAN KE DALAM STATE USERS, DI DALAM MODULE USER ATAU USER.JS YANG ADA DI DALAM FOLDER STORE
    ...mapState("user", {
      users: state => state.users
    })
  },
  methods: {
    ...mapActions("user", ["getUsersData"])
  }
};
</script>