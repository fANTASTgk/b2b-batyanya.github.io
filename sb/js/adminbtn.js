let waiJqIntervalAdminBtn = setInterval(function(){
	if (typeof($) != 'undefined') {
		clearInterval(waiJqIntervalAdminBtn);

		let $li = $('<li class="nav-item">Сохранить как админ аккаунт</li>')
		$li.css({
			lineHeight: '39px',
			textDecoration: 'underline',
			cursor: 'pointer'
		});
		$li.on('click', function(e){
			e.preventDefault();
			$.post('/sb/api.php', {action: 'setcompanyaccess'}, function(d){
				$li.text('Изменили');
				setTimeout(function(){
					$li.text('Сохранить как админ аккаунт');
				}, 4000);
			});
		});
		$('#navbar-footer').find('ul').prepend($li);
	}
}, 100); 
