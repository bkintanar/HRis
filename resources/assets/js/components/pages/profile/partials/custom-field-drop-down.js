module.exports = {
  props: ['custom_field', 'custom_field_values', 'custom_field_value_objs'],

  route: {
    canReuse: false
  },

  ready: function() {

    for (var i = 0; i < this.custom_field.options.length; i++) {

      if (typeof this.custom_field_value_objs[i] == 'undefined') {

        this.custom_field_value_objs.push('');
      }

      if (this.custom_field.options[i].id == this.custom_field_values[this.custom_field.id]) {

        this.custom_field_values[this.custom_field.id] = this.custom_field.options[i];

        //console.log(i);
      }
    }
  }
};
