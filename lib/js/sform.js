let SForm = function(options) {

    /* default message displayed when input has invalid value */
    const DEFAULT_INVALID_MESSAGE = '適切な値を入力してください。';


    /* function for check validity on each input(s) */
    this.checkValidityOf = function(elm) {
        const self = this;

        /* check html 5standard validity first (required, pattern, min, max, step, etc.) */
        if(!elm.reportValidity()) return;
        
        /* check custom validity */
        const func = this.getValidateStatus[elm.name];
        if(typeof(func) == 'function'){

            /* call custom function of check validity and get message about invalid value */
            /* 1st: target element, 2nd: callback funciton (use when need ajax) */
            const ret = func(elm, function() {
                self.setValidationState(elm);
            });

            /* if returns undefined, no validation currently (it may done with callback function) */
            if(ret != undefined) this.setValidationState(elm);

        }
        
    }


    /* callback function for validity on each input(s) */
    this.setValidationState = function(elm) {

        /* if returns null or true or empty string, elm has not invalid values so release invalid state */
        if(ret == null || ret == true || ret == '') {
            elm.setCustomValidity('');
        }
        else{
            /* if returns false, use default message */
            elm.setCustomValidity((ret != false) ? ret : DEFAULT_INVALID_MESSAGE);
        }

    }


    /* check validity of each inputs */
    this.checkAllValidity = function() {
        const f = this.elm_form;

        /* cannot use forEach here */
        for (var i = 0; i < f.length; i++) {
            if(!this.checkValidityOf(f.elements[i])) return false;
        }

        return true;
    };

    /* get form values with name key */
    this.getValues = function() {

        let values = {};
        this.elm_form.elements.forEach(function(elm){
            values[elm.name] = elm.value;
        });

        return values;
    };


    /* set form values by array */
    this.setValues = function(values) {
        this.elm_form.elements.forEach(function(elm){
            elm.value = values[elm.name];
        });
    };


    /* submit form with ajax */
    this.submit = function() {

        if(this.checkAllValidity()) {

            Ajax.load(
                this.action,
                this.method,
                $.extend(this.getValues(), this.params),
                this.submit_callback
            );

        }

    };



////////---------------- CONSTRUCTOR BEG ----------------////////

    /* target form element */
    let elm_form = options.form;

    /* form method (GET/POST) */
    let method = options.method;

    /* url of submission */
    let submit_url = options.submit_url;

    /* url of confirmation */
    let confirm_url = options.confirm_url;

    /* additional parameters */
    let params = options.params;

    /* callback function when submit form */
    let submit_callback = options.submit_callback;

    /* list of 'getValidateStatus' function on each inputs  */
    let getValidateStatus = options.validate_function;

    /* element of edit form */
    let 

    const self = this;

    /* add onchange event to each inputs */
    this.elm_form.elements.forEach(function(elm){

        /* check inputted value */
        elm.addEventListener('change', function(ev){
            self.checkValidityOf(ev.target);
        });

    });

    /* set default parameters */
    this.setValues(this.params);

////////---------------- CONSTRUCTOR END ----------------////////

};



