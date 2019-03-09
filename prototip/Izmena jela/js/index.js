var example1 = new Vue({
  el: '#example-1',
  data: {
    newItem: '',
    items: [
      { message: 'Chicago testo' },
      { message: 'sir' },
      { message: 'šunka' },
      { message: 'pančeta' },
      { message: 'kisela pavlaka' },
	  { message: 'šampinjoni' }
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