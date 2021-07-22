<template>
  <div class="calculator">
    <div class="top">
      <input type="text" v-model="output">
    </div>
    <ul v-for="(row, rowKey) in items" :key="rowKey" class="items">
      <li v-for="(item, itemKey) in row" :key="itemKey" class="item">
        <button @click="calc(item)">{{ item }}</button>
      </li>
    </ul>
    <button @click="result" class="result btn btn-warning">=</button>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      output: '',
      items: [
        ['7', '8', '9', '/'],
        ['4', '5', '6', '*'],
        ['1', '2', '3', '-'],
        ['0', '.', 'C', '+']
      ],
    }
  },methods: {
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
        this.output = ''
      }else {
        this.output += item
      }
    },
    result: function() {
      // バリデーション
      if(this.output === '') {
        return
      }

      // 計算
      this.output = String(eval(this.output))
    },
  }
}
</script>