<template>
  <div>
    <Header />
    <main>
      <RouterView />
    </main>
  </div>
</template>

<script>
import Header from './components/HeaderComponent.vue'

export default {
  components: {
    Header,
  },
}
</script>