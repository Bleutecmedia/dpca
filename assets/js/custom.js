'use strict'
var opts = {
  lines: 13, // The number of lines to draw
  length: 20, // The length of each line
  width: 10, // The line thickness
  radius: 30, // The radius of the inner circle
  corners: 1, // Corner roundness (0..1)
  rotate: 0, // The rotation offset
  direction: 1, // 1: clockwise, -1: counterclockwise
  color: '#0101DF', // #rgb or #rrggbb or array of colors
  speed: 2, // Rounds per second
  trail: 60, // Afterglow percentage
  shadow: true, // Whether to render a shadow
  hwaccel: true, // Whether to use hardware acceleration
  className: 'spinner', // The CSS class to assign to the spinner
  zIndex: 2e9, // The z-index (defaults to 2000000000)
  top: '50%', // Top position relative to parent
  left: '50%' // Left position relative to parent
};

var base_url  = window.location.origin;

function fn_cargar_ajax_p(url,target,id,item1,item2,item3,item4,item5){
  $.ajax({
    url: url,
    cache: true,
    type: 'post',//get,post
    dataType: 'html',//(xml, json, script, or html))
    data:{id:id,item1:item1,item2:item2,item3:item3,item4:item4,item5:item5,'csrf_token': csrf_token},
    beforeSend: function(request){
       $("#"+target).spin(opts);
    },
    error:function(){ 
      fn_error();
      $('#'+target).spin(false);
    },
    success: function(html) { 
      //$('html,body').animate({ scrollTop: $('#'+target).offset().top}, 800);
      $('#'+target).empty().html(html).fadeIn("fast");
      $('#'+target).spin(false);
    },
    timeout: 8000 // sets timeout to 8 seconds
  });
};

function fn_cargar_ajax_g(url,target,id,item1,item2,item3,item4,item5){
  $.ajax({
    url: url,
    cache: true,
    type: 'get',//get,post
    dataType: 'html',//(xml, json, script, or html))
    data:{id:id,item1:item1,item2:item2,item3:item3,item4:item4,item5:item5,'csrf_token': csrf_token },
    beforeSend: function(request){
      $("#"+target).spin(opts);
    },
    error:function(){ 
      fn_error();
      $('#'+target).spin(false);
    },
    success: function(html) {
      //$('html,body').animate({ scrollTop: $('#'+target).offset().top}, 800);
      $('#'+target).empty().html(html).fadeIn("fast");
      $('#'+target).spin(false);
    },
    timeout: 8000 // sets timeout to 8 seconds
  });
};

function fn_logout(){
 const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  })

  swalWithBootstrapButtons.fire({
    title: '¿Desea cerrar su Sesión?',
    text: "Esto cerrará su Sesión actual en este dispositivo",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, Salir',
    cancelButtonText: 'No',
    reverseButtons: true,
    allowOutsideClick: false,
    allowEscapeKey: false,
    allowEnterKey: false,
    showCloseButton: true
  }).then((result) => {
    if (result.value) {
       location.href="auth/logout";
    }
  });
}

function openmodal(url){
  window.open(url, 'formresult', 'scrollbars=yes,menubar=no,height=600,width=1024,resizable=yes,toolbar=no,status=no');
}

function submitFORM(path, params, method) {
    method = method || "post"; 

    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);
    form.setAttribute("target", "formresult");// setting form target to a window named 'formresult'

    //Move the submit function to another variable
    //so that it doesn't get overwritten.
    form._submit_function_ = form.submit;

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form._submit_function_();
}

function addElement(parentId, elementTag, elementId, html) {
  // Adds an element to the document
  var p = document.getElementById(parentId);
  var newElement = document.createElement(elementTag);
  newElement.setAttribute('id', elementId);
  newElement.innerHTML = html;
  p.appendChild(newElement);
}

function removeElement(elementId) {
  // Removes an element from the document
  var element = document.getElementById(elementId);
  element.parentNode.removeChild(element);
}

function isInt(value) {
  var x;
  if (isNaN(value)) {
    return false;
  }
  x = parseFloat(value);
  return (x | 0) === x;
}


function fn_success(msj) {

    let mensaje     =   'Se ha procesado su solicitud correctamente.';
    if(typeof msj !== 'undefined'){
        mensaje     =   msj;
    }

    new Noty({
        type: 'success',
        layout: 'topRight',
        theme: 'nest',
        text: '<i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;' + mensaje,
        timeout: '1500',
        progressBar: true,
        closeWith: ['click','button'],
        killer: true
    }).show();
}

function fn_error(msj) {

    let mensaje     =   'Hubo un error, vuelva a intentarlo...';
    if(typeof msj !== 'undefined'){
        mensaje     =   msj;
    }

    new Noty({
        type: 'error',
        layout: 'topRight',
        theme: 'nest',
        text: '<i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;' + mensaje,
        timeout: '1500',
        progressBar: true,
        closeWith: ['click','button'],
        killer: true
    }).show();
}

function fn_info(msj) {

  let mensaje     =   'Info';
  if(typeof msj !== 'undefined'){
      mensaje     =   msj;
  }

  new Noty({
      type: 'info',
      layout: 'topRight',
      theme: 'nest',
      text: '<i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;' + mensaje,
      timeout: '1500',
      progressBar: true,
      closeWith: ['click','button'],
      killer: true
  }).show();
}