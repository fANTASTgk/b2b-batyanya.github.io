function refreshModal(params, onSuccessCallback, onCancelCallback, onErrorCallback, onOpenModalCallback, onSelectedProduct, onSelectedPartialPayment) {
    params.repeatOpen = true;
    if (params && params.creditProducts && params.creditProducts.length>0)
        var obj = new CredInBaskSDK(params,onSuccessCallback, onCancelCallback, onErrorCallback, onOpenModalCallback, onSelectedProduct, onSelectedPartialPayment);
}

function updateButtomText(text) {
    var crButtonSpan = document.getElementById('i-credit-button').getElementsByClassName("sbid-button__text")[0];
    crButtonSpan.textContent = text;
}

(function (exports) {
    'use sctrict';
    var MODAL_ID = 'creditInBasketModal';
    var PRODUCT_CODE_VCL = ['MB-K-ip-225', 'MB-K-oo-226'];

    var Utils = (function () {
        function Utils() {
        }

        /**
         * Форматирование строки с добавлением дополнительных параметров
         * @param {String} str - исходная строка
         */
        Utils.stringFormat = function (str, params) {
            if (typeof params === 'object' && typeof str !== 'undefined') {
                Object.keys(params).forEach(function (k) {
                    str = str.replace(new RegExp(':' + k + ':', 'g'), params[k]);
                });

                return str;
            }
            return str;
        };

        /**
         * Преобразовать стили из объкта в строку
         * @param {Object} obj - стили CSS
         * @return {string}
         */
        Utils.objToCss = function (obj) {
            if (!obj) {
                return '';
            }

            return JSON.stringify(obj, null, '\t')
                .replace(/"/g, '')
                .replace(/,\n/g, ';')
                .replace(/\}/g, '')
                .replace(/\{/g, '')
        };

        Utils.prettyNumber = function (obj) {
            if (obj)
                return obj.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
            return '';
        };

        return Utils;
    })();

    var CredInBaskSDK = (function () {

        /**
         * Получить стили для логотипа на кнопке
         * @return {{logoHeight: string, logoWidth: string, logoFill: *}}
         */
        CredInBaskSDK.prototype.getLogoStyle = function () {
            return {
                'margin-left': '24px',
            }
        };

        /**
         * Получить стили текста на кнопке
         */
        CredInBaskSDK.prototype.getTextButtonStyle = function () {
            return {
                'display': 'flex',
                'align-items': 'center',
                'text-align': 'center',
                'margin': '12px 36px 12px 8px',
                'font-family': 'SB Sans Interface',
                'font-style': 'normal',
                'font-weight': 'normal',
                'font-size': '14px',
                'line-height': '16px',
                'color': '#FFFFFF'
            }
        };

        /**
         * Получить стили кнопки
         */
        CredInBaskSDK.prototype.getButtonStyle = function () {
            return {
                'text-decoration': 'none',
                'cursor': 'pointer',
                'display': 'inline-flex',
                'align-items': 'center',
                'justify-content': 'center',
                'box-shadow': 'none',
                'background': '#107F8C',
                'border-radius': '8px'
            }
        };

        CredInBaskSDK.prototype.getButtonWhiteStyle = function () {
            return {
                'text-decoration': 'none',
                'cursor': 'pointer',
                'display': 'inline-flex',
                'align-items': 'center',
                'justify-content': 'center',
                'box-shadow': 'none',
                'background': '#FFFFFF',
                'border': '1px solid #D0D7DD',
                'border-radius': '8px'
            }
        };

        /**
         * Получить стили кнопки hover
         */
        CredInBaskSDK.prototype.getButtonHoverStyle = function () {
            return {
                'background': '#21a19a',
                'text-decoration': 'none',
                'cursor': 'pointer',
                'display': 'inline-flex',
                'align-items': 'center',
                'justify-content': 'center',
                'box-shadow': 'none',
                'border-radius': '8px'
            }
        };

        CredInBaskSDK.prototype.getButtonHoverWhiteStyle = function () {
            return {
                'background': '#FFFFFF',
                'text-decoration': 'none',
                'cursor': 'pointer',
                'display': 'inline-flex',
                'align-items': 'center',
                'justify-content': 'center',
                'box-shadow': 'none',
                'border': '1px solid #1F1F22',
                'border-radius': '8px'
            }
        };

        /**
         * Получить стили кнопки press
         */
        CredInBaskSDK.prototype.getButtonPressedStyle = function () {
            return {
                'background': '#005E7F',
                'text-decoration': 'none',
                'cursor': 'pointer',
                'display': 'inline-flex',
                'align-items': 'center',
                'justify-content': 'center',
                'box-shadow': 'none',
                'border-radius': '8px'
            }
        };

        CredInBaskSDK.prototype.getButtonPressedWhiteStyle = function () {
            return {
                'background': '#D0D7DD',
                'text-decoration': 'none',
                'cursor': 'pointer',
                'display': 'inline-flex',
                'align-items': 'center',
                'justify-content': 'center',
                'box-shadow': 'none',
                'border': '2px solid #FFDD64',
                'border-radius': '8px'
            }
        };

        /**
         * Получить стили модального окна
         */
        CredInBaskSDK.prototype.getModalStyle = function () {
            return {
                'display': 'block',
                'position': 'fixed',
                'z-index': 1,
                'left': 0,
                'top': 0,
                'width': '100%',
                'height': '100%',
                'background-color': 'rgba(0,0,0,0.7)'
            };
        };

        /**
         * Получить стили содержимого модального окна
         */
        CredInBaskSDK.prototype.getModalContentStyle = function () {
            return {
                'border': 'none',
                'height': '404px',
                'max-width': '648px',
                'padding-top': '10%',
                'margin': '0 auto'
            };
        };

        /**
         * Получить стили содержимого модального окна после заголовка
         */
        CredInBaskSDK.prototype.getModalContentInnerStyle = function () {
            return {
                'border': 'none',
                'width': '100%',
                'display': 'inline-flex',
                'height': '100%'
            };
        };

        /**
         * Получить стили содержимого правой части модального окна
         */
        CredInBaskSDK.prototype.getModalContentInnerRightStyle = function () {
            return {
                'margin-top': '16px',
                'margin-left': '16px',
                'cursor': 'pointer'
            };
        };

        /**
         * Получить стили содержимого левой части модального окна
         */
        CredInBaskSDK.prototype.getModalContentInnerLeftStyle = function () {
            return {
                'width': '95%',
                'border-radius': '16px 16px 0px 0px'
            };
        };

        /**
         * Получить стили содержимого левой части модального окна
         */
        CredInBaskSDK.prototype.getModalContentInnerLeftContentStyle = function () {
            return {
                'background-color': 'white',
                'padding': '0px 32px',
                'display': 'block',
                'overflow': 'auto',
                'height': 'calc(100% - 160px)',
                'text-align': 'center'
            };
        };

        /**
         * Получить стили содержимого заголовка левой части модального окна
         */
        CredInBaskSDK.prototype.getModalContentInnerLeftHeaderStyle = function () {
            return {
                'background': '#F2F4F7',
                'font-family': 'SB Sans Interface',
                'font-style': 'normal',
                'font-weight': '600',
                'font-size': '21px',
                'line-height': '32px',
                'height': '80px',
                'padding': '0px 32px',
                'color': '#1F1F22',
                'border-radius': '16px 16px 0px 0px'
            };
        };

        /**
         * Получить стили содержимого футера левой части модального окна
         */
        CredInBaskSDK.prototype.getModalContentInnerLeftFooterStyle = function () {
            return {
                'background': '#F2F4F7',
                'font-family': 'SB Sans Interface',
                'font-style': 'normal',
                'font-weight': '600',
                'font-size': '21px',
                'line-height': '32px',
                'height': '80px',
                'padding': '0px 32px',
                'color': '#1F1F22',
                'text-align': 'right',
                'border-radius': '0px 0px 16px 16px'
            };
        };

        /**
         * Получить стили текста на кнопке с белым фоном c logo
         */
        CredInBaskSDK.prototype.getTextButtonWhiteLogoStyle = function () {
            return {
                'font-family': 'SB Sans Interface',
                'font-style': 'normal',
                'font-weight': '500',
                'font-size': '14px',
                'line-height': '16px',
                'display': 'flex',
                'align-items': 'center',
                'text-align': 'center',
                'color': '#1F1F22',
                'margin': '12px 36px 12px 8px'
            }
        };

        /**
         * Получить стили текста на кнопке с белым фоном
         */
        CredInBaskSDK.prototype.getTextButtonWhiteStyle = function () {
            return {
                'font-family': 'SB Sans Interface',
                'font-style': 'normal',
                'font-weight': '500',
                'font-size': '14px',
                'line-height': '16px',
                'display': 'flex',
                'align-items': 'center',
                'text-align': 'center',
                'color': '#1F1F22',
                'margin': '24px'
            }
        };

        /**
         * Получить стили кнопки с белым фоном press
         */
        CredInBaskSDK.prototype.getButtonPressedModalWhiteStyle = function () {
            return {
                'text-decoration': 'none',
                'cursor': 'pointer',
                height: '32px',
                display: 'inline-flex',
                'align-items': 'center',
                'justify-content': 'center',
                'box-shadow': 'none',
                'border-radius': '16px',
                'background': '#D0D7DD',
                'box-sizing': 'border-box',
                'border': '2px solid #FFDD64'
            }
        };

        /**
         * Получить стили кнопки с белым фоном hover
         */
        CredInBaskSDK.prototype.getButtonHoverModalWhiteStyle = function () {
            return {
                'text-decoration': 'none',
                'cursor': 'pointer',
                height: '32px',
                display: 'inline-flex',
                'align-items': 'center',
                'justify-content': 'center',
                'box-shadow': 'none',
                'border-radius': '16px',
                'background': '#FFFFFF',
                'box-sizing': 'border-box',
                'border': '1px solid #1F1F22'
            }
        };

        /**
         * Получить стили кнопки с белым фоном
         */
        CredInBaskSDK.prototype.getButtonModalWhiteStyle = function () {
            return {
                'text-decoration': 'none',
                'cursor': 'pointer',
                height: '32px',
                display: 'inline-flex',
                'align-items': 'center',
                'justify-content': 'center',
                'box-shadow': 'none',
                'border-radius': '16px',
                'background': '#FFFFFF',
                'border': '1px solid #D0D7DD',
                'box-sizing': 'border-box'
            }
        };

        /**
         * Получить стили текста на кнопке с зеленым фоном
         */
        CredInBaskSDK.prototype.getTextButtonGreenStyle = function () {
            return {
                'font-family': 'SB Sans Interface',
                'font-style': 'normal',
                'font-weight': '500',
                'font-size': '14px',
                'line-height': '16px',
                'display': 'flex',
                'align-items': 'center',
                'text-align': 'center',
                'color': '#FFFFFF',
                'margin': '24px'
            }
        };

        /**
         * Получить стили кнопки с зеленым фоном press
         */
        CredInBaskSDK.prototype.getButtonPressedModalGreenStyle = function () {
            return {
                'text-decoration': 'none',
                'cursor': 'pointer',
                height: '32px',
                display: 'inline-flex',
                'align-items': 'center',
                'justify-content': 'center',
                'box-shadow': 'none',
                'background': '#005E7F',
                'border-radius': '16px',
                'margin-left': '16px'
            }
        };

        /**
         * Получить стили кнопки с зеленым фоном hover
         */
        CredInBaskSDK.prototype.getButtonHoverModalGreenStyle = function () {
            return {
                'text-decoration': 'none',
                'cursor': 'pointer',
                height: '32px',
                display: 'inline-flex',
                'align-items': 'center',
                'justify-content': 'center',
                'box-shadow': 'none',
                'background': '#21a19a',
                'border-radius': '16px',
                'margin-left': '16px'
            }
        };

        /**
         * Получить стили кнопки с зеленым фоном
         */
        CredInBaskSDK.prototype.getButtonModalGreenStyle = function () {
            return {
                'text-decoration': 'none',
                'cursor': 'pointer',
                height: '32px',
                display: 'inline-flex',
                'align-items': 'center',
                'justify-content': 'center',
                'box-shadow': 'none',
                'background': '#107F8C',
                'border-radius': '16px',
                'margin-left': '16px'
            }
        };

        /**
         * Создать экземпляр CredInBaskSDK
         * @param {Object} config - настройки модуля
         * @param {Function} onSuccessCallback - функция обратного вызова при успешной отправке заявки
         * @param {Function} onCancelCallback - функция обратного вызова при закрытии модального окна
         * @param {Function} onErrorCallback - функция обратного вызова при передачи пустого списка продуктов
         * @param {Function} onOpenModalCallback - функция обратного вызова при открытии модального окна
         * @param {Function} onSelectedProduct - функция получения выбранного продута и суммы заказа
         * @param {Function} onSelectedPartialPayment - Функция получения выбранного значения возможности частичного платежа
         * @constructor
         */
        function CredInBaskSDK(config, onSuccessCallback, onCancelCallback, onErrorCallback, onOpenModalCallback, onSelectedProduct, onSelectedPartialPayment) {
            this.BUTTON_THEME = {
                default: {
                    backgroundColor: '#08a652',
                    borderColor: '#08a652',
                    color: '#fff',
                    fill: '#fff',
                    borderRadius: 4
                },
                white: {
                    backgroundColor: '#fff',
                    borderColor: '#767676',
                    color: '#000',
                    fill: '#08a652',
                    borderRadius: 4
                }
            };

            this.onSuccessCallback = onSuccessCallback;
            this.onCancelCallback = onCancelCallback;
            this.onErrorCallback = onErrorCallback;
            this.onOpenModalCallback = onOpenModalCallback;
            this.onSelectedProduct = onSelectedProduct;
            this.onSelectedPartialPayment = onSelectedPartialPayment;
            if (!config) {
                config = {
                    style: {
                        theme: 'default'
                    },
                    containerModal: 'preview',
                    containerButton: 'preview'
                }
            }
            this.mergeTheme(config);
            this.onInit(config);
        }

        /**
         * Объединение свойств для генерации кнопок
         * @param {Object} config - настройки модуля
         */
        CredInBaskSDK.prototype.mergeTheme = function (config) {
            var style = Object.assign({}, {
                theme: 'default'
            }, config.style || {});

            if (Object.keys(this.BUTTON_THEME).indexOf(style.theme) === -1) {
                style.theme = 'default';
            }

            this.config = Object.assign({}, config, {
                style: style
            });
        };

        /**
         * Инициализация модуля CredInBaskSDK
         */
        CredInBaskSDK.prototype.onInit = function (params) {
            var mainDiv = document.createElement('table');
            var first = document.createElement('tr');
            var second = document.createElement('tr');
            second.setAttribute('style', 'text-align: center;margin-right:8px;margin-top:2px;');
            second.innerHTML = '<td></td><td style="font-family: SB Sans Interface;font-size: 10px;line-height: 16px;text-align: center;color: #B2B8BF;">Для оформления вы перейдете в СберБизнес</td>';

            var firstLink = document.createElement('td');
            firstLink.setAttribute('style', 'text-align: center;');
            firstLink.innerHTML = Utils.stringFormat('<div style="display: inline-flex; align-items: center;padding-right: 28px;"><a target="_blank" rel="noopener noreferrer" href="https://www.sberbank.ru/businesscredit/partner/info#application" style="font-family: SB Sans Interface;' +
                'font-size: 14px;line-height: 20px;display: flex;align-items: center;color: #1358BF;text-decoration: none;">Подробнее об условиях<span style="margin-left:6px;display:inline-flex;align-items:center;"><svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                '<path d="M3.1875 2C2.63522 2 2.1875 2.44772 2.1875 3V11C2.1875 11.5523 2.63522 12 3.1875 12H11.1875C11.7398 12 12.1875 11.5523 12.1875 11V10.5C12.1875 9.94771 12.6352 9.5 13.1875 9.5C13.7398 9.5 14.1875 9.94771 14.1875 10.5V11C14.1875 12.6569 12.8444 14 11.1875 14H3.1875C1.53065 14 0.1875 12.6569 0.1875 11V3C0.1875 1.34315 1.53065 0 3.1875 0H3.6875C4.23978 0 4.6875 0.447715 4.6875 1C4.6875 1.55228 4.23978 2 3.6875 2H3.1875Z" fill="#1358BF"/>' +
                '<path d="M6.6875 1C6.6875 0.447715 7.13522 0 7.6875 0H12.1875C13.2921 0 14.1875 0.895431 14.1875 2V6.5C14.1875 7.05228 13.7398 7.5 13.1875 7.5C12.6352 7.5 12.1875 7.05228 12.1875 6.5V3.41421L7.39461 8.20711C7.00408 8.59763 6.37092 8.59763 5.98039 8.20711C5.58987 7.81658 5.58987 7.18342 5.98039 6.79289L10.7733 2H7.6875C7.13522 2 6.6875 1.55228 6.6875 1Z" fill="#1358BF"/>' +
                '</svg></span></a></div>');

            var firstButton = document.createElement('td');
            this.crButton = this.createCreditButton(params);
            firstButton.appendChild(this.crButton);
            firstButton.setAttribute('style', 'text-align: center;');

            first.appendChild(firstLink);
            first.appendChild(firstButton);
            mainDiv.appendChild(first);
            mainDiv.appendChild(second);

            var containerButton = document.getElementsByClassName(this.config.containerButton)[0];
            if (containerButton) {
                while(containerButton.firstChild) {
                    containerButton.removeChild(containerButton.firstChild);
                }
            }
            if (containerButton) {
                containerButton.appendChild(mainDiv);
                this.addEventListener(params);
            }
        };

        CredInBaskSDK.prototype.addEventListener = function () {
            var modal = this;
            this.crButton.addEventListener('click', function () {
                var containerModal = document.getElementsByClassName(modal.config.containerModal)[0];
                if (containerModal) {
                    while(containerModal.firstChild) {
                        containerModal.removeChild(containerModal.firstChild);
                    }
                }
                if (containerModal) {
                    if (!modal.config.creditAvailable) {
                        modal.onOpenModalCallback();
                        containerModal.appendChild(modal.createModal(modal.modalCreditNotAvailable(), modal.createModalContentInnerLeftBackToShopFooter()));
                    } else if (!modal.config.creditProducts || modal.config.creditProducts.length === 0) {
                        modal.onErrorCallback({result: 'не передано ни одного кредитного продукта'});
                    } else {
                        var selected = modal.onSelectedProduct();
                        if (!selected || !selected.amount || selected.amount <=0) {
                            modal.onErrorCallback({result: 'Сумма заказа не может быть меньше нуля'});
                            return false;
                        }
                        if (!selected.productCode) {
                            modal.onErrorCallback({result: 'Нет данных о выбранном продукте'});
                            return false;
                        }
                        var product = modal.getProductByCode(selected.productCode);
                        if (!product) {
                            modal.onErrorCallback({result: 'Код продукта не найден'});
                        } else if (product.sumMax < selected.amount) {
                            modal.onOpenModalCallback();
                            containerModal.appendChild(modal.createModal(modal.modalOverSum(product.sumMax), modal.createModalContentInnerLeftBackToShopFooter()));
                        } else if (PRODUCT_CODE_VCL.includes(selected.productCode)) {
                            var selectedPartialPayment = {availablePartialPayment: true} ;
                            if (typeof modal.onSelectedPartialPayment !== 'undefined' && typeof modal.onSelectedPartialPayment === 'function') {
                                selectedPartialPayment = modal.onSelectedPartialPayment();
                            }
                            if (product.contractNumber) {
                                if (product.availableSum) {
                                    var isAvailablePartialPayment = true;
                                    if (selectedPartialPayment.availablePartialPayment === false) {
                                        isAvailablePartialPayment = false
                                    } else if (selectedPartialPayment.availablePartialPayment === true) {
                                        isAvailablePartialPayment = true
                                    } else if (product.availablePartialPayment === false){
                                        isAvailablePartialPayment = false
                                    }
                                    modal.onOpenModalCallback();
                                    containerModal.appendChild(modal.createModal(modal.modalWithActiveVCL({
                                        creditAmount: selected.amount,
                                        availableSum: product.availableSum,
                                        creditTerm: product.termMax,
                                        productCode: selected.productCode,
                                        contractNumber: product.contractNumber,
                                        sumMin: product.sumMin,
                                        isAvailablePartialPayment
                                    }), modal.createModalContentInnerLeftAcceptVCLFooter({
                                        creditAmount: selected.amount,
                                        availableSum: product.availableSum,
                                        creditTerm: product.termMax,
                                        sumMax: product.sumMax,
                                        sumMin: product.sumMin,
                                        productCode: selected.productCode,
                                        contractNumber: product.contractNumber,
                                        isAvailablePartialPayment
                                    })));
                                } else {
                                    modal.onErrorCallback({result: 'Не передана сумма по действующей кредитной линии'});
                                }
                            } else {
                                if (product.sumMin <= selected.amount) {
                                    modal.onSuccessCallback({
                                        creditAmount:selected.amount,
                                        creditTerm: product.termMax,
                                        productCode: selected.productCode,
                                        utm_source: 'V2'
                                    });
                                } else {
                                    modal.onOpenModalCallback();
                                    containerModal.appendChild(modal.createModal(
                                        modal.modalUnderSumVCL(product.sumMin, selected.amount),
                                        modal.createModalContentInnerLeftAcceptVCLFooter(
                                            {
                                                creditAmount: selected.amount,
                                                availableSum: product.availableSum,
                                                creditTerm: product.termMax,
                                                sumMax: product.sumMax,
                                                sumMin: product.sumMin,
                                                productCode: selected.productCode,
                                                contractNumber: product.contractNumber
                                            }
                                        )));
                                }
                            }
                        } else {
                            if (product.sumMin <= selected.amount) {
                                modal.onSuccessCallback({
                                    creditAmount: selected.amount,
                                    creditTerm: product.termMax,
                                    productCode: selected.productCode,
                                    utm_source: 'V2'
                                });
                            } else {
                                modal.onOpenModalCallback();
                                containerModal.appendChild(modal.createModal(modal.modalUnderSum(product.sumMin), modal.createModalContentInnerLeftBackToShopFooter()));
                            }
                        }
                    }
                }
            });
        };

        CredInBaskSDK.prototype.getProductByCode = function (productCode) {
            var creditProducts = this.config.creditProducts;
            for (var i = 0; i < creditProducts.length; i++) {
                if (creditProducts[i].productCode === productCode)
                    return creditProducts[i];
            }
            return null;
        };

        /**
         * Создать кнопку покупки в кредит
         */
        CredInBaskSDK.prototype.createCreditButton = function (params) {
            var crButton = document.createElement('a');
            crButton.id = 'i-credit-button';

            var buttonText = "Оплатить покупку";
            var buttonStyle = Utils.objToCss(this.getButtonStyle());
            var buttonHoverStyle = Utils.objToCss(this.getButtonHoverStyle());
            var buttonPressedStyle = Utils.objToCss(this.getButtonPressedStyle());
            var buttonTextStyle = Utils.objToCss(this.getTextButtonStyle());
            var logoSpan = '<svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                '<path d="M11.1247 10.6906L6.9375 8.06564V11.2235L11.1247 13.8484L21.1477 6.46197C20.7932 5.68016 20.3492 4.94712 19.8294 4.27522L11.1247 10.6906Z" fill="white"/>\n' +
                '<path d="M22.125 11C22.125 10.3274 22.0646 9.66859 21.9488 9.02945L19.5808 10.7743C19.583 10.8493 19.5837 10.9243 19.5837 11C19.5837 15.664 15.789 19.4587 11.125 19.4587C6.46105 19.4587 2.66626 15.664 2.66626 11C2.66626 6.33605 6.46105 2.54126 11.125 2.54126C12.8925 2.54126 14.5354 3.08649 15.8938 4.01754L18.0332 2.4408C16.1449 0.915029 13.742 0 11.125 0C5.04956 0 0.125 4.92456 0.125 11C0.125 17.0754 5.04956 22 11.125 22C17.2004 22 22.125 17.0754 22.125 11Z" fill="white"/>\n' +
                '</svg>';
            if (params.buttonStyle.theme === 'white') {
                buttonStyle = Utils.objToCss(this.getButtonWhiteStyle());
                buttonHoverStyle = Utils.objToCss(this.getButtonHoverWhiteStyle());
                buttonPressedStyle = Utils.objToCss(this.getButtonPressedWhiteStyle());
                buttonTextStyle = Utils.objToCss(this.getTextButtonWhiteLogoStyle());
                logoSpan = '<svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                    '<path d="M11.1247 10.6906L6.9375 8.06564V11.2235L11.1247 13.8484L21.1477 6.46197C20.7932 5.68016 20.3492 4.94712 19.8294 4.27522L11.1247 10.6906Z" fill="#107F8C"/>\n' +
                    '<path d="M22.125 11C22.125 10.3274 22.0646 9.66859 21.9488 9.02945L19.5808 10.7743C19.583 10.8493 19.5837 10.9243 19.5837 11C19.5837 15.664 15.789 19.4587 11.125 19.4587C6.46105 19.4587 2.66626 15.664 2.66626 11C2.66626 6.33605 6.46105 2.54126 11.125 2.54126C12.8925 2.54126 14.5354 3.08649 15.8938 4.01754L18.0332 2.4408C16.1449 0.915029 13.742 0 11.125 0C5.04956 0 0.125 4.92456 0.125 11C0.125 17.0754 5.04956 22 11.125 22C17.2004 22 22.125 17.0754 22.125 11Z" fill="#107F8C"/>\n' +
                    '</svg>';
            }

            if (params.buttonStyle.text) {
                buttonText = params.buttonStyle.text;
            }

            if (params.buttonStyle.type === 'rounded') {
                buttonStyle = buttonStyle + ';border-radius: 20px';
                buttonHoverStyle = buttonHoverStyle + ';border-radius: 20px';
                buttonPressedStyle = buttonPressedStyle + ';border-radius: 20px';
            }

            if (params.buttonStyle.size === 'small') {
                buttonStyle = buttonStyle + ';height: 32px';
                buttonHoverStyle = buttonHoverStyle + ';height: 32px';
                buttonPressedStyle = buttonPressedStyle + ';height: 32px';
            } else {
                buttonStyle = buttonStyle + ';height: 40px';
                buttonHoverStyle = buttonHoverStyle + ';height: 40px';
                buttonPressedStyle = buttonPressedStyle + ';height: 40px';
            }

            crButton.setAttribute('style', buttonStyle);

            crButton.innerHTML = Utils.stringFormat('<span class="sbid-button__logo" style="margin-left:36px; height: 22px;">'+logoSpan+'</span><span style=":textStyle:" class="sbid-button__text">:text:</span>', Object.assign({
                text: buttonText,
                textStyle: buttonTextStyle
            }, this.getLogoStyle()));

            crButton.addEventListener('mousedown', function (event) {
                this.setAttribute('style', buttonPressedStyle);
            });
            crButton.addEventListener("mouseover", function (event) {
                this.setAttribute('style', buttonHoverStyle);
            }, false);
            crButton.addEventListener("mouseout", function (event) {
                this.setAttribute('style', buttonStyle);
            });

            return crButton;
        };

        CredInBaskSDK.prototype.modalOverSum = function (sumMax) {
            var div = document.createElement('div');
            div.setAttribute('style', Utils.objToCss(this.getModalContentInnerLeftContentStyle()));

            var icon = document.createElement('div');
            icon.innerHTML = '<svg width="96" height="96" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                '<circle cx="48" cy="48" r="48" fill="#FF9900"/>' +
                '<path d="M51 24C51 22.3431 49.6569 21 48 21C46.3431 21 45 22.3431 45 24V57C45 58.6569 46.3431 60 48 60C49.6569 60 51 58.6569 51 57V24Z" fill="white"/>' +
                '<path d="M51 69C51 67.3431 49.6569 66 48 66C46.3431 66 45 67.3431 45 69C45 70.6569 46.3431 72 48 72C49.6569 72 51 70.6569 51 69Z" fill="white"/>' +
                '</svg>';
            icon.setAttribute('style', 'padding-top: 48px; padding-bottom: 16px;');

            var text = document.createElement('div');
            text.innerHTML = 'Оплатить данным способом возможно не более ' + Utils.prettyNumber(sumMax) + ' RUB.<br/>Выберите другой способ или уменьшите количество товаров в корзине.';
            text.setAttribute('style', 'font-family: SB Sans Interface;font-size: 14px;line-height: 20px;text-align: center;color: #1F1F22;');

            div.appendChild(icon);
            div.appendChild(text);
            return div;
        };

        CredInBaskSDK.prototype.modalUnderSum = function (sumMin) {
            var div = document.createElement('div');
            div.setAttribute('style', Utils.objToCss(this.getModalContentInnerLeftContentStyle()));

            var icon = document.createElement('div');
            icon.innerHTML = '<svg width="96" height="96" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                '<circle cx="48" cy="48" r="48" fill="#FF9900"/>' +
                '<path d="M51 24C51 22.3431 49.6569 21 48 21C46.3431 21 45 22.3431 45 24V57C45 58.6569 46.3431 60 48 60C49.6569 60 51 58.6569 51 57V24Z" fill="white"/>' +
                '<path d="M51 69C51 67.3431 49.6569 66 48 66C46.3431 66 45 67.3431 45 69C45 70.6569 46.3431 72 48 72C49.6569 72 51 70.6569 51 69Z" fill="white"/>' +
                '</svg>';
            icon.setAttribute('style', 'padding-top: 48px; padding-bottom: 16px;');

            var text = document.createElement('div');
            text.innerHTML = 'Оплатить данным способом возможно не менее ' + Utils.prettyNumber(sumMin) + ' RUB.<br/>Выберите другой способ или увеличьте количество товаров в корзине.';
            text.setAttribute('style', 'font-family: SB Sans Interface;font-size: 14px;line-height: 20px;text-align: center;color: #1F1F22;');

            div.appendChild(icon);
            div.appendChild(text);
            return div;
        };

        CredInBaskSDK.prototype.modalUnderSumVCL = function (sumMin, creditAmount) {
            var div = document.createElement('div');
            div.setAttribute('style', Utils.objToCss(this.getModalContentInnerLeftContentStyle()));
            div.style.height = '290px';

            var infoDiv = document.createElement('div');
            infoDiv.setAttribute('style', 'margin-top: 24px; padding: 16px; background: #F2F8FF;border: 1px solid #1358BF;box-sizing: border-box;border-radius: 8px;display: inline-flex;width:100%;font-family: SB Sans Interface;text-align: left;font-size: 14px;line-height: 20px;color: #1F1F22;');
            infoDiv.innerHTML =
                '<span style="margin-right: 8px;padding-top: 2px;height: 16px;display: inline-block;">' +
                '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                '<path d="M8 0C3.5888 0 0 3.588 0 8C0 12.412 3.5888 16 8 16C12.4112 16 16 12.412 16 8C16 3.588 12.4112 0 8 0Z" fill="#1358BF"/>' +
                '<path d="M8 3C7.44772 3 7 3.44772 7 4V8C7 8.55228 7.44772 9 8 9C8.55228 9 9 8.55228 9 8V4C9 3.44772 8.55228 3 8 3Z" fill="white"/>' +
                '<path d="M9 12C9 12.5523 8.55228 13 8 13C7.44772 13 7 12.5523 7 12C7 11.4477 7.44772 11 8 11C8.55228 11 9 11.4477 9 12Z" fill="white"/>' +
                '</svg></span><span>Лимит с рассрочкой будет оформлен на ' + Utils.prettyNumber(sumMin) + ' рублей. После оплаты заказа, остаток сможете использовать для новых покупок.<br />' +
                'За неиспользованный лимит платить не нужно.</span>';
            div.appendChild(infoDiv);

            var table = document.createElement('table');
            table.setAttribute('style', 'width: 100%;font-family: SB Sans Interface;font-size: 14px;line-height: 20px;color: #1F1F22;text-align: left;padding-top: 24px;');
            var sumTr = document.createElement('tr');
            var sumText = document.createElement('td');
            sumText.setAttribute('style', 'width: 50%;');
            sumText.innerHTML = 'Сумма заказа';
            var sumValue = document.createElement('td');
            sumValue.innerHTML = Utils.prettyNumber(creditAmount) + ' RUB';
            sumTr.appendChild(sumText);
            sumTr.appendChild(sumValue);

            table.appendChild(sumTr);
            div.appendChild(table);

            return div;
        };

        CredInBaskSDK.prototype.modalCreditNotAvailable = function () {
            var div = document.createElement('div');
            div.setAttribute('style', Utils.objToCss(this.getModalContentInnerLeftContentStyle()));

            var icon = document.createElement('div');
            icon.innerHTML = '<svg width="96" height="96" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                '<circle cx="48" cy="48" r="48" fill="#FF9900"/>' +
                '<path d="M51 24C51 22.3431 49.6569 21 48 21C46.3431 21 45 22.3431 45 24V57C45 58.6569 46.3431 60 48 60C49.6569 60 51 58.6569 51 57V24Z" fill="white"/>' +
                '<path d="M51 69C51 67.3431 49.6569 66 48 66C46.3431 66 45 67.3431 45 69C45 70.6569 46.3431 72 48 72C49.6569 72 51 70.6569 51 69Z" fill="white"/>' +
                '</svg>';
            icon.setAttribute('style', 'padding-top: 48px; padding-bottom: 16px;');

            var text = document.createElement('div');
            text.innerHTML = '<span>К сожалению, <a target="_blank" rel="noopener noreferrer" href="https://www.sberbank.ru/businesscredit/partner/info" style="display: inline-flex;align-items: center;text-decoration: none;">по условиям<span style="margin-left:2px;margin-right:4px;display:inline-flex;align-items:center;"><svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                '<path d="M3.1875 2C2.63522 2 2.1875 2.44772 2.1875 3V11C2.1875 11.5523 2.63522 12 3.1875 12H11.1875C11.7398 12 12.1875 11.5523 12.1875 11V10.5C12.1875 9.94771 12.6352 9.5 13.1875 9.5C13.7398 9.5 14.1875 9.94771 14.1875 10.5V11C14.1875 12.6569 12.8444 14 11.1875 14H3.1875C1.53065 14 0.1875 12.6569 0.1875 11V3C0.1875 1.34315 1.53065 0 3.1875 0H3.6875C4.23978 0 4.6875 0.447715 4.6875 1C4.6875 1.55228 4.23978 2 3.6875 2H3.1875Z" fill="#1358BF"/>' +
                '<path d="M6.6875 1C6.6875 0.447715 7.13522 0 7.6875 0H12.1875C13.2921 0 14.1875 0.895431 14.1875 2V6.5C14.1875 7.05228 13.7398 7.5 13.1875 7.5C12.6352 7.5 12.1875 7.05228 12.1875 6.5V3.41421L7.39461 8.20711C7.00408 8.59763 6.37092 8.59763 5.98039 8.20711C5.58987 7.81658 5.58987 7.18342 5.98039 6.79289L10.7733 2H7.6875C7.13522 2 6.6875 1.55228 6.6875 1Z" fill="#1358BF"/>' +
                '</svg></span></a>вам недоступна данная программа.<br/>Выберите другую форму оплаты заказа.</span>';
            text.setAttribute('style', 'font-family: SB Sans Interface;font-size: 14px;line-height: 20px;text-align: center;color: #1F1F22;display: inline-flex; align-items:center;');

            div.appendChild(icon);
            div.appendChild(text);
            return div;
        };

        CredInBaskSDK.prototype.modalWithActiveVCL = function (params) {
            var div = document.createElement('div');
            div.setAttribute('style', Utils.objToCss(this.getModalContentInnerLeftContentStyle()));
            div.style.height = '290px';
            var text = params.isAvailablePartialPayment ? 'Сумма заказа больше доступного лимита. Оформите другой лимит, оплатите часть заказа или выберите другую форму оплаты.' : 'Сумма заказа больше доступного лимита. Оформите другой лимит или выберите другую форму оплаты.';

            if (params.creditAmount > params.availableSum) {
                var infoDiv = document.createElement('div');
                infoDiv.setAttribute('style', 'margin-top: 24px; padding: 16px; background: #FFF5E6;border: 1px solid #FF9900;box-sizing: border-box;border-radius: 8px;display: inline-flex;width:100%;');
                infoDiv.innerHTML = Utils.stringFormat('<span style="margin-right: 8px;padding-top: 2px;height: 16px;display: inline-block;"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                    '<path d="M8 0C3.5888 0 0 3.588 0 8C0 12.412 3.5888 16 8 16C12.4112 16 16 12.412 16 8C16 3.588 12.4112 0 8 0Z" fill="#FF9900"/>' +
                    '<path d="M8 3C7.44772 3 7 3.44772 7 4V8C7 8.55228 7.44772 9 8 9C8.55228 9 9 8.55228 9 8V4C9 3.44772 8.55228 3 8 3Z" fill="white"/>' +
                    '<path d="M9 12C9 12.5523 8.55228 13 8 13C7.44772 13 7 12.5523 7 12C7 11.4477 7.44772 11 8 11C8.55228 11 9 11.4477 9 12Z" fill="white"/>' +
                    '</svg></span><span style="font-family: SB Sans Interface;text-align: left;font-size: 14px;line-height: 20px;color: #1F1F22;">' + text + '</span>');
                div.appendChild(infoDiv);
            }

            var table = document.createElement('table');
            table.setAttribute('style', 'font-family: SB Sans Interface;font-size: 14px;line-height: 20px;color: #1F1F22;text-align: left;padding-top: 24px;');
            var sumTr = document.createElement('tr');
            var sumText = document.createElement('td');
            sumText.innerHTML = 'Сумма заказа';
            var sumValue = document.createElement('td');
            sumValue.innerHTML = Utils.prettyNumber(params.creditAmount)+' RUB';
            sumTr.appendChild(sumText);
            sumTr.appendChild(sumValue);

            var limitTr = document.createElement('tr');
            var limitText = document.createElement('td');
            limitText.innerHTML = 'Доступный лимит для покупки с рассрочкой';
            limitText.setAttribute('style', 'width:195px;padding-top: 16px;padding-right:26px;');
            var limitValue = document.createElement('td');
            limitValue.innerHTML = Utils.prettyNumber(params.availableSum)+' RUB';
            limitTr.appendChild(limitText);
            limitTr.appendChild(limitValue);

            table.appendChild(sumTr);
            table.appendChild(limitTr);
            div.appendChild(table);

            if (params.sumMin > params.creditAmount) {
                var sumUnderDiv = document.createElement('div');
                if (params.creditAmount > params.availableSum) {
                    sumUnderDiv.setAttribute('style', 'margin-top: 50px;font-family: SB Sans Interface;font-size: 12px;line-height: 16px;color: #7D838A;text-align: left;');
                } else {
                    sumUnderDiv.setAttribute('style', 'margin-top: 152px;font-family: SB Sans Interface;font-size: 12px;line-height: 16px;color: #7D838A;text-align: left;');
                }
                sumUnderDiv.innerHTML = Utils.stringFormat("<span>При оформлении другого лимита будет создана заявка от "+ Utils.prettyNumber(params.sumMin) +" RUB.</span>");
                div.appendChild(sumUnderDiv);
            }
            return div;
        };

        /**
         * Создание модального окна
         */
        CredInBaskSDK.prototype.createModal = function (content, footer) {
            var crModal = document.createElement('div');
            crModal.setAttribute('style', Utils.objToCss(this.getModalStyle()));
            crModal.setAttribute('id', MODAL_ID);
            crModal.appendChild(this.createModalContent(content, footer));
            return crModal;
        };

        /**
         * Создать содержимое модального окна
         */
        CredInBaskSDK.prototype.createModalContent = function (content, footer) {
            var crModalContent = document.createElement('div');
            crModalContent.setAttribute('style', Utils.objToCss(this.getModalContentStyle()));

            var crModalInnerContent = document.createElement('div');
            crModalInnerContent.setAttribute('style', Utils.objToCss(this.getModalContentInnerStyle()));
            crModalInnerContent.setAttribute('class', 'crModalInnerContent');

            crModalInnerContent.appendChild(this.createModalInnerLeftContent(content, footer));
            crModalInnerContent.appendChild(this.createModalInnerRightContent());
            crModalContent.appendChild(crModalInnerContent);
            return crModalContent;
        };

        /**
         * Создание блока с основным содержимым модального окна
         */
        CredInBaskSDK.prototype.createModalInnerLeftContent = function (content, footer) {
            var crModalInnerLeftContent = document.createElement('div');
            crModalInnerLeftContent.setAttribute('class', 'mainContentModal');
            crModalInnerLeftContent.setAttribute('style', Utils.objToCss(this.getModalContentInnerLeftStyle()));

            crModalInnerLeftContent.appendChild(this.createModalContentInnerLeftHeader());
            crModalInnerLeftContent.appendChild(content);
            crModalInnerLeftContent.appendChild(footer);
            return crModalInnerLeftContent;
        };

        /**
         * Создание блока с заголовком Покупка в кредит
         */
        CredInBaskSDK.prototype.createModalContentInnerLeftHeader = function () {
            var crModalContentInnerLeftHeader = document.createElement('div');
            var crModalContentInnerLeftHeaderContent = document.createElement('div');
            crModalContentInnerLeftHeaderContent.innerHTML = Utils.stringFormat('Покупка через СберБизнес');
            crModalContentInnerLeftHeaderContent.setAttribute('style', 'position: relative;left: 50%;top: 50%;transform: translate(-50%, -50%);');
            crModalContentInnerLeftHeader.setAttribute('style', Utils.objToCss(this.getModalContentInnerLeftHeaderStyle()));
            crModalContentInnerLeftHeader.appendChild(crModalContentInnerLeftHeaderContent);
            return crModalContentInnerLeftHeader;
        };

        /**
         * Создание футера содержимого модалього окна
         */
        CredInBaskSDK.prototype.createModalContentInnerLeftBackToShopFooter = function () {
            var crModalContentInnerLeftFooter = document.createElement('div');
            crModalContentInnerLeftFooter.setAttribute('style', Utils.objToCss(this.getModalContentInnerLeftFooterStyle()));

            var crModalContentInnerLeftFooterContent = document.createElement('div');
            crModalContentInnerLeftFooterContent.setAttribute('style', 'position: relative;left: 50%;top: 50%;transform: translate(-50%, -50%);');

            var cancelButton = this.createWhiteButton("Вернуться в корзину");
            var onCancelCallback = this.onCancelCallback;
            cancelButton.addEventListener('click', function () {
                var crModal = this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
                crModal.style.display = "none";
                onCancelCallback('Закрытие окна по кнопке возврата в магазин');
                return false;
            });
            crModalContentInnerLeftFooterContent.appendChild(cancelButton);
            crModalContentInnerLeftFooter.appendChild(crModalContentInnerLeftFooterContent);
            return crModalContentInnerLeftFooter
        };

        /**
         * Создание футера содержимого модалього окна
         */
        CredInBaskSDK.prototype.createModalContentInnerLeftAcceptVCLFooter = function (params) {
            var crModalContentInnerLeftFooter = document.createElement('div');
            crModalContentInnerLeftFooter.setAttribute('style', Utils.objToCss(this.getModalContentInnerLeftFooterStyle()));

            var crModalContentInnerLeftFooterContent = document.createElement('div');
            crModalContentInnerLeftFooterContent.setAttribute('style', 'position: relative;left: 50%;top: 50%;transform: translate(-50%, -50%);');
            var onSuccessCallback = this.onSuccessCallback;
            var whiteButton;
            var greenButton;

            if (!params.contractNumber && params.creditAmount < params.sumMin) {
                greenButton = this.createGreenButton('Продолжить');
                greenButton.addEventListener('click', function () {
                    var crModal = this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
                    crModal.style.display = "none";
                    onSuccessCallback({
                        paymentAmount: params.sumMin,
                        creditTerm: params.creditTerm,
                        productCode: params.productCode,
                        utm_source: 'V2'
                    });
                    return false;
                });

                crModalContentInnerLeftFooterContent.appendChild(greenButton);
            } else {
                if (params.creditAmount > params.availableSum) {
                    if (params.isAvailablePartialPayment) {
                        whiteButton = this.createWhiteButton("Оплатить " + Utils.prettyNumber(params.availableSum) + ' RUB');
                        whiteButton.addEventListener('click', function () {
                            var crModal = this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
                            crModal.style.display = "none";
                            onSuccessCallback({
                                paymentAmount: params.availableSum,
                                productCode: params.productCode,
                                contractNumber: params.contractNumber,
                                utm_source: 'V2'
                            });
                        return false;
                        });
                    }

                    greenButton = this.createGreenButton("Оформить другой лимит");
                    greenButton.addEventListener('click', function () {
                        var creditAmountVal = params.creditAmount < params.sumMin ? params.sumMin : params.creditAmount;
                        var crModal = this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
                        crModal.style.display = "none";
                        onSuccessCallback({
                            creditAmount: creditAmountVal,
                            creditTerm: params.creditTerm,
                            productCode: params.productCode,
                            utm_source: 'V2'
                        });
                        return false;
                    });
                } else {
                    whiteButton = this.createWhiteButton('Оформить другой лимит');
                    whiteButton.addEventListener('click', function () {
                        var creditAmountVal = params.creditAmount < params.sumMin ? params.sumMin : params.creditAmount;
                        var crModal = this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
                        crModal.style.display = "none";
                        onSuccessCallback({
                            creditAmount: creditAmountVal,
                            creditTerm: params.creditTerm,
                            productCode: params.productCode,
                            utm_source: 'V2'
                        });
                        return false;
                    });

                    greenButton = this.createGreenButton('Оплатить ' + Utils.prettyNumber(params.creditAmount) + ' RUB');
                    greenButton.addEventListener('click', function () {
                        var crModal = this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
                        crModal.style.display = "none";
                        onSuccessCallback({
                            paymentAmount: params.creditAmount,
                            productCode: params.productCode,
                            contractNumber: params.contractNumber,
                            utm_source: 'V2'
                        });
                        return false;
                    });
                }

                if (!!whiteButton) {
                    crModalContentInnerLeftFooterContent.appendChild(whiteButton);
                }
                crModalContentInnerLeftFooterContent.appendChild(greenButton);
            }

            crModalContentInnerLeftFooter.appendChild(crModalContentInnerLeftFooterContent);
            return crModalContentInnerLeftFooter
        };

        /**
         * Создание блока с кнопкой закрыти модального окна
         */
        CredInBaskSDK.prototype.createModalInnerRightContent = function () {
            var crModalInnerRightContent = document.createElement('div');
            crModalInnerRightContent.innerHTML = Utils.stringFormat('<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.288965 30.2834C-0.101559 30.6739 -0.0948334 31.3138 0.295691 31.7043C0.686215 32.0948 1.3261 32.1016 1.71663 31.711L15.9999 17.4278L30.2834 31.7112C30.6739 32.1018 31.3138 32.095 31.7043 31.7045C32.0948 31.314 32.1016 30.6741 31.711 30.2836L17.4276 16.0001L31.7111 1.71661C32.1016 1.32608 32.0949 0.686192 31.7043 0.295668C31.3138 -0.0948561 30.6739 -0.101583 30.2834 0.288941L15.9999 14.5724L1.71661 0.289136C1.32608 -0.101388 0.686192 -0.0946622 0.295668 0.295862C-0.0948561 0.686386 -0.101583 1.32628 0.288941 1.7168L14.5722 16.0001L0.288965 30.2834Z" fill="#D0D7DD"/></svg>');
            crModalInnerRightContent.setAttribute('style', Utils.objToCss(this.getModalContentInnerRightStyle()));
            var onCancelCallback = this.onCancelCallback;
            crModalInnerRightContent.addEventListener('click', function () {
                var crModal = this.parentNode.parentNode.parentNode;
                crModal.style.display = "none";
                onCancelCallback('Закрытие модального окна');
                return false;
            });
            return crModalInnerRightContent;
        };

        /**
         * Создать кнопку в белом фоне
         */
        CredInBaskSDK.prototype.createWhiteButton = function (text) {
            var crButton = document.createElement('a');
            crButton.setAttribute('style', Utils.objToCss(this.getButtonModalWhiteStyle()));
            crButton.innerHTML = Utils.stringFormat('<span style=":textStyle:" class="sbid-button__text">:text:</span>', Object.assign({
                text: text,
                textStyle: Utils.objToCss(this.getTextButtonWhiteStyle())
            }, this.getLogoStyle()));

            var modal = this;
            crButton.addEventListener('mousedown', function (event) {
                this.setAttribute('style', Utils.objToCss(modal.getButtonPressedModalWhiteStyle()));
            });
            crButton.addEventListener("mouseover", function (event) {
                this.setAttribute('style', Utils.objToCss(modal.getButtonHoverModalWhiteStyle()));
            }, false);
            crButton.addEventListener("mouseout", function (event) {
                this.setAttribute('style', Utils.objToCss(modal.getButtonModalWhiteStyle()));
            });

            return crButton;
        };

        /**
         * Создать кнопку в зеленом фоне
         */
        CredInBaskSDK.prototype.createGreenButton = function (text) {
            var crButton = document.createElement('a');
            crButton.setAttribute('style', Utils.objToCss(this.getButtonModalGreenStyle()));
            crButton.innerHTML = Utils.stringFormat('<span style=":textStyle:" class="sbid-button__text">:text:</span>', Object.assign({
                text: text,
                textStyle: Utils.objToCss(this.getTextButtonGreenStyle())
            }, this.getLogoStyle()));

            var modal = this;
            crButton.addEventListener('mousedown', function (event) {
                this.setAttribute('style', Utils.objToCss(modal.getButtonPressedModalGreenStyle()));
            });
            crButton.addEventListener("mouseover", function (event) {
                this.setAttribute('style', Utils.objToCss(modal.getButtonHoverModalGreenStyle()));
            }, false);
            crButton.addEventListener("mouseout", function (event) {
                this.setAttribute('style', Utils.objToCss(modal.getButtonModalGreenStyle()));
            });

            return crButton;
        };

        return CredInBaskSDK;
    })();

    // https://tc39.github.io/ecma262/#sec-array.prototype.find
    if (!Object.assign) {
        Object.defineProperty(Object, 'assign', {
            enumerable: false,
            configurable: true,
            writable: true,
            value: function (target, firstSource) {
                'use strict';
                if (target === undefined || target === null) {
                    throw new TypeError('Cannot convert first argument to object');
                }

                var to = Object(target);
                for (var i = 1; i < arguments.length; i++) {
                    var nextSource = arguments[i];
                    if (nextSource === undefined || nextSource === null) {
                        continue;
                    }

                    var keysArray = Object.keys(Object(nextSource));
                    for (var nextIndex = 0, len = keysArray.length; nextIndex < len; nextIndex++) {
                        var nextKey = keysArray[nextIndex];
                        var desc = Object.getOwnPropertyDescriptor(nextSource, nextKey);
                        if (desc !== undefined && desc.enumerable) {
                            to[nextKey] = nextSource[nextKey];
                        }
                    }
                }
                return to;
            }
        });
    }

    if (!Element.prototype.closest) {

        Element.prototype.closest = function(css) {
            var node = this;

            while (node) {
                if (node.matches(css)) return node;
                else node = node.parentElement;
            }
            return null;
        };
    }

    if (!Element.prototype.matches) {
        Element.prototype.matches = Element.prototype.matchesSelector ||
            Element.prototype.webkitMatchesSelector ||
            Element.prototype.mozMatchesSelector ||
            Element.prototype.msMatchesSelector;

    }

    if (!Array.from) {
        Array.from = (function () {
            var toStr = Object.prototype.toString;
            var isCallable = function (fn) {
                return typeof fn === 'function' || toStr.call(fn) === '[object Function]';
            };
            var toInteger = function (value) {
                var number = Number(value);
                if (isNaN(number)) { return 0; }
                if (number === 0 || !isFinite(number)) { return number; }
                return (number > 0 ? 1 : -1) * Math.floor(Math.abs(number));
            };
            var maxSafeInteger = Math.pow(2, 53) - 1;
            var toLength = function (value) {
                var len = toInteger(value);
                return Math.min(Math.max(len, 0), maxSafeInteger);
            };

            // The length property of the from method is 1.
            return function from(arrayLike/*, mapFn, thisArg */) {
                // 1. Let C be the this value.
                var C = this;

                // 2. Let items be ToObject(arrayLike).
                var items = Object(arrayLike);

                // 3. ReturnIfAbrupt(items).
                if (arrayLike == null) {
                    throw new TypeError("Array.from requires an array-like object - not null or undefined");
                }

                // 4. If mapfn is undefined, then let mapping be false.
                var mapFn = arguments.length > 1 ? arguments[1] : void undefined;
                var T;
                if (typeof mapFn !== 'undefined') {
                    // 5. else
                    // 5. a If IsCallable(mapfn) is false, throw a TypeError exception.
                    if (!isCallable(mapFn)) {
                        throw new TypeError('Array.from: when provided, the second argument must be a function');
                    }

                    // 5. b. If thisArg was supplied, let T be thisArg; else let T be undefined.
                    if (arguments.length > 2) {
                        T = arguments[2];
                    }
                }

                // 10. Let lenValue be Get(items, "length").
                // 11. Let len be ToLength(lenValue).
                var len = toLength(items.length);

                // 13. If IsConstructor(C) is true, then
                // 13. a. Let A be the result of calling the [[Construct]] internal method of C with an argument list containing the single item len.
                // 14. a. Else, Let A be ArrayCreate(len).
                var A = isCallable(C) ? Object(new C(len)) : new Array(len);

                // 16. Let k be 0.
                var k = 0;
                // 17. Repeat, while k < len… (also steps a - h)
                var kValue;
                while (k < len) {
                    kValue = items[k];
                    if (mapFn) {
                        A[k] = typeof T === 'undefined' ? mapFn(kValue, k) : mapFn.call(T, kValue, k);
                    } else {
                        A[k] = kValue;
                    }
                    k += 1;
                }
                // 18. Let putStatus be Put(A, "length", len, true).
                A.length = len;
                // 20. Return A.
                return A;
            };
        }());
    }

    // https://tc39.github.io/ecma262/#sec-array.prototype.includes
    if (!Array.prototype.includes) {
        Object.defineProperty(Array.prototype, 'includes', {
            value: function(searchElement, fromIndex) {

                if (this == null) {
                    throw new TypeError('"this" is null or not defined');
                }

                // 1. Let O be ? ToObject(this value).
                var o = Object(this);

                // 2. Let len be ? ToLength(? Get(O, "length")).
                var len = o.length >>> 0;

                // 3. If len is 0, return false.
                if (len === 0) {
                    return false;
                }

                // 4. Let n be ? ToInteger(fromIndex).
                //    (If fromIndex is undefined, this step produces the value 0.)
                var n = fromIndex | 0;

                // 5. If n ≥ 0, then
                //  a. Let k be n.
                // 6. Else n < 0,
                //  a. Let k be len + n.
                //  b. If k < 0, let k be 0.
                var k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);

                function sameValueZero(x, y) {
                    return x === y || (typeof x === 'number' && typeof y === 'number' && isNaN(x) && isNaN(y));
                }

                // 7. Repeat, while k < len
                while (k < len) {
                    // a. Let elementK be the result of ? Get(O, ! ToString(k)).
                    // b. If SameValueZero(searchElement, elementK) is true, return true.
                    if (sameValueZero(o[k], searchElement)) {
                        return true;
                    }
                    // c. Increase k by 1.
                    k++;
                }

                // 8. Return false
                return false;
            }
        });
    }

    exports.CredInBaskSDK = CredInBaskSDK;
}(typeof exports === 'object' && exports || this));
