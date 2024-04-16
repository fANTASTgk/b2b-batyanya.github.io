let waiJqIntervalMake = setInterval(function(){
	if (typeof($) != 'undefined') {
		clearInterval(waiJqIntervalMake);

		const cutNumber = (n) => {
			n = Number(n).toFixed(0);
			const format = (toCut, letter) => String(n).slice(0, -toCut) + letter;

			if (n > 999999) {
				return format(6, " млн");
			}
			
			if (n > 999) {
				return format(3, " тысяч");
			}

			return n;
		};

		var style = {
			theme: 'default',
			type: 'default',
			size: 'default',
			text: 'Купить в рассрочку'
		};

		var params = {
			buttonStyle: style,
			containerModal: 'previewModal',
			containerButton: 'previewButton',
			creditAvailable: true,
			repeatOpen: false,
			creditProducts: sbUserOffersB2b
		};

		function onOpenModalCallback() {

		}
		function onSuccessCallback(result) {
			sessionStorage.setItem('sb_data_result', JSON.stringify(result));
			submitForm('Y');
		}
		function onCancelCallback(result) {

		}
		function onErrorCallback(result) {

		}
		function onSelectedProduct() {
			return {
				productCode: currentOffer.productCode,
				amount: Number($('.index_checkout-promocode-total_amount:eq(0)').text().replace(' руб.', '').replace(/\s+/g, ""))
			}
		}

		let $btn0 = null,
		currentOffer = null,

		getCurrentOffer = function(){
			if (!currentOffer) {
				const searchOfferType = sbUserB2b.orgLawFormShort == 'ООО' ? 'oo' : 'ip';
				$.each(sbUserOffersB2b, function(){
					if (typeof(this.productCode) != 'undefined' && this.productCode.indexOf(searchOfferType) !== -1) {
						currentOffer = this;
						return false;
					}
				});
			}
			return currentOffer;
		},

		getRasDays = function(type) {
			const curOffer = getCurrentOffer();
			return type ? curOffer.delayRepayment + 1 : curOffer.delayRepayment;
		},
		getRasProc = function() {
			const curOffer = getCurrentOffer();
			return +(curOffer.rate / 12).toFixed(2);
		},
		getRasMax = function() {
			const curOffer = getCurrentOffer();
			return cutNumber(curOffer.sumMax);
		},

		setCheckboks = function(){
			let descr0 = '<a href="#" class="b-sber-auth-link">Войдите по СберБизнес ID</a>, чтобы увидеть условия',
			title0 = 'В рассрочку, 30 дней без процентов';
			if(getCurrentOffer() == null) {
				$btn0.parents('.form-check').hide();
				return;
			}
			if (sbUserB2b) { 
				title0 = 'В рассрочку на '+getRasDays()+' дней без процентов';
				descr0 = getRasProc()+' % в месяц с '+getRasDays(true)+' дня, до '+getRasMax()+'<br>От ПАО Сбербанк';
			}
			$btn0.html(descr0)
				.parents('.index_checkout-delivery_text')
				.find('.index_checkout-radios_title')
				.html(title0);

			$('.b-sber-auth-link').on('click', function(e){
				e.preventDefault();
				const $this = $(this);
				if (!$this.hasClass('m-loading')) {
					$this.addClass('m-loading');
					$.post('/sb/api.php', {
						action: 'authlink',
						loc: window.location.pathname + window.location.search
					}, function(data){
						if(data.link) {
							window.location = data.link;
						}
					});
				}
			});

			if ($btn0.parents('.form-check-label').find('input').is(':checked')) {
				$('#ORDER_CONFIRM_BUTTON').parent().addClass('previewButton');

				new CredInBaskSDK(
					params,
					onSuccessCallback,
					onCancelCallback,
					onErrorCallback,
					onOpenModalCallback,
					onSelectedProduct
				);
				$('body').addClass('m-spec');
			} else {
				$('body').removeClass('m-spec');
			}

			if ($('.b-popup').length) {
				var $btn = $('#i-credit-button').clone();
				$btn.addClass('m-cloned').on('click', function(e){
					e.preventDefault();
					$('.b-popup').css('display', 'flex');
				})
				$btn.insertAfter($('#i-credit-button'));
				$('#i-credit-button:not(.m-cloned)').remove();
			}
		},

		clickBtn = function(e){

		};

		$('body').append('<div class="previewModal"></div><div class="previewButton"></div>');



		setInterval(function(){
			$btn0 = $('.b-sber-descr');
			if ($btn0.length && !$btn0.hasClass('m-activated')) {
				$btn0.addClass('m-activated');
				setCheckboks();
			}
		}, 100);
	}
}, 100); 
