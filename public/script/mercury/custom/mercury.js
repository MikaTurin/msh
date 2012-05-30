$(document).ready(function(){

  if (!window.Mercury) alert('NO Mercury!');
  window.Mercury.saveURL = LURL+'/admin/save';
  window.Mercury.silent = true;

  window.Mercury.PageEditor.prototype.serialize = function() {

    var region, serialized, _i, _len, _ref;
    serialized = {};
    _ref = this.regions;
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      region = _ref[_i];
      serialized[region.name] = region.serialize();
    }
    var tp = $('iframe.mercury-iframe ').contents().find("#mercury_editor_page").val();
    if (tp == 'news') {
      serialized['pagetype'] = 'news';
      serialized['cdate'] = $('iframe.mercury-iframe ').contents().find("#cdate").val();
      serialized['news_id'] = $('iframe.mercury-iframe ').contents().find("#news_id").val();
      serialized['news_mode'] = $('iframe.mercury-iframe ').contents().find("#news_mode").val();
    } else if (tp == 'faq') {
      serialized['pagetype'] = 'faq';
      serialized['faq_id'] = $('iframe.mercury-iframe ').contents().find("#faq_id").val();
    }

    return serialized;
  };

  top.Mercury.PageEditor.prototype.save = function() {

    var data, url, _ref, _ref2;
    url = (_ref = (_ref2 = this.saveUrl) != null ? _ref2 : Mercury.saveURL) != null ? _ref : this.iframeSrc();
    data = this.serialize();
    Mercury.log('saving', data);
    if (this.options.saveStyle !== 'form') { data = jQuery.toJSON(data); }

    return jQuery.ajax(url, {
      type: 'POST',
      data: {content: data},
      dataType: 'json',
      success: function(msg) {
        if (msg.error) {
          alert(msg.error);
          return;
        }
        if (msg.url) top.location.href = msg.url;
        if (msg.reload == 1) top.location.reload();
        return Mercury.changes = false;
      },
      error: function() {
        return alert("Mercury was unable to save to the url: " + url);
      }
    });
  };

  setTimeout(function() {
    jQuery('div.mercury-closeAdmin-button').click(function() { $.ajax({type:'POST', url:'/admin/editor?mode=off', success:function(){top.location.reload();}}); });
    /*jQuery('div.mercury-addNews-button').click(function() { top.location.href=LURL+'/news/add'; });
    jQuery('div.mercury-addSpecialOffer-button').click(function() { top.location.href=LURL+'/specialoffer/add'; });
    jQuery('div.mercury-addAnnouncement-button').click(function() { top.location.href=LURL+'/hot/add'; });*/
   }, 0)
});