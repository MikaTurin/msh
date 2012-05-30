(function($){
  $.tezChangeTimerId = null;
  $.fn.extend({
    tezSubmit: function(options, data, button, className) {

      if (!this.length) return this;

      if(button) {
        if ($(button).hasClass(className)) return this;
        $(button).addClass(className);
      }

      if (typeof options == 'function') options = { success: options };

      var q = $(this).serialize();
      if (data) q += (q ? '&' : '') + data;

      var obj = {
        type: 'POST',
        url: $(this).attr('action'),
        data: q,
        dataType: 'json',
        success: function(msg) {
          //console.log(msg);
        },
        complete: function() {
          if(button) $(button).removeClass(className);
        }
      };

      jQuery.extend(obj, options);
      $.ajax(obj);
    },
    tezChange: function(func, timeout) {

      if (!timeout) timeout = 1500;

      $(this).bind('keyup paste', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13 || code == 9) return;
        if ($.tezChangeTimerId) clearTimeout($.tezChangeTimerId);
         $.tezChangeTimerId = setTimeout(func, timeout);
      });
      return this;
    },
     tezEnter: function(func) {
      $(this).bind('keydown', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) setTimeout(func, 0);
      });
      return this;
    },
    tezDefault: function(val) {
      $(this).val(val);
      $(this).bind('focus', function() { if (this.value == val) this.value = ''; });
      $(this).bind('blur', function() { if ($.trim(this.value) == '') this.value = val; });
      return $(this);
    },
    tezPhoneField: function(len) {
      if (!len) len = 11;
      $(this).bind('keydown', function(e) { var c = e.which; if ((c!=32&&c<48)||e.ctrlKey||e.metaKey) return true; if (this.value.length>=len||(c>57 && c<96) || c>105 || c==32) return false; });
      $(this).bind('paste', function(e) { var _this=$(this); setTimeout(function() { clearPhoneNumber(_this);  }, 50); });
      $(this).bind('blur', function() { clearPhoneNumber($(this));  });
      return $(this);
    }
  });
  function clearPhoneNumber(el) {
    el.val(el.val().replace(/\D+/g, '').substring(0, 11));
  }
})(jQuery);

(function($) {
  var s=null,el=null,ww=null,hh=null;
  $.fn.extend({
    tezTip : function () {
      el = $('<div class="atip"/>').appendTo(document.body);
      return this.live('mouseenter', function(e){
        s = $(this).attr('title');
        $(this).removeAttr('title');
        el.html(decodeURI(s)).show();
        ww = el.width();
        hh = el.height();
        pos(e);
        $(document.body).bind('mousemove', pos);
        $(this).mouseleave( function(){
          el.hide().empty().css({top: 0, left: 0});
          if (s) $(this).attr('title', s);
          s = null;
          $(document.body).unbind('mousemove', pos);
          el.unbind();
        });
      });
    }
  });
  function pos(e){
    var m = 10,x = (e.pageX + m),y = (e.pageY + m),w = {l:$(window).scrollLeft(), t:$(window).scrollTop(), w:$(window).width(), h:$(window).height()};
    if (w.l + w.w < x + ww + m*3) x = x - ww - m*3;
    if (w.t + w.h < y + hh + m*2) y = y - hh - m*2;
    el.css({top:y+'px', left:x+'px'});
  }
})(jQuery);

(function($) {
  $.fn.tezMaxLength = function(options) {

    if (typeof options == 'function') options = { onEdit: options };

    var settings = $.extend({
      attribute: "maxlength",
      onLimit: function() {},
      onEdit: function() {}
    }, options);

    var onEdit = function() {
      var textarea = $(this);
      var maxlength = parseInt(textarea.attr(settings.attribute));

      if (textarea.val().length > maxlength) {
        textarea.val(textarea.val().substr(0, maxlength));
        /*$.proxy(settings.onLimit, this)();*/
      }

      $.proxy(settings.onEdit, this)(maxlength - textarea.val().length);
    }

    this.each(onEdit);
    return this.keyup(onEdit).keydown(onEdit).focus(onEdit).blur(onEdit);
  }
})(jQuery);

/*
 * SimpleModal OSX Style Modal Dialog
 * Copyright (c) 2011 Mika Turin - mika.turin@gmail.com
 */

(function($) {
  $.fn.modal = function(focus, top) {

    var d = $(this);
    var o = $('#over');

    o.css('height', $(document).height());
    o.fadeTo(200, 0.6, function() {

      var title = $('div.osx-modal-title', d);
      title.show();

      if (top) {

        $('div.close', d).show();
        $('div.osx-modal-data', d).show();
        d.show();
        var h = $('div.osx-modal-data', d).height() + title.height() + 20; // padding
        d.css('height', h).css('top', top);

        if (focus) $(focus).focus();
        return;
      }

      $(d).slideDown(300, function () {

        setTimeout(function () {
          var h = $('div.osx-modal-data', d).height() + title.height() + 20; // padding
          $(d).animate(
            {height: h},
            300,
            function () {
              $('div.close', d).show();
              $('div.osx-modal-data', d).show();
              if (focus) $(focus).focus();
            }
          );
        }, 150);
      });

	  });
  };
  $.fn.modalClose = function() {

    var d = $(this);
    d.animate(
      {top:"-" + (d.height() + 20)},
      500,
      function () {
        d.hide();
        d.css('top', 0).css('height', $('div.osx-modal-title', d).height() + 20); //TODO: error on second attempt dont show rounded corners on show
        $('#over').hide();
        $('div.osx-modal-title', d).hide();
        $('div.osx-modal-data', d).hide();
        $('div.close', d).hide();
      }
    );

  };

  $(document).ready(function() {
    var el = $('<div id="over">');
    $('body').append(el);
    $('div.osx-container>div.close').click(function() { $(this).parent().modalClose(); });
  });

})(jQuery);


