jQuery("body").on("click",".svs_price_plan .icon-settings",function(){jQuery.modal("<input class='spectrum'>");jQuery("#simplemodal-container").css("width","auto");jQuery("#simplemodal-container").css("top",jQuery(this).offset().top);jQuery("#simplemodal-container").css("left",jQuery(this).offset().left);jQuery("#simplemodal-overlay").unbind("click").bind("click",function(){jQuery.modal.close()});var a=jQuery(this).parent();jQuery(".spectrum").spectrum({color:jQuery(a).find(".svs_title").css("background-color"),change:function(b){jQuery.modal.close();jQuery(a).find(".svs_title").css("background-color",b.toHexString());jQuery(a).find(".svs_title").css("border-bottom","3px solid "+shadeColor(b.toHexString(),-40))}})});jQuery("body").on("click","a[href='#previous']",function(){jQuery(".svs_title").removeAttr("style");jQuery("body").off("click","a[href='#previous']")});