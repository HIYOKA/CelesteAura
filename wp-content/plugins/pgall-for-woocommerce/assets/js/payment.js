jQuery(function(a){"use strict";var b=a(_pafw.checkout_form_selector),c={$forms:[],is_blocked:function(a){return a.is(".processing")||a.parents(".processing").length},block:function(a){c.is_blocked(a)||(a.addClass("processing").block({message:null,overlayCSS:{background:"#fff",opacity:.6}}),c.$forms.push(a))},unblock:function(){_.each(c.$forms,function(a,b){a.removeClass("processing").unblock()}),c.$forms=[]}};a.fn.pafw_hook={hooks:[],add_filter:function(b,c){void 0===a.fn.pafw_hook.hooks[b]&&(a.fn.pafw_hook.hooks[b]=[]),a.fn.pafw_hook.hooks[b].push(c)},apply_filters:function(b,c){if(void 0!==a.fn.pafw_hook.hooks[b])for(var d=0;d<a.fn.pafw_hook.hooks[b].length;++d)c[0]=a.fn.pafw_hook.hooks[b][d](c);return c[0]}},a.fn.pafw=function(b){if("object"==typeof(b=b||{}))return this.each(function(){var c=a.extend({paymentMethods:_pafw.gateway,isOrderPay:_pafw.is_checkout_pay_page,isSimplePay:!1,ajaxUrl:_pafw.ajax_url,slug:_pafw.slug,gatewayDomain:_pafw.gateway_domain},b);new d(a(this),c)}),this;throw new Error("잘못된 호출입니다.: "+b)};var d=function(a,b){void 0===a.data("pafw")&&(this.$paymentForm=a,this.options=b||{},this.uuid=this._generateUUID(),this._registerHandler(),a.data("pafw",this))};d.prototype._ajaxUrl=function(){var a="";if("yes"===this.options.isSimplePay){var b=this.options.ajaxUrl.split("?");a=b.length>1?b[0]+"?action="+this.options.slug+"-pafw_simple_payment&"+b[1]:this.options.ajaxUrl+"?action="+this.options.slug+"-pafw_simple_payment"}else a=wc_checkout_params.checkout_url;return a},d.prototype._generateUUID=function(){var a=(new Date).getTime();return"pafw_"+"xxxxxxxxxxxxxxxxxxxx".replace(/[x]/g,function(b){var c=(a+16*Math.random())%16|0;return a=Math.floor(a/16),("x"===b?c:3&c|8).toString(16)})},d.prototype._paymentComplete=function(a){window.location.href=a},d.prototype._paymentCancel=function(){a("#"+this.uuid).remove(),c.unblock()},d.prototype._paymentFail=function(b){alert(b),a("#"+this.uuid).remove(),c.unblock()},d.prototype._registerHandler=function(){this.gateways=a.fn.pafw_hook.apply_filters("pafw_gateway_objects",[this.options.paymentMethods]);var b=_.flatten(_.values(this.options.paymentMethods)).map(function(a){return"checkout_place_order_"+a}).join(" ");this.options.isOrderPay?this.$paymentForm.on("submit",this.processOrderPay.bind(this)):this.$paymentForm.on(b,this.processPayment.bind(this))},d.prototype._processPostMessage=function(b){b.origin===this.options.gatewayDomain&&("pafw_cancel_payment"!==b.data.action&&"pafw_payment_fail"!==b.data.action||a.fn.payment_fail(b.data.message))},d.prototype._registerPaymentCallback=function(){a.fn.payment_complete=this._paymentComplete.bind(this),a.fn.payment_cancel=this._paymentCancel.bind(this),a.fn.payment_fail=this._paymentFail.bind(this),_.isUndefined(a.fn.pafwPostMessageHandler)||window.removeEventListener("message",a.fn.pafwPostMessageHandler,!0),a.fn.pafwPostMessageHandler=this._processPostMessage.bind(this),window.addEventListener("message",a.fn.pafwPostMessageHandler,!0)},d.prototype.openPaymentWindow=function(b,c){if(_.isUndefined(c.redirect_url)||_.isEmpty(c.redirect_url)){document.getElementById(b)||a(document.body).append('<div id="'+b+'" style="width: 100%;height: 100%;position: fixed;top: 0;z-index: 99999;"></div>');a("#"+b).empty().append(c.payment_form)}else window.location.href=c.redirect_url},d.prototype.processPayment=function(){var b=this.uuid,d=this;return!c.is_blocked(this.$paymentForm)&&(c.block(this.$paymentForm),this._registerPaymentCallback(),a.ajax({type:"POST",url:this._ajaxUrl(),data:this.$paymentForm.serialize(),success:function(e){var f="";try{if(e.indexOf("\x3c!--WC_START--\x3e")>=0&&(e=e.split("\x3c!--WC_START--\x3e")[1]),e.indexOf("\x3c!--WC_END--\x3e")>=0&&(e=e.split("\x3c!--WC_END--\x3e")[0]),f=a.parseJSON(e),"success"===f.result)d.openPaymentWindow(b,f);else{if("failure"!==f.result||!f.messages)throw"Invalid response";alert(f.messages),c.unblock()}}catch(b){if(!0===f.reload||"true"===f.reload)return void window.location.reload();a(".woocommerce-error, .woocommerce-message").remove(),f.messages?d.$paymentForm.prepend(f.messages):d.$paymentForm.prepend(e),d.$paymentForm.find(".input-text, select").blur(),a("html, body").animate({scrollTop:d.$paymentForm.offset().top-100},1e3),"true"===f.refresh&&a("body").trigger("update_checkout"),a("body").trigger("checkout_error"),c.unblock()}},dataType:"html"}),!1)},d.prototype.processOrderPay=function(){var b=this.uuid,d=this,e=a("input[name=payment_method]:checked",this.$paymentForm).val();return-1===_.flatten(_.values(this.options.paymentMethods)).indexOf(e)||!c.is_blocked(this.$paymentForm)&&(c.block(this.$paymentForm),this._registerPaymentCallback(),a.ajax({type:"POST",url:_pafw.ajax_url,data:{action:_pafw.slug+"-pafw_ajax_action",payment_method:e,payment_action:"process_order_pay",order_id:_pafw.order_id,order_key:_pafw.order_key,data:this.$paymentForm.serialize(),_wpnonce:_pafw._wpnonce},success:function(a){void 0!==a&&void 0!==a.success&&!0===a.success?d.openPaymentWindow(b,a.data):alert(a.data),c.unblock()}}),!1)},d.prototype.destroy=function(){},a("body").trigger("pafw_init_hook"),_.each(b,function(b,c){a(b).pafw({})})});