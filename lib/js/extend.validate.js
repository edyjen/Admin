(function($,W,D) {
  $.validator.addMethod("time24", function(value, element, param) {
    expression = /^(0?\d|1\d|2[0-3])(\u003A)(0?[1-9]|[0-5]\d)$/;
      return this.optional(element) || expression.test(value);
  }, "Hora incorrecta");

  $.validator.addMethod("spanishWords", function(value, element, param) {
    expression = /^[a-z\u00E1\u00E9\u00ED\u00F3\u00FA\u00F1]+(\s+[a-z\u00E1\u00E9\u00ED\u00F3\u00FA\u00F1]+)*$/i;
    return this.optional(element) || expression.test(value);
  }, "Campo con caracteres no admitidos");

  $.validator.addMethod("spanishWord", function(value, element, param) {
    expression = /^[a-z\u00E1\u00E9\u00ED\u00F3\u00FA\u00F1]+$/i;
    return this.optional(element) || expression.test(value);
  }, "Campo con caracteres no admitidos");

    $.validator.addMethod("spanishAlphas", function(value, element, param) {
    expression = /^[0-9a-z\u00E1\u00E9\u00ED\u00F3\u00FA\u00F1]+(\s+[0-9a-z\u00E1\u00E9\u00ED\u00F3\u00FA\u00F1]+)*$/i;
    return this.optional(element) || expression.test(value);
  }, "Campo con caracteres no admitidos");

  $.validator.addMethod("spanishAlpha", function(value, element, param) {
    expression = /^[0-9a-z\u00E1\u00E9\u00ED\u00F3\u00FA\u00F1]+$/i;
    return this.optional(element) || expression.test(value);
  }, "Campo con caracteres no admitidos");

  $.validator.addMethod("nick", function(value, element, param) {
    expression = /^[0-9a-z_\-\.]+$/i;
    return this.optional(element) || expression.test(value);
  }, "Campo con caracteres no admitidos");

  $.validator.addMethod("nicks", function(value, element, param) {
    expression = /^[0-9a-z_\-\.\s]+$/i;
    return this.optional(element) || expression.test(value);
  }, "Campo con caracteres no admitidos");

  $.validator.addMethod("fileExt", function(value, element, param) {
    if (element.files.length == 0) {
      return this.optional(element) || false;
    }
    exts = param.toLowerCase().split("|");
    return this.optional(element) || (exts.indexOf(element.files[0].name.split(".").pop().toLowerCase()) != -1);
  }, "Extension de archivo no admitida");

  $.validator.addMethod("fileType", function(value, element, param) {
    if (element.files.length == 0) {
      return this.optional(element) || false;
    }

    if (element.files[0].type == "") {
      return this.optional(element) || false;
    }
    
    types = param.toLowerCase().split("|");
    return this.optional(element) || (types.indexOf(element.files[0].type.split("/")[0]) != -1);
  }, "Tipo de archivo no admitido");

  $.validator.addMethod("fileSize", function(value, element, param) {
    return this.optional(element) || (element.files[0].size <= param);
  }, "Límite de tamaño excedido");

  String.prototype.formatTrim = function() {
    cadena = this;
    return cadena.replace(/^\s+/,'').replace(/\s+$/,'').replace(/\s\s+/g,' ');
  }

  String.prototype.formatNumber = function() {
    expression = /^\d+$/i;
    cadena = this.formatSpace();
    return (expression.test(cadena)) ? parseInt(cadena, 10) : cadena;
  }

  String.prototype.formatSpace = function() {
    cadena = this;
    return cadena.replace(/\s+/g,'');
  }

})(jQuery, window, document);