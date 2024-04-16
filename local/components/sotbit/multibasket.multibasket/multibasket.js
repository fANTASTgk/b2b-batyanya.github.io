!function(){"use strict";function t(t,e,i){return(e=function(t){var e=function(t,e){if("object"!=typeof t||null===t)return t;var i=t[Symbol.toPrimitive];if(void 0!==i){var o=i.call(t,"string");if("object"!=typeof o)return o;throw new TypeError("@@toPrimitive must return a primitive value.")}return String(t)}(t);return"symbol"==typeof e?e:String(e)}(e))in t?Object.defineProperty(t,e,{value:i,enumerable:!0,configurable:!0,writable:!0}):t[e]=i,t}BX.namespace("Sotbit.MultibasketComponent"),BX.Sotbit.MultibasketComponent.class=class{constructor(e){let{result:i,params:o}=e;t(this,"componentWraperId","sotbit_multibasket_components"),t(this,"dataEntity",{multibasketCurrent:"multibasket__current",currentName:"current_name",currentColor:"current_color",currentQuantity:"current_quantity",currentArrow:"current_arrow",basketsList:"baskets_list",basketItem:"basket_item",basketAdd:"basket_add",otherColor:"other_color",otherRemove:"other_remove",otherEdit:"other_edit",otherBasketWraper:"otherbasket_wraper",showOtherBusket:"show_other_busket",modalWindow:"modal-window",modalTitle:"modal__title",modalButtonOk:"modal-button-ok",modalButtonClose:"modal-button-close",modalButtonCloseTop:"modal-button-close-top",modalColorItemChecbox:"color-item-checbox",modalColorsItems:"colors-items",colorItemSelected:"color-item-selected",otherName:"other_name",basketTotalPrice:"basket-total-price",productsHeader:"products-header",productItem:"product-item",productItemsList:"product-items-list",poroductPhoto:"poroduct_photo",productName:"product-name",productPrice:"product-price",productTotalPrice:"product-total-price",btnToOrderPage:"btn-to-order-page",btnDeleteProduct:"btn-delete-product",btnShowList:"btn_show_list",multibasketNotification:"multibasket__notification",multibasketNotificationWrapper:"multibasket__notification_wrapper",newBasketName:"new_basket_name",toolTip:"tool-tip"}),t(this,"curentSeletedColor",null),t(this,"notification",{}),t(this,"selectedBasketId",null),t(this,"root",void 0),t(this,"domNods",void 0),this.params=o,this.toolTipTimer=null,this.basketNeedsHidden()||(this.baskets=i.BASKETS,this.currentBasket=i.CURRENT_BASKET,this.notification=i.BASKET_CHANGE_NOTIFICATIONS,this.getDomElements(),this.installEventHandlers(),BX.addCustomEvent(window,"OnBasketChange",(async()=>await this.sendRequest("GET",{}))),this.additionsBasketListRoot=null,this.basketSelectedAitems=[])}setAdditionsBasketListRoot(t){this.additionsBasketListRoot=t}setSelectedProductsInBasket(t){this.basketSelectedAitems=t}getEntity(t,e){return t&&e?arguments.length>2&&void 0!==arguments[2]&&arguments[2]?t.querySelectorAll('[data-entity="'+e+'"]'):t.querySelector('[data-entity="'+e+'"]'):null}getDomElements(){this.root=document.getElementById(this.componentWraperId),this.domNods={multibasketCurrent:this.getEntity(this.root,this.dataEntity.multibasketCurrent),currentColor:this.getEntity(this.root,this.dataEntity.currentColor,!0),currentName:this.getEntity(this.root,this.dataEntity.currentName),currentArrow:this.getEntity(this.root,this.dataEntity.currentArrow),otherBasketWraper:this.getEntity(this.root,this.dataEntity.otherBasketWraper),multibasketNotification:this.getEntity(this.root,this.dataEntity.multibasketNotification),toolTip:this.getEntity(this.root,this.dataEntity.toolTip)},this.domNods.multibasketNotificationWrapper=this.getEntity(this.root,this.dataEntity.multibasketNotificationWrapper),this.domNods.multibasketNotificationWrapper||(this.domNods.multibasketNotificationWrapper=this.domNods.multibasketNotification),"Y"===this.params.POSITION_FIXED&&"Y"===this.params.SHOW_PRODUCTS&&(this.domNods.btnShowList=this.getEntity(this.root,this.dataEntity.btnShowList),this.domNods.btnShowList.innerText=BX.message.SOTBIT_BULTIBASKET_CLOSE_FIXET_LIST),"Y"===this.params.SHOW_PRODUCTS&&(this.domNods.productsHeader=this.getEntity(this.root,this.dataEntity.productsHeader),this.domNods.productItem=this.getEntity(this.root,this.dataEntity.productItem),this.domNods.productItemsList=this.getEntity(this.root,this.dataEntity.productItemsList),this.domNods.btnToOrderPage=this.getEntity(this.root,this.dataEntity.btnToOrderPage)),"Y"!==this.params.SHOW_NUM_PRODUCTS||this.basketNeedsHidden()||(this.domNods.currentQuantity=this.getEntity(this.root,this.dataEntity.currentQuantity),this.domNods.currentQuantity.style="display: block;"),"Y"===this.params.SHOW_TOTAL_PRICE&&(this.domNods.basketTotalPrice=this.getEntity(this.root,this.dataEntity.basketTotalPrice)),this.domNods.basketsList=this.getEntity(this.domNods.otherBasketWraper,this.dataEntity.basketsList),this.domNods.basketItem=this.getEntity(this.domNods.basketsList,this.dataEntity.basketItem),this.domNods.basketAdd=this.getEntity(this.domNods.otherBasketWraper,this.dataEntity.basketAdd),this.domNods.modalWindow=this.getEntity(this.root,this.dataEntity.modalWindow),this.domNods.modalName=this.getEntity(this.domNods.modalWindow,this.dataEntity.modalName),this.domNods.modalButtonOk=this.getEntity(this.domNods.modalWindow,this.dataEntity.modalButtonOk),this.domNods.modalButtonClose=this.getEntity(this.domNods.modalWindow,this.dataEntity.modalButtonClose),this.domNods.modalButtonCloseTop=this.getEntity(this.domNods.modalWindow,this.dataEntity.modalButtonCloseTop),this.domNods.modalColorItemChecbox=this.getEntity(this.domNods.modalWindow,this.dataEntity.modalColorItemChecbox),this.domNods.modalColorsItems=this.getEntity(this.domNods.modalWindow,this.dataEntity.modalColorsItems),this.domNods.colorItemSelected=this.getEntity(this.domNods.modalWindow,this.dataEntity.colorItemSelected),this.domNods.newBasketName=this.getEntity(this.domNods.modalWindow,this.dataEntity.newBasketName),this.domNods.newBasketName.setAttribute("maxlength",20)}installEventHandlers(){var t,e;this.domNods.currentArrow.addEventListener("click",(t=>{t.preventDefault(),this.showOtherBasketEvent(t)})),this.domNods.multibasketCurrent.addEventListener("mouseover",this.showOtherBasketEvent.bind(this)),this.domNods.multibasketCurrent.addEventListener("mouseout",this.showOtherBasketEvent.bind(this)),this.domNods.otherBasketWraper.addEventListener("mouseover",this.showOtherBasketEvent.bind(this)),this.domNods.otherBasketWraper.addEventListener("mouseout",this.showOtherBasketEvent.bind(this)),null===(t=this.domNods.basketAdd)||void 0===t||t.addEventListener("click",this.showModalButtonEvent.bind(this)),null===(e=this.domNods.basketAdd)||void 0===e||e.addEventListener("mouseover",this.hideBasketToolTip.bind(this)),this.domNods.modalButtonClose.addEventListener("click",this.modalButtonCloseEvent.bind(this)),this.domNods.modalButtonCloseTop.addEventListener("click",this.modalButtonCloseEvent.bind(this)),this.domNods.modalWindow.addEventListener("click",this.modalButtonCloseFonEvent.bind(this)),this.domNods.modalButtonOk.addEventListener("click",this.modalButtonOkEvent.bind(this)),this.domNods.multibasketNotificationWrapper.addEventListener("click",this.closeNotifications.bind(this)),void 0!==this.domNods.btnShowList&&this.domNods.btnShowList.addEventListener("click",(()=>{"none"===this.domNods.productItemsList.style.display?(this.domNods.btnShowList.innerText=BX.message.SOTBIT_BULTIBASKET_CLOSE_FIXET_LIST,this.domNods.productItemsList.style="display: block;",void 0!==this.domNods.productsHeader&&this.currentBasket.ITEMS_QUANTITY>0&&(this.domNods.productsHeader.style="display: block;")):(this.domNods.btnShowList.innerText=BX.message.SOTBIT_BULTIBASKET_SHOW_FIXET_LIST,this.domNods.productItemsList.style="display: none;",void 0!==this.domNods.productsHeader&&(this.domNods.productsHeader.style="display: none;"))})),Array.prototype.slice.call(this.domNods.modalColorsItems.childNodes).forEach((t=>{t instanceof HTMLDivElement&&t.addEventListener("click",this.colorChekBoxEvent.bind(this))}))}render(){this.basketNeedsHidden()||(this.renderProducts(),this.renderTotalPrice(),this.renderBaskets(),this.renderAdditionsBasketList(),"Y"===this.params.POSITION_FIXED&&(this.setBasketListPosition(),this.setFixedBasketHeight(),this.calculateTopMarginByFixedBasket()),this.basketChangeNotifications())}colorChekBoxEvent(t){if(t.currentTarget.classList.contains("modal__active")){this.removeColorCheckBoxMarker();const e=this.domNods.modalColorItemChecbox.cloneNode(!0);e.style="display: flex;",t.currentTarget.appendChild(e),this.curentSeletedColor=t.currentTarget.getAttribute("style").slice(-7,-1)}}removeColorCheckBoxMarker(){Array.prototype.slice.call(this.domNods.modalColorsItems.childNodes).forEach((t=>{if(t instanceof HTMLDivElement){const e=this.getEntity(t,this.dataEntity.modalColorItemChecbox);e instanceof HTMLDivElement&&e.remove()}}))}setColorCheckBoxSelectedMarker(t,e){const i=this.baskets.map((t=>t.COLOR)),o="modal__active",s=this.domNods.colorItemSelected;this.curentSeletedColor=e,Array.prototype.slice.call(this.domNods.modalColorsItems.childNodes).forEach((a=>{if(a instanceof HTMLDivElement&&"set"===t){if(a.getAttribute("style").slice(-7,-1)===e){const t=this.domNods.modalColorItemChecbox.cloneNode(!0);return t.style="display: flex;",void a.appendChild(t)}if(i.includes(a.getAttribute("style").slice(-7,-1))){a.classList.remove(o);const t=s.cloneNode(!0);t.style="display: block;",a.append(t)}}else a instanceof HTMLDivElement&&"unset"===t&&(a.classList.contains(o)||(a.classList.add(o),Array.prototype.slice.call(a.childNodes).forEach((t=>t.remove()))))}))}showOtherBasketEvent(t){const e="multibasket__current-arrow__show",i="otherbasket_wraper_active";"mouseover"===t.type?(this.domNods.currentArrow.classList.add(e),this.domNods.otherBasketWraper.classList.add(i)):"mouseout"===t.type&&(this.domNods.otherBasketWraper.classList.remove(i),this.domNods.currentArrow.classList.remove(e))}recalculateBasket(){const t=this.getCurrentPage(),e=t===this.params.BASKET_PAGE_URL||t===this.params.BASKET_PAGE_URL+"index.php";("Y"!==this.params.ONLY_BASKET_PAGE_RECALCULATE||e)&&("EVENT"!==this.params.RECALCULATE_BASKET&&window.location.reload(),BX.onCustomEvent(window,"sotbitMultibasketSwitch",this.baskets))}getCurrentPage(){return window.location.pathname}showModalButtonEvent(t,e,i,o){this.selectedBasketId=i,this.setColorCheckBoxSelectedMarker("set",e),this.domNods.newBasketName.value=o||BX.message.SOTBIT_BULTIBASKET_NEW_BASKET,this.getEntity(this.domNods.modalWindow,this.dataEntity.colorItemSelected,!0).length===Array.prototype.slice.call(this.domNods.modalColorsItems.childNodes).filter((t=>t instanceof HTMLDivElement)).length+1?(this.domNods.modalWindow.querySelector(".modal__title").innerText=BX.message.SOTBIT_BULTIBASKET_REMOVE_NOT_USE_BASKET,this.domNods.newBasketName.setAttribute("disabled",!0)):i?(this.domNods.modalWindow.querySelector(".modal__title").innerText=BX.message.SOTBIT_BULTIBASKET_UPDATE_BASKET,this.domNods.newBasketName.removeAttribute("disabled")):(this.domNods.modalWindow.querySelector(".modal__title").innerText=BX.message.SOTBIT_BULTIBASKET_CREATE_NEW_BASKET,this.domNods.newBasketName.removeAttribute("disabled")),this.getEntity(this.domNods.modalWindow,this.dataEntity.modalTitle),this.domNods.modalWindow.classList.add("multibasket__modal__active")}modalButtonCloseEvent(){this.domNods.modalWindow.classList.remove("multibasket__modal__active"),this.removeColorCheckBoxMarker(),this.setColorCheckBoxSelectedMarker("unset")}modalButtonCloseFonEvent(t){t.target.querySelector(".multibasket__edit-form")&&(this.domNods.modalWindow.classList.remove("multibasket__modal__active"),this.removeColorCheckBoxMarker(),this.setColorCheckBoxSelectedMarker("unset"))}async removeBasketEvent(t){await this.sendRequest("DELETE",{ID:t})}async setCurrentBasketEvent(t){await this.sendRequest("UPDATE",{ID:t,CURRENT_BASKET:!0}),this.recalculateBasket()}async modalButtonOkEvent(){if(!this.curentSeletedColor)return alert(BX.message.SOTBIT_BULTIBASKET_YOU_NEED_TO_CHOOSE_A_COLOR_FIRST);if(""===this.domNods.newBasketName.value.trim())return alert(BX.message.SOTBIT_BULTIBASKET_YOU_NEED_TO_CHOOSE_A_NAME_FIRST);const t=this.selectedBasketId?"UPDATE":"CREATE";if(await this.sendRequest(t,{ID:this.selectedBasketId,COLOR:this.curentSeletedColor,NAME:encodeURI(this.domNods.newBasketName.value)}),"CREATE"===t){const t=(()=>{for(let t in this.baskets)if(this.baskets[t].COLOR===this.curentSeletedColor)return this.baskets[t].ID})();this.createNewBasketNotification(this.curentSeletedColor,'"'.concat(this.domNods.newBasketName.value,'"')),await this.setCurrentBasketEvent(t)}this.domNods.modalWindow.classList.remove("multibasket__modal__active"),this.selectedBasketId=null,this.curentSeletedColor=null,this.removeColorCheckBoxMarker(),this.setColorCheckBoxSelectedMarker("unset")}async sendRequest(t,e,i){try{var o,s;"GET"!==t&&BX.showWait();const a=await BX.ajax.runAction("sotbit:multibasket.MultibasketController.any",{data:{action:t,requestData:JSON.stringify(e),viewParam:JSON.stringify({SHOW_TOTAL_PRICE:"Y"===this.params.SHOW_TOTAL_PRICE,SHOW_SUMMARY:"Y"===this.params.SHOW_SUMMARY,SHOW_IMAGE:"Y"===this.params.SHOW_IMAGE,SHOW_PRICE:"Y"===this.params.SHOW_PRICE,SHOW_PRODUCTS:"Y"===this.params.SHOW_PRODUCTS}),addionalsParams:JSON.stringify(i)}});this.baskets=null!==(o=a.data.BASKETS)&&void 0!==o?o:this.baskets,this.currentBasket=null!==(s=a.data.CURRENT_BASKET)&&void 0!==s?s:this.currentBasket,this.notification=a.data.BASKET_CHANGE_NOTIFICATIONS?a.data.BASKET_CHANGE_NOTIFICATIONS:{},this.render(),BX.closeWait()}catch(t){console.log(t)}}async sendBasketItemRequest(t,e){try{BX.showWait(),"success"===(await BX.ajax.runAction("sotbit:multibasket.BasketItemController.any",{data:{action:t,basketItemId:e}})).status&&BX.onCustomEvent(window,"OnBasketChange",[]),BX.closeWait()}catch(t){console.log(t)}}setBasketListPosition(){"Y"===this.params.POSITION_FIXED&&(this.domNods.otherBasketWraper.style="position: relative;")}setFixedBasketHeight(){if("Y"===this.params.SHOW_PRODUCTS){const t="multibasket__products_height";this.domNods.productItemsList.classList.remove(t);const e=document.documentElement.clientHeight;this.domNods.productItemsList.clientHeight>.65*e?this.domNods.productItemsList.classList.add(t):this.domNods.productItemsList.classList.remove(t)}}basketNeedsHidden(){if("Y"===this.params.HIDE_ON_BASKET_PAGES){const t=this.getCurrentPage();if(t===this.params.BASKET_PAGE_URL||t===this.params.PATH_TO_ORDER)return!0}return!1}renderProducts(){void 0!==this.domNods.productItem&&void 0!==this.domNods.productItemsList&&(Array.prototype.slice.call(this.domNods.productItemsList.childNodes).forEach((t=>t.remove())),this.currentBasket.ITEMS.forEach((t=>{const e=this.domNods.productItem.cloneNode(!0);"Y"===this.params.SHOW_IMAGE&&(this.getEntity(e,this.dataEntity.poroductPhoto).src=t.PICTURE);const i=this.getEntity(e,this.dataEntity.productName);if(i.href=t.DETAIL_PAGE_URL,i.innerHTML=t.NAME,"Y"===this.params.SHOW_PRICE){const i=this.getEntity(e,this.dataEntity.productPrice),o="<strong>".concat(t.PRICE,"</strong>"),s="<strong>".concat(t.CURRENCY," </strong>"),a="<span>".concat(t.BASE_PRICE,"</span>"),d="<span>".concat(t.CURRENCY,"</span>");i.innerHTML=o+s+a+d}if("Y"===this.params.SHOW_SUMMARY){const i=this.getEntity(e,this.dataEntity.productTotalPrice),o="<strong>".concat(t.QUANTITY," </strong>"),s="<span>".concat(t.MEASURE_NAME," </span>"),a="<span>".concat(BX.message.SOTBIT_BULTIBASKET_TOTAL_PRICE," </span>"),d="<strong>".concat(t.FINAL_PRICE,"</strong>"),n="<strong>".concat(t.CURRENCY," </strong>");i.innerHTML=o+s+a+d+n}this.getEntity(e,this.dataEntity.btnDeleteProduct).addEventListener("click",(()=>this.sendBasketItemRequest("DELETE",t.BASKET_ID))),this.domNods.productItemsList.appendChild(e)}))),void 0!==this.domNods.productsHeader&&void 0!==this.domNods.productItemsList&&(this.currentBasket.ITEMS_QUANTITY>0?(this.domNods.productItemsList.style="display: block;",this.domNods.productsHeader.style="display: block;",this.domNods.btnToOrderPage.style="display: block;"):(this.domNods.productsHeader.style="display: none;",this.domNods.productItemsList.style="display: none;",this.domNods.btnToOrderPage.style="display: none;"))}renderTotalPrice(){if(void 0!==this.domNods.basketTotalPrice)if(this.currentBasket.ITEMS_QUANTITY>0){this.domNods.basketTotalPrice.style="display: block;";const t="<span>".concat(BX.message.SOTBIT_BULTIBASKET_TOTAL_PRICE," </span>"),e="<strong>".concat(this.currentBasket.TOTAL_PRICE,"</strong>");this.domNods.basketTotalPrice.innerHTML=t+e}else this.domNods.basketTotalPrice.style="display: none;"}renderBaskets(){const t=this.baskets.filter((t=>t.CURRENT_BASKET))[0];Array.prototype.slice.call(this.domNods.currentColor).forEach((e=>e.style="background-color: #".concat(t.COLOR,";"))),this.domNods.currentName.innerText=t.MAIN?t.NAME?t.NAME:BX.message.SOTBIT_BULTIBASKET_MAIN_BASKET:t.NAME?t.NAME:BX.message.SOTBIT_BULTIBASKET_OHER_BASKET,void 0!==this.domNods.currentQuantity&&(this.domNods.currentQuantity.innerText=this.currentBasket.ITEMS_QUANTITY);const e=this.getBaksetList();Array.prototype.slice.call(this.domNods.basketsList.childNodes).forEach((t=>t.remove())),e.forEach((t=>this.domNods.basketsList.appendChild(t))),Array.prototype.slice.call(this.domNods.modalColorsItems.childNodes).forEach((t=>{t instanceof HTMLDivElement&&t.addEventListener("click",this.colorChekBoxEvent.bind(this))}))}renderAdditionsBasketList(){if(!this.additionsBasketListRoot)return;const t=this.getAdditonalBasketList(this.moveItemsToBusket.bind(this));Array.prototype.slice.call(this.additionsBasketListRoot.childNodes).forEach((t=>t.remove())),t.forEach((t=>this.additionsBasketListRoot.appendChild(t)))}getBaksetList(){return this.baskets.filter((t=>!Boolean(t.CURRENT_BASKET))).map((t=>{const e=this.domNods.basketItem.cloneNode(!0);var i,o,s,a;return e.addEventListener("click",(e=>{this.dataEntity.basketItem===e.currentTarget.dataset.entity&&this.setCurrentBasketEvent(t.ID)})),this.getEntity(e,this.dataEntity.otherColor).style="background-color: #".concat(t.COLOR,";"),this.getEntity(e,this.dataEntity.otherName).innerText=t.MAIN?t.NAME?t.NAME:BX.message.SOTBIT_BULTIBASKET_MAIN_BASKET:t.NAME?t.NAME:BX.message.SOTBIT_BULTIBASKET_OHER_BASKET,t.MAIN?(null===(i=this.getEntity(e,this.dataEntity.otherRemove))||void 0===i||i.remove(),null===(o=this.getEntity(e,this.dataEntity.otherEdit))||void 0===o||o.remove()):(null===(s=this.getEntity(e,this.dataEntity.otherRemove))||void 0===s||s.addEventListener("click",(e=>{e.stopPropagation(),this.removeBasketEvent(t.ID)}).bind(this)),null===(a=this.getEntity(e,this.dataEntity.otherEdit))||void 0===a||a.addEventListener("click",(e=>{e.stopPropagation(),this.showModalButtonEvent(e,t.COLOR,t.ID,t.NAME)}))),e.addEventListener("mouseover",this.showBasketToolTip.bind(this)),e.addEventListener("mouseout",this.hideBasketToolTip.bind(this)),e}))}getAdditonalBasketList(){return this.baskets.filter((t=>!Boolean(t.CURRENT_BASKET))).map((t=>{var e,i;const o=this.domNods.basketItem.cloneNode(!0);return o.addEventListener("click",(e=>{this.dataEntity.basketItem===e.currentTarget.dataset.entity&&this.moveItemsToBusket(t.ID)})),this.getEntity(o,this.dataEntity.otherColor).style="background-color: #".concat(t.COLOR,";"),this.getEntity(o,this.dataEntity.otherName).innerText=t.MAIN?t.NAME?t.NAME:BX.message.SOTBIT_BULTIBASKET_MAIN_BASKET:t.NAME?t.NAME:BX.message.SOTBIT_BULTIBASKET_OHER_BASKET,null===(e=this.getEntity(o,this.dataEntity.otherRemove))||void 0===e||e.remove(),null===(i=this.getEntity(o,this.dataEntity.otherEdit))||void 0===i||i.remove(),o.addEventListener("mouseover",this.showBasketToolTip.bind(this)),o.addEventListener("mouseout",this.hideBasketToolTip.bind(this)),o}))}calculateTopMarginByFixedBasket(){"vcenter"===this.params.POSITION_VERTICAL&&(this.root.style="margin-top: -".concat(Math.round(this.root.offsetHeight/2),"px"))}basketChangeNotifications(){if(this.notification.order&&this.notification.order.fromColor){const t=this.createNotificationText(BX.message.SOTBIT_BULTIBASKET_ORDER_PROCESSED),e=this.createNotificationBasketColor(this.notification.order.fromColor),i=this.createNotificationText('"'.concat(this.notification.order.fromName,'"'),"white-space: nowrap;"),o=this.createNotificationText(BX.message.SOTBIT_BULTIBASKET_BASKET_REMOVED);this.domNods.multibasketNotification.appendChild(t),this.domNods.multibasketNotification.appendChild(e),this.domNods.multibasketNotification.appendChild(i),this.domNods.multibasketNotification.appendChild(o)}if(this.notification.order&&this.notification.order.toColor){const t=document.createElement("br"),e=this.createNotificationText(BX.message.SOTBIT_BULTIBASKET_OHER_BASKET),i=this.createNotificationBasketColor(this.notification.order.toColor),o=this.createNotificationText(BX.message.SOTBIT_BULTIBASKET_NEW_MAIN),s=this.createNotificationText('"'.concat(this.notification.order.toName,'"'),"white-space: nowrap;");this.domNods.multibasketNotification.appendChild(t),this.domNods.multibasketNotification.appendChild(e),this.domNods.multibasketNotification.appendChild(i),this.domNods.multibasketNotification.appendChild(s),this.domNods.multibasketNotification.appendChild(o)}if(this.notification.united&&this.notification.united.fromColor&&this.notification.united.toColor){const t=this.createNotificationText(BX.message.SOTBIT_BULTIBASKET_ITEMS_BASKTET_FROM),e=this.createNotificationBasketColor(this.notification.united.fromColor),i=this.createNotificationText('"'.concat(this.notification.united.fromName,'"'),"white-space: nowrap;"),o=document.createElement("br"),s=thi.createNotificationText(BX.message.SOTBIT_BULTIBASKET_ITEMS_BASKTET_TO),a=this.createNotificationBasketColor(this.notification.united.toColor),d=this.createNotificationText('"'.concat(this.notification.united.toName,'"'),"white-space: nowrap;");this.domNods.multibasketNotification.appendChild(t),this.domNods.multibasketNotification.appendChild(e),this.domNods.multibasketNotification.appendChild(i),this.domNods.multibasketNotification.appendChild(o.cloneNode(!0)),this.domNods.multibasketNotification.appendChild(s),this.domNods.multibasketNotification.appendChild(a),this.domNods.multibasketNotification.appendChild(d),this.domNods.multibasketNotification.appendChild(o)}if(this.notification.changeColor&&this.notification.changeColor.length>0&&this.notification.changeColor.forEach((t=>{const e=this.createNotificationText(BX.message.SOTBIT_BULTIBASKET_BASKET_ADD),i=this.createNotificationBasketColor(this.notification.united.fromColor),o=this.createNotificationText('"'.concat(this.notification.united.fromName,'"'),"white-space: nowrap;"),s=this.createNotificationText(BX.message.SOTBIT_BULTIBASKET_COLOR_CHANGE),a=this.createNotificationBasketColor(this.notification.united.toColor),d=this.createNotificationText('"'.concat(this.notification.united.toName,'"'),"white-space: nowrap;"),n=document.createElement("br");this.domNods.multibasketNotification.appendChild(e),this.domNods.multibasketNotification.appendChild(i),this.domNods.multibasketNotification.appendChild(o),this.domNods.multibasketNotification.appendChild(s),this.domNods.multibasketNotification.appendChild(a),this.domNods.multibasketNotification.appendChild(d),this.domNods.multibasketNotification.appendChild(n)})),this.notification.moveProductToBasket&&this.notification.moveProductToBasket.toBasketColor&&Array.isArray(this.notification.moveProductToBasket.productsName)){const t=this.createNotificationText(BX.message.SOTBIT_BULTIBASKET_ITEMS_NAMES),e=this.createNotificationText("".concat(this.notification.moveProductToBasket.productsName[0]," "));if(this.domNods.multibasketNotification.appendChild(t),this.domNods.multibasketNotification.appendChild(e),this.notification.moveProductToBasket.productsName.length>1){const t=this.createNotificationText(BX.message.SOTBIT_BULTIBASKET_AND_OTHER);this.domNods.multibasketNotification.appendChild(t)}const i=document.createElement("br"),o=this.createNotificationText(BX.message.SOTBIT_BULTIBASKET_ITEMS_MOVE),s=this.createNotificationBasketColor(this.notification.moveProductToBasket.toBasketColor),a=this.createNotificationText('"'.concat(this.notification.moveProductToBasket.toBasketName,'"'),"white-space: nowrap;");this.domNods.multibasketNotification.appendChild(i),this.domNods.multibasketNotification.appendChild(o),this.domNods.multibasketNotification.appendChild(s),this.domNods.multibasketNotification.appendChild(a)}this.domNods.multibasketNotification.childNodes.length>0&&this.renderNotification()}renderNotification(){const t="notification__show";this.domNods.multibasketNotificationWrapper.removeAttribute("style"),this.domNods.multibasketNotificationWrapper.classList.add(t),setTimeout((()=>{this.domNods.multibasketNotificationWrapper.classList.remove(t),setTimeout((()=>{this.domNods.multibasketNotificationWrapper.setAttribute("style","display: none;"),Array.prototype.slice.call(this.domNods.multibasketNotification.childNodes).forEach((t=>t.remove()))}),1e3)}),5e3)}closeNotifications(){this.domNods.multibasketNotificationWrapper.classList.remove("notification__show"),setTimeout((()=>{this.domNods.multibasketNotificationWrapper.setAttribute("style","display: none;"),Array.prototype.slice.call(this.domNods.multibasketNotification.childNodes).forEach((t=>t.remove()))}),1e3)}getTextMaxWidth(){return this.root.offsetWidth-65}showBasketToolTip(t){clearTimeout(this.toolTipTimer);const e=t.currentTarget,i=t.clientX,o=t.clientY;this.toolTipTimer=setTimeout(function(t,e,i){const o=this.getEntity(t,this.dataEntity.otherName).textContent;this.domNods.toolTip.innerText=o;const s=this.getTextMaxWidth();if(!this.domNods.toolTip.getAttribute("style").includes("visible")&&s<=this.domNods.toolTip.clientWidth){const t=window.innerWidth-e+25,o=i+25;this.domNods.toolTip.style="isibility: visible; right: ".concat(t,"px; top: ").concat(o,"px;"),setTimeout((()=>{this.domNods.toolTip.style="visibility: collapse"}),7e3)}else this.domNods.toolTip.style="visibility: collapse"}.bind(this,e,i,o),500)}hideBasketToolTip(t){clearTimeout(this.toolTipTimer),t.target.getAttribute("data-entity")===t.currentTarget.getAttribute("data-entity")&&(this.domNods.toolTip.style="visibility: collapse")}async moveItemsToBusket(t){const e=this.basketSelectedAitems.map((t=>({ID:t.ID,PRODUCT_ID:t.PRODUCT_ID})));this.domNods.toolTip.style="visibility: collapse",await this.sendRequest("MOVE_ITEMS_TO_ANOTHER_BASKET",{ID:t},e),this.notification.moveBasketItems=this.basketSelectedAitems.map((t=>t.NAME)),this.recalculateBasket(),BX.onCustomEvent("OnBasketChangeAfterMove")}createNewBasketNotification(t,e){const i=this.createNotificationText(BX.message.SOTBIT_BULTIBASKET_NEW_BASKET_CREATED),o=this.createNotificationBasketColor(t),s=this.createNotificationText(e||"");this.domNods.multibasketNotification.appendChild(i),this.domNods.multibasketNotification.appendChild(o),this.domNods.multibasketNotification.appendChild(s)}createNotificationBasketColor(t){const e=document.createElement("span"),i=document.createElement("span"),o=getComputedStyle(this.domNods.multibasketNotificationWrapper).backgroundColor;i.setAttribute("style","color: ".concat(o)),i.innerText="1";const s=document.createElement("span");return s.classList.add("notification__basket_color"),s.setAttribute("style","background-color: #".concat(t,"; color: #").concat(t,"; border-radius: 4px;")),s.innerText="111",e.append(i.cloneNode(!0)),e.append(s),e.append(i),e}createNotificationText(t,e){const i=t||"",o=document.createElement("span");return o.innerHTML=i,e&&o.setAttribute("style","white-space: nowrap;"),o}}}();