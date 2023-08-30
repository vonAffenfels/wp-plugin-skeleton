import $ from 'jquery';

export function ajaxRequest(action, params, successCb, errorCb)
{
    if (!window['vaf_admin_ajax']) {
        console.error('No admin ajax actions configured!');
        return;
    }

    if (!window['vaf_admin_ajax'][action]) {
        console.error('Action ' + action + ' not configured!');
        return;
    }

    if (!window['vaf_admin_ajax'][action]['ajaxurl']) {
        console.error('AJAX URL for action ' + action + ' not configured!');
        return;
    }

    $.ajax({
        url: window['vaf_admin_ajax'][action]['ajaxurl'],
        type: 'post',
        data: Object.assign(params, window['vaf_admin_ajax'][action]['data']),
        success: function (response) {
            if (response.success) {
                successCb(response.data);
            } else {
                errorCb(response.message);
            }
        },
        error: function (request, status, error) {
            const json = request['responseJSON'] || {};
            errorCb(json.message || error);
        }
    })
}