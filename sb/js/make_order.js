let waiJqIntervalMakeOrder = setInterval(function(){
	if (typeof($) != 'undefined') {
		clearInterval(waiJqIntervalMakeOrder);

		var style = {
			theme: 'default',
			type: 'default',
			size: 'default',
			text: 'Купить в рассрочку'
		};

		var params = {
			buttonStyle: style,
			containerModal: 'previewModal',
			containerButton: 'b-sb-pay',
			creditAvailable: true,
			repeatOpen: false,
			creditProducts: sbUserOffersB2b
		};

		var orderPrice = 0,

		currentOffer = null,

		getCurrentOffer = function(){
			if (!currentOffer) {
				const searchOfferType = sbUserB2b.orgLawFormShort == 'ООО' ? 'oo' : 'ip';
				$.each(sbUserOffersB2b, function(){
					if (this.productCode.indexOf(searchOfferType) !== -1) {
						currentOffer = this;
						return false;
					}
				});
			}
			return currentOffer;
		};

		function onOpenModalCallback() {

		}
		function onSuccessCallback(result) {
			sessionStorage.setItem('sb_data_result', JSON.stringify(result));
			window.location.reload();
		}
		function onCancelCallback(result) {

		}
		function onErrorCallback(result) {

		}
		function onSelectedProduct() {
			return {
				productCode: getCurrentOffer().productCode,
				amount: orderPrice
			}
		}

		function getAllUrlParams(url) {
			var queryString = url ? url.split('?')[1] : window.location.search.slice(1);
			var obj = {};
			if (queryString) {
				queryString = queryString.split('#')[0];
				var arr = queryString.split('&');
		
				for (var i = 0; i < arr.length; i++) {
					var a = arr[i].split('=');
					var paramName = a[0];
					var paramValue = typeof(a[1]) === 'undefined' ? true : a[1];
					paramName = paramName.toLowerCase();
					if (typeof paramValue === 'string') paramValue = paramValue.toLowerCase();
					if (paramName.match(/\[(\d+)?\]$/)) {
						var key = paramName.replace(/\[(\d+)?\]/, '');
						if (!obj[key]) obj[key] = [];
						if (paramName.match(/\[\d+\]$/)) {
							var index = /\[(\d+)\]/.exec(paramName)[1];
							obj[key][index] = paramValue;
						} else {
							obj[key].push(paramValue);
						}
					} else {
						if (!obj[paramName]) {
							obj[paramName] = paramValue;
						} else if (obj[paramName] && typeof obj[paramName] === 'string') {							// if property does exist and it's a string, convert it to an array
							obj[paramName] = [obj[paramName]];
							obj[paramName].push(paramValue);
						} else {
							obj[paramName].push(paramValue);
						}
					}
				}
			}
			return obj;
		}

		let makeOrderInit = function(){
			if (!sbUserB2b) {
				$.post('/sb/api.php', {
					action: 'authlink',
					loc: window.location.pathname + window.location.search
				}, function(data){
					if(data.link) {
						window.location = data.link;
					}
				});
			} else if (!sessionStorage.getItem('sb_data_result')) {
				// Получаем стоимость заказ
				$.post('/sb/api.php', {
					action: 'orderprice',
					id: sbOrderId
				}, function(data){
					// Активируем сбер бизнес виджет
					if (data.price) {
						orderPrice = data.price;

						$('body').append('<div class="previewModal"></div>');

						new CredInBaskSDK(
							params,
							onSuccessCallback,
							onCancelCallback,
							onErrorCallback,
							onOpenModalCallback,
							onSelectedProduct
						);
						if ($('.b-popup').length) {
							var $btn = $('#i-credit-button').clone();
							$btn.addClass('m-cloned').on('click', function(e){
								e.preventDefault();
								$('.b-popup').css('display', 'flex');
							})
							$btn.insertAfter($('#i-credit-button'));
							$('#i-credit-button:not(.m-cloned)').remove();
						} else {
							$('#i-credit-button')[0].click();
						}
					}
				});

			} else {
				const curOff = getCurrentOffer();
				$.post('/sb/api.php', {
					action: 'makeorder',
					data: sessionStorage.getItem('sb_data_result'),
					id: sbOrderId,
					min: curOff.sumMin,
					max: curOff.sumMax
				}, function(data){
					sessionStorage.removeItem('sb_data_result')
					if (data.error) {
						confirm(data.error);
						window.location.reload();
					}
					if(data.link) {
						window.location = data.link;
					}
				});
			}
		}


		setInterval(function(){
			if ($('.b-sb-pay').length && !$('.b-sb-pay').hasClass('m-activated')) {
				$('.b-sb-pay').addClass('m-activated');
				makeOrderInit();
			}
		}, 200);
	}
}, 100); 
