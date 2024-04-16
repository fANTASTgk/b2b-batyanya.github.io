let waiJqInterval = setInterval(function(){
	if (typeof($) != 'undefined') {
		clearInterval(waiJqInterval);

		function numberWithSpaces(x) {
			var parts = x.toString().split(".");
			parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, " ");
			return parts.join(".");
		}

		if (typeof(sbUserB2b) == 'object') {
			let HtmlUerInfo = '';
			HtmlUerInfo += '<div class="b-sber-info m-3 order-xl-1'+(sbUserB2b.hasActiveCreditLine ? '' : ' m-nolimit')+'">';
			HtmlUerInfo += '<div class="b-sber-info-icon"></div>';
			if (sbUserB2b.hasActiveCreditLine) {
				HtmlUerInfo += '<div class="b-sber-info-text">';
				HtmlUerInfo += '<div class="b-sber-info-text-first">Лимит с рассрочкой</div>';
				HtmlUerInfo += '<div class="b-sber-info-text-last">' + numberWithSpaces(sbUserB2b.creditLineAvailableSum) + ' RUB</div>';
				HtmlUerInfo += '</div>';
			} else {
				HtmlUerInfo += '<a href="http://www.sberbank.ru/businesscredit/partner/info?id=batyanya&site=https://batyanya.ru/&utm_source=batyanya&utm_medium=banner&utm_campaign=credit" target="_blank" class="b-sber-info-link">О покупках<br>в рассрочку</a>';
			}
			HtmlUerInfo += '</div>';

			$(HtmlUerInfo).insertAfter('.b2bcabinet-navbar-2__user-wrap');
		} else {
			let htmlAuth = '';
			htmlAuth += '<div class="b-sber-auth m-3 order-xl-1">';
			htmlAuth += '<div class="b-sber-auth-wrap">';
			htmlAuth += '<div class="b-sber-auth-icon"></div>';
			htmlAuth += '<div class="b-sber-auth-text">Войти по СберБизнес ID</div>';
			htmlAuth += '</div>';
			htmlAuth += '<div class="b-sber-auth-loading"></div>';
			htmlAuth += '</div>';
	
			$(htmlAuth).insertAfter('.b2bcabinet-navbar-2__user-wrap');

			$('.b-sber-auth').on('click', function(e){
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
		}

		var $popup = $('.b-popup');
		if ($popup.length) {
			if (!localStorage.getItem('sb-popup-showed')) {
				$popup.css({display: 'flex'});
				localStorage.setItem('sb-popup-showed', 1);
			}
			$popup.find('button').on('click', function(e){
				e.preventDefault();
				localStorage.setItem('sb-popup-showed', 1);
				$popup.css({display: 'none'});
			});
		}
	}
}, 100); 
