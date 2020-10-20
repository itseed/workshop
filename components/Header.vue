<template>
  <b-navbar toggleable="lg" type="dark" variant="info" fixed="top">
    <b-navbar-brand href="#">Workshop</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <b-nav-item href="/dashboard">Dashboard</b-nav-item>
        <b-nav-item href="#">Customers</b-nav-item>
        <b-nav-item href="#">Users</b-nav-item>
        <b-nav-item-dropdown right>
          <!-- Using 'button-content' slot -->
          <template #button-content>
            Hi, {{ loggedInUser.name }}
          </template>
          <b-dropdown-item href="#">Profile</b-dropdown-item>
          <b-dropdown-item href="#" @click="logout">Sign Out</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters(['loggedInUser'])
  },
  methods: {
    async logout() {
      await this.$auth.logout();
    },
  },
}
</script>