(function(a){a.fn.syncEdit=function(a,c){if(b[a]){return b[a].apply(this,Array.prototype.slice.call(arguments,1))}else{return b.init.apply(this,arguments)}};var b={init:function(b,c){var d={attr:"value",greedy:"default",action:"update",callback:undefined,selectTagSelectIndex:"value",selectTagValidateIndex:"both",onSync:function(a,b,c){},onChangeTarget:function(a,b){}};var e=a.extend({},d,c);return this.each(function(){function g(a,b){if(e["action"]=="callback"&&e["callback"]!=""){e["callback"](a,b,d)}else{c.utils_options.attr=e.attr;a.pdsutils("setData",b,false,c.utils_options);e["onSync"](a,b,d)}}if(b==undefined||b=="")return;this.soptions=e;var c=this;var d=a(this);var f=a(b);this.syncEditEnabled=true;this.$syncTo=f;this.utils_options={selectTagSelectIndex:e["selectTagSelectIndex"],selectTagValidateIndex:e["selectTagValidateIndex"]};d.syncEdit("sync",true);d.pdsutils("dataChanged",function(a){g(c.$syncTo,a)},this.utils_options)})},updateSyncTo:function(b,c,d){c=!!c;if(!a(this).syncEdit("valid")&&c){a(this).syncEdit(b,d)}else{return this.each(function(){var c=a(this);var d=this.soptions;var e=a(b);if(e[0]!=this.$syncTo[0]){this.$syncTo=e;c.syncEdit("sync");d["onChangeTarget"](this.$syncTo,c)}})}},sync:function(b){b=!!b;return this.each(function(){var c=a(this);var d=this.soptions;this.utils_options.attr=d.attr;if(d["greedy"]=="yes")c.pdsutils("setData",this.$syncTo.pdsutils("getData",this.utils_options),b,{attr:d.attr});else if(d["greedy"]=="no")this.$syncTo.pdsutils("setData",c.pdsutils("getData",this.utils_options),b,{attr:d.attr})})},valid:function(){if(this.syncEditEnabled!=undefined&&this.syncEditEnabled===true)return true;return false},option:function(a,b){return this.each(function(){this.soptions[a]=b})}}})(jQuery)