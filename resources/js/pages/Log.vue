<template>
  <div>
    <div class="log">
      <template v-if="logs.length">
        <p>{{ current_page }} / {{ last_page }} ページ目</p>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>計算式</th>
              <th>計算結果</th>
              <th>保存日時</th>
              <th>削除ボタン</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(log, key) in logs" :key="key">
              <td>{{ log.id }}</td>
              <td>{{ log.formula }}</td>
              <td>{{ Number(log.result) }}</td>
              <td>{{ log.created_at }}</td>
              <td><button @click="del(log.id)" class="btn btn-danger">削除</button></td>
            </tr>
          </tbody>
        </table>
        <Pagination :current_page="current_page" :last_page="last_page" @catchPage="changePage"></Pagination>
      </template>
      <p v-else>計算結果ログはまだ存在しません。</p>
    </div><!-- log -->
  </div>
</template>

<script>
import Pagination from '../components/PaginationComponent.vue'

const axios = require('axios')

export default {
  components: {
    Pagination,
  },
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
}
</script>