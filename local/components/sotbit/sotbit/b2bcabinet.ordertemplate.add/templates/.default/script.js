BX.ready(function(){
    init();
});

function init() {
    const btnShowForm = document.querySelector("#add-ordertemplate");
    const addPopup = document.querySelector(".popup-add-ordertemplate");
    const btnExcelOut = document.querySelector("#blank-export-in-excel");


    if(btnShowForm){
        btnShowForm.addEventListener("click", function(){
            showPopup(addPopup);
        });
    }

    if(addPopup){
        appendPopup(addPopup);
        const closePopupBtn = addPopup.querySelector(".popup-close");
        const closePopupArea = addPopup.querySelector(".modal-popup-bg");

        closePopupBtn.addEventListener("click", function(){
            closePopup(addPopup);
        });
        closePopupArea.addEventListener("click", function(){
            closePopup(addPopup);
        });
    }

    if(btnExcelOut){
        btnExcelOut.addEventListener("click", function(){
            excelOut();
        });
        btnExcelOut.addEventListener("touchstart", function(){
            excelOut();
        });
    }

    function showPopup(popup) {
        popup.style.display = "flex";
    }
    function appendPopup(popup){
        document.body.append(popup);
    }
    function closePopup(popup) {
        popup.style.display = "none";
    }


    function excelOut() {
        setExcelOutIcon("icon-spinner2 spinner mr-2");

        setTimeout(function () {
            // BX.showWait();
            var file = '';

            $.ajax({
                type: 'POST',
                async: false,
                url: site_path + 'include/ajax/blank_excel_export.php',
                data: {
                    table_header: tableHeader,
                    filterProps: filterProps,
                    priceCodes: priceCodes,
                    file: file
                },
                success: function (data) {
                    if (data !== undefined && data !== '') {
                        try {
                            data = JSON.parse(data);
                        } catch (e) {

                        }
                    }

                    if (data.TYPE !== undefined) {
                        console.log(data.MESSAGE);
                    } else if (data !== undefined && data !== '') {
                        file = data;
                    }
                },
                complete: function () {
                    setExcelOutIcon("icon-upload mr-2");
                }
            });

            if (file !== undefined && file !== '') {
                var now = new Date();

                var dd = now.getDate();
                if (dd < 10) dd = '0' + dd;
                var mm = now.getMonth() + 1;
                if (mm < 10) mm = '0' + mm;
                var hh = now.getHours();
                if (hh < 10) hh = '0' + hh;
                var mimi = now.getMinutes();
                if (mimi < 10) mimi = '0' + mimi;
                var ss = now.getSeconds();
                if (ss < 10) ss = '0' + ss;

                var rand = 0 - 0.5 + Math.random() * (999999999 - 0 + 1)
                rand = Math.round(rand);

                var name = 'blank_' + now.getFullYear() + '_' + mm + '_' + dd + '_' + hh + '_' + mimi + '_' + ss + '_' + rand + '.xlsx';

                var link = document.createElement('a');
                link.setAttribute('href', file);
                link.setAttribute('download', name);
                var event = document.createEvent("MouseEvents");
                event.initMouseEvent(
                    "click", true, false, window, 0, 0, 0, 0, 0
                    , false, false, false, false, 0, null
                );
                link.dispatchEvent(event);
            }
        }, 15);

        // BX.closeWait();
    }

    function setExcelOutIcon(icon) {
        let iconContainer = document.querySelector(".export_excel_preloader > i");
        iconContainer.setAttribute("class", icon);
    }

    BX.addCustomEvent('onUploadDone', function (file) {
        if (file['file_id'] !== '' && file['file_id'] !== undefined) {
            setExcelOutIconImport("icon-spinner2 spinner mr-2");
            var errorBlock = document.querySelector('.error-block');
            setTimeout(function () {
                BX.ajax({
                    method: 'POST',
                    async: false,
                    url: site_path + 'include/ajax/ordertemplate_import.php',
                    data: {
                        file_id: file['file_id'],
                        quantity: tableHeader['QUANTITY']
                    },
                    onsuccess: function (data) {
                        let result = JSON.parse(data);
                        if(result[Object.keys(result)[0]]['msg']){
                            let errorText = '<div class="bitrix-error"><label class="validation-invalid-label errortext">' + result[Object.keys(result)[0]]['msg'] + '</label></div>';
                            errorBlock.innerHTML = errorText;
                        }
                        else{
                            var request = BX.ajax.runComponentAction('sotbit:b2bcabinet.ordertemplate.add', 'addProductOrderTemplate', {
                                mode: 'class',
                                data: {
                                    data: data,
                                    fileId: file['file_id'],
                                }
                            });

                            request.then(function (response) {
                                let templateId = response.data;

                                document.location.replace(path_to_detail.replace("#ID#", templateId));
                            });
                            errorBlock.innerHTML = "";
                       }
                        setExcelOutIconImport("icon-upload mr-2");
                    },
                });
            }, 15);
        }
    });

    function setExcelOutIconImport(icon) {
        let iconContainer = document.querySelectorAll("#mfi-mfiEXCEL_FILE-button > span > i");
        for (let i = 0; i < iconContainer.length; i++) {
            iconContainer[i].setAttribute("class", icon);
        }
    }
}


