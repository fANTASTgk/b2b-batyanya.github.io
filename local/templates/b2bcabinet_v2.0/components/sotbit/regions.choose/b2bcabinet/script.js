class RegionsChoose {

    constructor() {

        this.getRegion();

        this.rootId = 'regions_choose_component';
        this.rootDropDownId = 'regions_choose_component_dropdown';
        this.selectRegionID = 'regions_choose_select-city__modal';
    
        this.questionRegionId = null;
        this.loctionList = null;

        this.root = document.getElementById(this.rootId);
        this.rootDropDown = document.getElementById(this.rootDropDownId);
        this.selectRegion = document.getElementById(this.selectRegionID);

        this.setEvents();
    }

    getEntity(parent, entity, all=false) {
        if (!parent || !entity) {
            return null;
        }
        if (all) {
            return parent.querySelectorAll('[data-entity="' + entity + '"]');
        }
        return parent.querySelector('[data-entity="' + entity + '"]');
    }

    setEvents() {
        document.body.appendChild(this.selectRegion);

        const yesBtn = this.getEntity(this.rootDropDown, 'select-city__dropdown__choose__yes');
        const notBnt = this.getEntity(this.rootDropDown, 'select-city__dropdown__choose__no');
        const searchLine = this.getEntity(this.selectRegion, 'select-city__modal__submit__input');
        const selectRegionBtn = this.getEntity(this.selectRegion, 'select-city__modal__submit__btn');

        yesBtn.addEventListener('click', () => this.onSetRegion(this.questionRegionId));
        notBnt.addEventListener('click', () => this.onShowALLRegions());
        this.root.addEventListener('click', () => this.onShowALLRegions());
        searchLine.addEventListener('input', e => this.onInputSearch(e))

        selectRegionBtn.addEventListener('click', () => {
            const selectedRegion = Object.keys(this.loctionList)
                .filter(i => searchLine.value === this.loctionList[i]);

            if (selectedRegion.length === 0) {
                this.getEntity(this.selectRegion, 'select-city__modal__submit__block-wrap__input_wrap_error')
                    .setAttribute('style', '');
                return;
            }

            this.onSetRegion(selectedRegion[0]);
            this.onShowALLRegions(false);
        })


        let observer = new MutationObserver(mutationRecords => {
            mutationRecords.forEach((element) => {
                if (element.type === 'attributes' && element.attributeName === 'class') {
                    this.toggleCity();
                }
            });
        });

        observer.observe(this.selectRegion, {
            attributes: true,
            characterDataOldValue: true
        });

    }

    onSetRegion(regionId) {
        BX.ajax.runAction('sotbit:regions.ChooseComponentController.setRegion', {
            data: {regionId: regionId},
        }).then(
            (res) => res.data.actions.forEach(i => this[i](res.data)),
            (err) => console.log(err),
        )
    }

    dropDownShow(action) {
        if (action) {
            this.rootDropDown.setAttribute('style', 'display: block;');
        } else {
            this.rootDropDown.setAttribute('style', 'display: none;');
        }
    }

    onShowALLRegions() {

        if (this.loctionList !== null) {
            return this.SHOW_SELECT_REGIONS(this.loctionList);
        }

        BX.ajax.runAction('sotbit:regions.ChooseComponentController.showLocations', {})
            .then(
                (res) => res.data.actions.forEach(i => this[i](res.data)),
                (err) => console.log(err),
            )
    }

    getRegion() {

        const query = new URLSearchParams(window.location.search);

        this.removeRegionGetParams(query);

         BX.ajax.runAction('sotbit:regions.ChooseComponentController.getRegion', {
            data: {redirectRegionId: query.get('redirectRegionId')},
        })
        .then(
            (res) => res.data.actions.forEach(i => this[i](res.data)),
            (err) => console.log(err),
        )

    }

    SHOW_REGION_NAME ({currentRegionName}) {
        const elment = this.getEntity(this.root, 'select-city__block__text-city');
        elment.innerText = currentRegionName;
        this.getEntity(this.selectRegion, 'select-city__js').innerText = currentRegionName;
    }

    SHOW_QUESTION ({currentRegionName, currentRegionId}) {
        this.questionRegionId = currentRegionId;
        this.dropDownShow(true);
        const element = this.getEntity(this.rootDropDown, 'select-city__dropdown__title');
        element.innerText = element.textContent.replace('###', currentRegionName).trim();
    }

    CONFIRM_DOMAIN ({currentRegionName}) {
        this.dropDownShow(false);
        const elemnt = this.getEntity(this.root, 'select-city__block__text-city');
        elemnt.innerText = currentRegionName;
        this.getEntity(this.selectRegion, 'select-city__js').innerText = currentRegionName;
    }

    SHOW_SELECT_REGIONS ({allRegions}) {

        if (this.loctionList !== null) {
            return;
        }

        const localRootElement = this.getEntity(this.selectRegion, 'select-city__modal__list');

        this.loctionList = allRegions;

        let counter = 0;

        for (let i in allRegions) {
            const element = document.createElement('li');
            element.setAttribute('data-entity', 'select-city__modal__list__item');
            element.setAttribute('class', 'select-city__modal__list__item');
            element.innerText = allRegions[i];
            element.addEventListener('click', () => {
                this.onSetRegion(i);
            });
            localRootElement.append(element);
            counter++;
            if (counter > 14) {
                return;
            }
        }
    }

    REDIRECT_TO_SUBDOMAIN ({currentRegionCode, currentRegionId}) {
        const hostName = window.location.hostname;
        const protocol = window.location.protocol;
        const newUrl = window.location.href.replace(hostName, currentRegionCode);
        const url = new URL(newUrl, `${protocol}${currentRegionCode}`);
        url.searchParams.set('redirectRegionId', currentRegionId);
        window.location.href = url.toString();
    }

    CONFIRM_CITY ({}) {
    }

    onInputSearch(e) {

        const elementClass = 'regions_vars';
        this.getEntity(this.selectRegion, elementClass, true).forEach(i => i.remove());
        const text = e.currentTarget.value;
        const localRootElement = this.getEntity(this.selectRegion, 'select-city__modal__submit__vars');
        this.getEntity(this.selectRegion, 'select-city__modal__submit__block-wrap__input_wrap_error')
            .setAttribute('style', 'display: none;');

        if (text.length  < 2) {
            localRootElement.setAttribute('style', 'display: none;');
            return;
        }

        const currentTarget = e.currentTarget;

        const match = Object.keys(this.loctionList).filter(i => {
            return  new RegExp('^' + text, 'i').test(this.loctionList[i])
        });

        if (match.length > 0) {
            localRootElement.setAttribute('style', 'display: block;');
        } else {
            localRootElement.setAttribute('style', 'display: none;');
        }

        match.forEach(i => {
            const element = document.createElement('div');
            element.setAttribute('data-entity', elementClass);
            element.setAttribute('class', elementClass);
            element.setAttribute('tabindex', 0);
            element.innerHTML = '<b>' + this.loctionList[i].slice(0, text.length) +'</b>' + this.loctionList[i].slice(text.length);
            element.addEventListener('click', () => {
                currentTarget.value = this.loctionList[i];
                this.getEntity(this.selectRegion, elementClass, true).forEach(i => i.remove());
                localRootElement.setAttribute('style', 'display: none;');
            });
            localRootElement.append(element);
        })
    }

    removeRegionGetParams(query) {
        if (query.has('redirectRegionId')) {
            const url = new URL(window.location.href, window.location.href);
            url.searchParams.delete('redirectRegionId');
            window.history.replaceState(null, '', url)
        }
    }

    toggleCity() {
        this.getEntity(this.root, 'select-city').classList.toggle('show');
    }
}