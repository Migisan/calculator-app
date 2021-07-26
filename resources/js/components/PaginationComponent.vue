<template>
  <div>
    <div class="pagination">
      <button v-if="!isFirstPage" @click="sendPage(-1)" class="btn btn-success">前へ</button>
      <button v-if="!islastPage" @click="sendPage(+1)" class="btn btn-success">次へ</button>
    </div><!-- pagination -->
  </div>
</template>

<script>
export default {
  props: {
    current_page: {
      type: Number,
      required: true,
    },
    last_page: {
      type: Number,
      required: true,
    },
  },
  methods: {
    sendPage: function(page) {
      this.$emit('catchPage', page)
    }
  },
  computed: {
    /**
     * 先頭ページ判定
     */
    isFirstPage: function() {
      return this.current_page === 1
    },
    /**
     * 末尾ページ判定
     */
    islastPage: function() {
      return this.current_page === this.last_page
    },
  },
}
</script>