CNVS.Filter=function(){var i=SEMICOLON.Core,a=SEMICOLON.Modules;return{init:function(t){if(i.getSelector(t,!1,!1).length<1)return!0;i.isFuncTrue(function(){return"undefined"!=typeof jQuery&&"undefined"!=typeof Isotope}).then(function(e){return!!e&&(i.initFunction({class:"has-plugin-isotope-filter",event:"pluginGridFilterReady"}),(t=i.getSelector(t)).length<1||(t.each(function(){var t=jQuery(this),i=t.attr("data-container"),r=t.attr("data-active-class"),e=t.attr("data-default"),r=r||"activeFilter";if(!jQuery(i).hasClass("grid-container"))return!1;t.find("a").off("click").on("click",function(){t.find("li").removeClass(r),jQuery(this).parent("li").addClass(r);var e=jQuery(this).attr("data-filter");return jQuery(i).isotope({filter:e}),!1}),e&&(t.find("li").removeClass(r),t.find('[data-filter="'+e+'"]').parent("li").addClass(r),jQuery(i).isotope({filter:e})),jQuery(i).on("arrangeComplete layoutComplete",function(e,t){jQuery(i).addClass("grid-container-filterable"),"gallery"==jQuery(i).attr("data-lightbox")&&(jQuery(i).find("[data-lightbox]").removeClass("grid-lightbox-filtered"),t.forEach(function(e){jQuery(e.element).find("[data-lightbox]").addClass("grid-lightbox-filtered")})),a.lightbox()})}),void jQuery(".grid-shuffle").off("click").on("click",function(){var e=jQuery(this).attr("data-container");if(!jQuery(e).hasClass("grid-container"))return!1;jQuery(e).isotope("shuffle")})))})}}}();