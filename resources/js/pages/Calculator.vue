<template>
  <div>
    <div class="calculator">
      <div class="top">
        <span>{{ output }}</span>
      </div>
      <ul v-for="(row, rowKey) in items" :key="rowKey" class="items">
        <li v-for="(item, itemKey) in row" :key="itemKey" class="item">
          <button @click="calc(item)">{{ item }}</button>
        </li>
      </ul>
      <button @click="result" class="result btn btn-warning">=</button>
      <button @click="store" class="store btn btn-success" id="store" disabled>保存</button>
    </div><!-- calculator -->
  </div>
</template>

<script>
const axios = require('axios')

export default {
  data: function() {
    return {
      formula: '',
      output: '',
      items: [
        ['7', '8', '9', '/'],
        ['4', '5', '6', '*'],
        ['1', '2', '3', '-'],
        ['0', '.', 'C', '+']
      ],
    }
  },
  methods: {
    calc: function(item) {
      // バリデーション
      if(this.output === '') {
        if(item === '.' || item === '0' || item === '/' || item === '*'){
          return
        }
      }

      let last = this.output.slice(-1)
      if(last === '.' || last === '+' || last === '-' || last === '*' || last === '/') {
        if(item === '.' || item === '+' || item === '-' || item === '*' || item === '/') {
          return
        }
      }

      let last_two = this.output.slice(-2, -1)
      if(item === '0' && last === '0') {
        if(last_two === '' || last_two === '.' || last_two === '+' || last_two === '-' || last_two === '*' || last_two === '/') {
          return
        }
      }

      // 計算
      if(item === 'C') {
        this.formula = ''
        this.output = ''
      }else {
        this.output += item
      }

      // 保存ボタン無効化
      document.getElementById('store').disabled = true
    },
    result: function() {
      // バリデーション
      if(this.output === '') {
        return
      }

      // 計算
      this.formula = this.output
      this.output = String(eval(this.output))

      // 保存ボタン有効化
      document.getElementById('store').disabled = false
    },
    store: function() {
      // バリデーション
      let formula_len = this.formula.length
      let output_array = this.output.toString().split('.')
      let is_decimal = output_array[1] ? true : false
      let store_flag = false

      if(formula_len <= 0 || formula_len > 255) {
        alert('計算式の長さは255文字以下にしてください。')
        return
      }
      if(is_decimal) {
        let number_len = output_array[0].length + output_array[1].length
        let decimal_len = output_array[1].length
        store_flag = (number_len <= 8) && (decimal_len <= 2) ? true : false
        if(!store_flag) {
          alert('有効桁数8桁かつ小数点以下2桁までの小数点数しか保存できません。')
          return
        }
      } else {
        let number_len = output_array[0].length
        store_flag = number_len <= 6 ? true : false
        if(!store_flag) {
          alert('有効桁数6桁までの整数しか保存できません。')
          return
        }
      }

      // 登録処理
      axios.post('/api/logs/store', {formula: this.formula, result: this.output}).then(res => {
        console.log(res)
        if(res.data.res === "success") {
          alert('計算結果を保存しました。')
          // リセット
          this.formula = ''
          this.output = ''
          document.getElementById('store').disabled = true
        } else {
          alert('計算結果の保存に失敗しました。')
        }
      }).catch(e => {
        console.log(e)
        alert('計算結果の保存に失敗しました。')
      })
    }
  }
}
</script>