(function(a){a.fn.pdsutils=function(c){if(b[c]){return b[c].apply(this,Array.prototype.slice.call(arguments,1))}else{a.error("Method "+c+" does not exist on jQuery.pdsuilts")}};var b={dataChanged:function(b,c){var d={selectTagSelectIndex:"value"};var e=a.extend({},d,c);return this.each(function(){var c=a(this);var d=c[0].tagName.toLowerCase();var f=d=="input"?c.attr("type"):"";if(d=="select"){c.change(function(){var c=a(this);val=c.val();if(e["selectTagSelectIndex"]=="label")val=c[0].options[c[0].selectedIndex].innerHTML;b(val)});c.change()}else if(d=="input"&&(f=="radio"||f=="checkbox")){c.change(function(){var c=a(this);var d;if(!c.is(":checked"))d="";else d=c.val();b(d)});c.click()}else if(d=="input"&&f!=undefined&&f!="number"&&f!="date"||d=="textarea"){c.keyup(function(){var c=a(this);var d=c.val();b(d)});c.keyup()}else if(d=="input"){c.blur(function(){var c=a(this);var d=c.val();b(d)});c.focus()}return})},getData:function(b){var c={attr:"value",selectTagSelectIndex:"value"};var d=a.extend({},c,b);var e="";this.each(function(){var b=a(this);if(d.attr!="value"){e=b.attr(d.attr)}else{var c=b[0].tagName.toLowerCase();var f=c=="input"?b.attr("type"):"";if(c=="input"||c=="textarea"){e=b.val();if(c=="input"&&(f=="radio"||f=="checkbox")&&!b.is(":checked"))e=""}else if(c=="select"){e=b.val();if(d["selectTagSelectIndex"]=="label")e=$elem[0].options[$elem[0].selectedIndex].innerHTML}else{if(b.attr("value"))e=b.attr("value");else e=b.html()}}});return e},setData:function(b,c,d){var e={attr:"value",selectTagValidateIndex:"value"};var f=a.extend({},e,d);c=!!c;return this.each(function(){var d=a(this);var e=this.tagName.toLowerCase();var g=e=="input"?d.attr("type"):"";if(e=="input"||e=="textarea"){if(e=="input"&&(g=="radio"||g=="checkbox")){if(!c){for(var h=0;h<d.length;h++){if(d[h].value==b){d[h].checked=true;break}}}}else{if(f.attr!="value")d.attr(f.attr,b);else d.val(b)}}else if(e=="select"){if(!c){var i=-1;d.find("option").each(function(){if((f["selectTagValidateIndex"]=="value"||f["selectTagValidateIndex"]=="both")&&b==a(this).val()||(f["selectTagValidateIndex"]=="label"||f["selectTagValidateIndex"]=="both")&&b==a(this).html()){a(this).attr("selected","selected")}})}}else{if(f.attr!="value")d.attr(f.attr,b);else d.html(b)}})}}})(jQuery)