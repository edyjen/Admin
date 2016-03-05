(function($,W,D) {

validate = function(data) {
  data.invalidHandler || (data.invalidHandler = function(){});
  return {
    configurar: function() {
      $("#"+data.form).validate({
        highlight: function(element, errorClass, validClass) {
          $(element).parent().addClass(errorClass).removeClass(validClass);
          //console.log($(element).parent().children("span"));
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).parent().removeClass(errorClass).addClass(validClass);
          //$(element).parent().children("span .input-group-addon").hide();
        },
        onkeyup: false,
        onchange: true,
        rules: data.rules,
        messages: data.messages,
        submitHandler: data.submitHandler,
        invalidHandler: data.invalidHandler,
        errorClass: "has-error help-block",
        validClass: "has-sucess"
      });
    }
  };
};

$.fn.extend({
  hideBlock: function() {
    return this.each(function() {
      $(this).parent().parent().hide();
    });
  },
  showBlock: function() {
    return this.each(function() {
      $(this).parent().parent().show();
    });
  },
  bindTo: function(inputName) {
    return this.each(function() {
      id = "_bind" + $(this).attr("id");
      $("<input>").attr({
          type: "hidden",
          id: id,
          name: inputName
      }).appendTo("form");

      $(this).attr("bindInputId", id).change(function(){
        $(this).loadBindValue();
      });
    });
  },
  loadBindValue: function() {
    return this.each(function() {
      $("#" + $(this).attr("bindInputId")).val($(this).val());
    });
  },
  setBindValue: function(value) {
    return this.each(function() {
      $("#" + $(this).attr("bindInputId")).val(value);
    });
  }
});


})(jQuery, window, document);