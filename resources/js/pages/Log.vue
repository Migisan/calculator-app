<template>
  <div>
    <div class="log">
      <template v-if="logs.length">
        <p>{{ current_page }} / {{ last_page }} ページ目</p>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>計算結果</th>
              <th>保存日時</th>
              <th>削除ボタン</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(log, key) in logs" :key="key">
              <td>{{ log.id }}</td>
              <td>{{ Number(log.result) }}</td>
              <td>{{ log.created_at }}</td>
              <td><button @click="del(log.id)" class="btn btn-danger">削除</button></td>
            </tr>
          </tbody>
        </table>
        <div class="pagination">
          <button v-if="!isFirstPage" @click="changePage(-1)" class="btn btn-success">前へ</button>
          <button v-if="!islastPage" @click="changePage(+1)" class="btn btn-success">次へ</button>
        </div>
      </template>
      <p v-else>計算結果ログはまだ存在しません。</p>
    </div><!-- log -->
  </div>
</template>

<script>
const axios = require('axios')

export default {
  data: function() {
    return {
      logs: [],
      current_page: 0,
      last_page: 0,
    }
  },
  mounted: function() {
    this.getLogs()
  },
  methods: {
    /**
     * ログ一覧取得
     */
    getLogs: function() {
      axios.get('/api/logs?page=' + this.current_page).then(res => {
        console.log(res)
        this.logs = res.data.data
        this.current_page = res.data.current_page
        this.last_page = res.data.last_page
      }).catch(e => {
        console.log(e)
      })
    },
    /**
     * ログ削除
     */
    del: function(id) {
      if(!window.confirm('本当に削除しますか？')) {
        return false;
      }
      axios.delete('/api/logs/' + id).then(res => {
        console.log(res)
        if(res.data.res === "success") {
          alert('データを削除しました。')
          this.getLogs()
        } else {
          alert('データの削除に失敗しました。')
        }
      }).catch(e => {
        console.log(e)
        alert('データの削除に失敗しました。')
      })
    },
    /**
     * ページ変更
     */
    changePage: function(page) {
      this.current_page = this.current_page + page
      this.getLogs()
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
  }
}
</script>