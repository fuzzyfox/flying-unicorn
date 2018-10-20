import Vue from "vue";
import _ from "lodash";
import jQuery from "jquery";
import BootstrapVue from 'bootstrap-vue'

import "bootstrap";

// import router from "./router";
import store from "./store";
import http from "./http";
import "./components";

window.$ = window.jQuery = jQuery;
window._ = _;
window.Vue = Vue;

Vue.use(BootstrapVue);

Vue.config.productionTip = false;
Vue.config.silent = process.env.NODE_ENV === "production";
Vue.config.devtools = process.env.NODE_ENV !== "production";

const app = new Vue({
  el: "#app",
  // router,
  store,
  http,

  created() {
      this.$store.dispatch('init')
  }
});

window.app = app;
