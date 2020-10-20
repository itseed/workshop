<template>
  <div>
    <b-alert show dismissible fade variant="danger">{{ message }}</b-alert>
  </div>
</template>

<script>
export default {
  name: 'Notification',
  props: ['message']
}
</script>