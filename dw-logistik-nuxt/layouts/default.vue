<template>
  <div id="wrapper">
    <app-sidebar v-if="isAuth"></app-sidebar>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <app-header v-if="isAuth"></app-header>
        <nuxt />
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from "@/components/layouts/Sidebar.vue";
import Header from "@/components/layouts/Header.vue";
import { mapState } from "vuex";

export default {
  data() {
    return {
      // isAuth: false SEHINGGA VARIABLE INI DIDISABLE SAJA ATAU BISA DIHAPUS
    };
  },
  computed: {
    ...mapState(["isAuth"]) //JADI ISAUTH KITA AMBIL DARI STATE INDEX.JSS
  },
  components: {
    "app-sidebar": Sidebar,
    "app-header": Header
  }
};
</script>