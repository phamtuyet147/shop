// noinspection JSUnresolvedVariable
var $ = jQuery.noConflict();
$.fn.bstooltip = $.fn.tooltip;

// noinspection JSUnusedGlobalSymbols
var WJS = new function () {
    this.globalScope = {};
    // noinspection JSUnusedGlobalSymbols
    this.setGlobalScope = function (name, value) {
        this.globalScope[name] = value;
    };
    // noinspection JSUnusedGlobalSymbols
    this.getGlobalScope = function (name) {
        return this.globalScope[name];
    };
    this.log = function (content) {
        console.log(content);
    };
    // noinspection JSUnusedGlobalSymbols
    this.confirmDelete = function (id) {
        return confirm('Do you want to delete #' + id + ' ?');
    };
};

var WValidate = new function () {
    this.forms = {};
    this.defaultMessage = {};
    this.customRules = '';
    // noinspection JSUnusedGlobalSymbols
    this.setForms = function (value) {
        this.forms = value;
    };
    // noinspection JSUnusedGlobalSymbols
    this.setDefaultMessage = function (messages) {
        this.defaultMessage = messages;
    };
    // noinspection JSUnusedGlobalSymbols
    this.setCustomRules = function (customRules) {
        this.customRules = customRules;
    };
    this.nsResolver = function (prefix) {
        var ns = {
            'wv': 'http://linhnv.xyz/w.validator',
            'wf': 'http://linhnv.xyz/forms'
        };
        return ns[prefix] || null;
    };
    this.init = function(){
    };
    this.validateForm = function (formName) {
        if (!this.forms.hasOwnProperty(formName)) {
            return true;
        }

        var parser = new DOMParser();
        var fields = parser.parseFromString(this.forms[formName], 'text/xml').getElementsByTagName('field');
        var errorMessage;
        for (var fieldIndex in fields) {
            if (!fields.hasOwnProperty(fieldIndex)) {
                break;
            }
            var field = fields[fieldIndex];
            var fieldName = field.getAttribute('name');
            if (!document.forms[formName].elements.hasOwnProperty(fieldName)) {
                continue;
            }
            var fieldValue = document.forms[formName].elements[fieldName].value;
            var conditions = field.getAttribute('condition');
            conditions = conditions.split(',');
            field = parser.parseFromString(field.outerHTML, 'text/xml');
            for (var i in conditions) {
                if (!conditions.hasOwnProperty(i)) {
                    break;
                }
                var conditionType = conditions[i];
                conditionType = conditionType.trim();
                var conditionArguments = field.evaluate('//wf:args[@for=\'' +
                    conditionType + '\']', field, this.nsResolver, XPathResult.ANY_TYPE,
                    null);
                conditionArguments = conditionArguments.iterateNext();
                var conditionValue = 0;
                var hasError = false;
                switch (conditionType) {
                    case 'required':
                        if (fieldValue === '') {
                            hasError = true;
                        }
                        break;
                    case 'numeric':
                        if (fieldValue.match(/[^0-9]+/)) {
                            hasError = true;
                        }
                        break;
                    case 'min':
                        conditionValue = parseInt(conditionArguments);
                        if (fieldValue < conditionValue) {
                            hasError = true;
                        }
                        break;
                    case 'max':
                        conditionValue = parseInt(conditionArguments);
                        if (fieldValue > conditionValue) {
                            hasError = true;
                        }
                        break;
                    case 'min-length':
                        conditionValue = parseInt(conditionArguments);
                        if (fieldValue.length < conditionValue) {
                            hasError = true;
                        }
                        break;
                    case 'max-length':
                        conditionValue = parseInt(conditionArguments);
                        if (fieldValue.length > conditionValue) {
                            hasError = true;
                        }
                        break;
                    case 'pattern':
                        conditionValue = conditionArguments.toString();
                        var matches = conditionValue.match(/^\/(.+)\/(.*?)$/);
                        var regex = new RegExp(matches[1], matches[2]);
                        if (!fieldValue.match(regex)) {
                            hasError = true;
                        }
                        break;
                    case 'match':
                        if (conditionArguments === null) {
                            break;
                        }
                        var matchField = conditionArguments.textContent.toString();
                        if (!document.forms[formName].elements.hasOwnProperty(matchField)) {
                            break;
                        }
                        var matchValue = document.forms[formName].elements[matchField].value;
                        if (fieldValue !== matchValue) {
                            hasError = true;
                        }
                        break;
                    default:
                        if (fieldValue === '') {
                            break;
                        }
                        var customRules = parser.parseFromString(this.customRules,
                            'text/xml');
                        var pattern = customRules.evaluate('//wv:rule[wv:key="' +
                            conditionType + '"]/wv:pattern', customRules, this.nsResolver,
                            XPathResult.ANY_TYPE, null);
                        pattern = pattern.iterateNext();
                        if (pattern === null) {
                            break;
                        }
                        pattern = pattern.textContent.toString();
                        matches = pattern.match(/^\/(.+)\/(.*?)$/);
                        regex = new RegExp(matches[1], matches[2]);
                        if (!fieldValue.match(regex)) {
                            hasError = true;
                        }
                        break;
                }
                if (hasError) {
                    var messages = field.evaluate(
                        '//wf:msg[@for=\'' + conditionType + '\']', field, this.nsResolver,
                        XPathResult.ANY_TYPE, null
                    );
                    messages = messages.iterateNext();

                    errorMessage = this.getMessage(
                        fieldName, conditionType, messages,
                        conditionArguments);
                    this.raiseError(formName, fieldName, errorMessage);
                    return false;
                }
            }
        }
        return true;
    };
    this.raiseError = function (formName, fieldName, message) {
        alert(message);
    };
    this.getMessage = function (fieldName, conditionType, conditionMessage, conditionArguments) {
        var messageReturn = '';
        if (conditionMessage === null || !conditionMessage.hasAttribute('text') ||
            conditionMessage.children.length > 0) {
            if (this.defaultMessage.hasOwnProperty(conditionType)) {
                messageReturn = this.defaultMessage[conditionType];
            }
            else {
                messageReturn = this.defaultMessage['default'];
            }
        }
        else {
            messageReturn = conditionMessage.getAttribute('text').toString();
        }
        var match;
        if (conditionMessage !== null) {
            var parser = new DOMParser();
            conditionMessage = parser.parseFromString(conditionMessage.outerHTML,
                'text/xml');
        }
        while (match = messageReturn.match(/\(([0-9])\)/)) {
            var flag = parseInt(match[1]);
            var replaceValue = flag;
            if (conditionMessage !== null) {
                var msg = conditionMessage.evaluate('//wf:flag[@id=' + flag + ']',
                    conditionMessage, this.nsResolver, XPathResult.ANY_TYPE, null);
                msg = msg.iterateNext();
                if (msg !== null) {
                    replaceValue = msg.textContent.toString();
                }
            }
            else {
                switch (flag) {
                    case 1:
                        replaceValue = fieldName;
                        break;
                    case 2:
                        if (conditionArguments !== null &&
                            conditionArguments.children.length === 0) {
                            replaceValue = conditionArguments.textContent.toString();
                        }
                        break;
                }
            }
            messageReturn = messageReturn.replace(match[0], replaceValue.toString());
        }
        return messageReturn;
    };
};

$(document).ready(function () {
    $('form').on('submit', function () {
        $(this).find('.has-error').removeClass('has-error');
        $('#message').html('');
        if (!this.hasAttribute('name')) {
            return true;
        }
        return WValidate.validateForm(this.attributes['name'].value);
    });
});