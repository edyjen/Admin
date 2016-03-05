(function($,W,D) {
var definedLoadingLayer = true;
var mySpinner;
$(D).ready(function() {
  mySpinner = new Spinner({
    lines: 11,
    length: 0,
    width: 20,
    radius: 50,
    scale: 1,
    corners: 1,
    color: '#0789F4',
    opacity: 0.1,
    rotate: 0,
    direction: 1,
    speed: 2.0,
    trail: 80,
    fps: 20,
    zIndex: 2e9,
    className: 'spinner',
    top: '50%',
    left: '50%',
    shadow: false,
    hwaccel: false,
    position: 'absolute'
  }).spin();
});

cdate = function(entrada) {
    var result = entrada.split("-");
    return (entrada) ? ((result[0] > 1900) ? result[2]+"/"+result[1]+"/"+result[0] : result[0]+"/"+result[1]+"/"+result[2]) : "";
};

fAjax = function(myUrl, myData, myCallBack, showLoadingLayer) {
  myCallBack || (myCallBack = function(data){});
  showLoadingLayer || (showLoadingLayer = false);
  if (showLoadingLayer) {
    showLoading();
  }
  $.ajax({
    type: "POST",
    url: myUrl,
    data: myData,
    dataType: "json",
    async: false,
    cache: false,
    contentType: false,
    processData: false,
    success: function(data) {if (showLoadingLayer) {hideLoading()}; myCallBack(data);},
    error: function(jqXHR, textStatus, errorThrown) {
      if (showLoadingLayer) {hideLoading()};
      console.log(errorThrown);
      alert(textStatus + ". No se pudo acceder a " + myUrl + " debido a un Error del Servidor.\n"+errorThrown);
    }
  });
};

mAjax = function(myUrl, myData, myCallBack, showLoadingLayer) {
  myCallBack || (myCallBack = function(data){});
  showLoadingLayer || (showLoadingLayer = false);
  if (showLoadingLayer) {
    showLoading();
  }
  $.ajax({
    type: "POST",
    url: myUrl,
    data: myData,
    dataType: "json",
    async: true,
    cache: false,
    success: function(data) {if (showLoadingLayer) {hideLoading()}; myCallBack(data);},
    error: function(jqXHR, textStatus, errorThrown) {
      if (showLoadingLayer) {hideLoading()};
      console.log(errorThrown);
      alert(textStatus + ". No se pudo acceder a " + myUrl + " debido a un Error del Servidor.\n"+errorThrown); 
    }
  });
};

showLoading = function() {
  if (definedLoadingLayer) {
    //$(".docbody").addClass("blur");
    $($("<div>").addClass("cover").attr("id", "loadingLayer")).appendTo("body");
    $($("<div>").append(mySpinner.el)).appendTo("body");
  }
};

hideLoading = function() {
  if (definedLoadingLayer) {
    //$(".docbody").removeClass("blur");
    $("#loadingLayer").remove();
    $(mySpinner.el).remove();
  }
};

enableLoadingLayer = function() {
  definedLoadingLayer = true;
};

disableLoadingLayer = function() {
  definedLoadingLayer = false;
};

displayErrors = function(response, myCallBack) {
  myCallBack || (myCallBack = function(e){ return false; });
  if (myCallBack(response)) {
    return;
  }

  switch (response.messageId) {
    case "DATABASE_CONNECTION_SUCESS":
    case "PERMISSION_GRANTED":
    case "SUCESS":
    case "SAVE_ALLOWED":
      break;
    case "DATABASE_CONNECTION_ERROR":
      swal("Lo Sentimos!", "Ocurrió un error al conectar con la base de datos.", "error");
      break;
    case "PERMISSION_DENIED":
      swal("Acceso Denegado", "Usted no está autorizado para ver el contenido de ésta página.", "error");
      break;
    case "FAILED":
      swal("Lo Sentimos!", response.messageText, "error");
      break;
    case "SAVE_NOT_ALLOWED":
      swal("Acción Cancelada", "El registro que desea guardar ya existe.", "error");
      break;
    case "EMPTY":
      swal("Error!", "El registro no existe.", "error");
      break;
    case "ABORTED":
      swal("Acción Cancelada", response.messageText, "error");
      break;
    default:
      swal(response.messageId, response.messageText, "error");
  }
}

})(jQuery, window, document);