jQuery.extend( jQuery.fn.dataTableExt.oSort, {
  "date-euro-pre": function ( a ) {
      var x;

      if ( $.trim(a) !== '' ) {
          var frDatea = $.trim(a).split(' ');
          var frTimea = (undefined != frDatea[1]) ? frDatea[1].split(':') : [00,00,00];
          var frDatea2 = frDatea[0].split('/');
          x = (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1] + ((undefined != frTimea[2]) ? frTimea[2] : 0)) * 1;
      }
      else {
          x = Infinity;
      }

      return x;
  },

  "date-euro-asc": function ( a, b ) {
      return a - b;
  },

  "date-euro-desc": function ( a, b ) {
      return b - a;
  }
} );