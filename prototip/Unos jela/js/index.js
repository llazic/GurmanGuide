var example1 = new Vue({
  el: '#example-1',
  data: {
    newItem: '',
    items: [
    ]
  },
  methods: {
    remove: function(item){
      this.items.splice( this.items.indexOf(item), 1 );
    },
    add: function(){
      this.items.unshift({ message: this.newItem });
      this.newItem = '';
    }
  }
})