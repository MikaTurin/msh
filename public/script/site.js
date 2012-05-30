$(document).ready(function() {

  var w = $('#textcontainer').width();
  $('#scrollbar1').css('width', w);

  $('#scrollbar1').slimscroll({
    color:'#FFF',
    width: w+'px',
    height: $('#textcontainer').height()+'px',
    railVisible:true,
    alwaysVisible:true
  });

});

$(window).resize(doResize);

function doResize() {

  var me = $('#scrollbar1'), w = $('#textcontainer').width(), h=$('#textcontainer').height();
  $('#scrollbar1').css('width', w);
  me.css("height",h+'px');
  $(".slimScrollDiv").css('width', w+'px').css("height",h+'px');
  var height = Math.max((me.outerHeight() / me[0].scrollHeight) * me.outerHeight(), 30);
  $(".slimScrollBar").css({ height: height + 'px' });

}

function showError(el, text, color, target) {

  if (!color) color = 'red';
  if (!target) target = 'topRight';
  el.qtip({
    content: text,
    show: { when: { event: 'none'}, ready: true },
    hide: { when: { event: 'unfocus' }, delay: 0 },
    position: {
      corner: {
        target: target,
        tooltip: 'bottomLeft'
      }
    },
    style: {
      tip: true,
      name: color
    }
  });
}

function showSuccess(el, text) {

  showError(el, text, 'green');
}

function submitForm(btn) {

  var frm = $(btn.form);

  frm.tezSubmit(function(msg) {

    if (msg.func) window[msg.func](msg);
    if (msg.ok == 1) {
      if (msg.url) top.location.href=msg.url;
      else if(msg.next) $('.next').click();
      else if (msg.reload) top.location.reload();
    }
    else {
      showError(frm.find(msg.fld), msg.info);
      frm.find(msg.fld).focus();
    }
  }, null, $(btn), 'input-button-dis');
}

