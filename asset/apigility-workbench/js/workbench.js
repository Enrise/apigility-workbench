$(document).ready(function() {
    workBench.init();
});


var workBench = {
    init: function()
    {
        $('.submit').click(workBench.submit);
        $('.toggler').click(function() {
            var $div = $('#' + $(this).attr('data-endpoint-div'));
            $div.toggleClass('hidden');
        });
    },

    submit: function()
    {
        var form = $(this).parents('form');
        var data  = form.serializeArray();

        var options = {
            'url': form.attr('action'),
            'method': 'POST',
            'success': function(response) { workBench.handleResponse(response, form); },
            'data' : data
        }

        $.ajax(options);

        return false;
    },

    handleResponse: function(response, $form)
    {
        $form.find('.response').remove();

        var isJSON = false;
        var headers = '';
        for (header in response.response.headers) {
            headers += header + ': ' + response.response.headers[header] + '\n'
            if (header == 'Content-Type' && response.response.headers[header].indexOf('json') >= 0) {
                isJSON = true;
            }
        }

        var body = response.response.body;

        if (isJSON) {
            body = JSON.stringify(JSON.parse(body), undefined, 2);
        }

        var html = '';
        if (response.response.statusCode >= 500 || response.response.statusCode == 404) {
            html += '<img src="/apigility-workbench/img/zombie-elephant.jpg" alt="zombie elephant">';
        }
        html += '<div style="opacity: 1;" id="getGeneralCountries_sandbox_response" class="response">' +
        '    <h4>Response Code</h4>' +
        '    <div class="response_code">' +
        '        <pre>' + response.response.statusCode + '</pre>' +
        '    </div>' +
        '    <h4>Response Body</h4>' +
        '    <div class="response_body">' +
        '        <pre>' + body + '</pre>' +
        '    </div>' +
        '    <h4>Response Headers</h4>' +
        '    <div class="response_headers">' +
        '        <pre>' + headers + '</pre>' +
        '    </div>' +
        '    <h4>Request URL</h4>' +
        '    <div class="request_url">' +
        '        <pre>' + response.request.requesturi + '</pre>' +
        '    </div>' +
        '    <h4>Last Request</h4>' +
        '    <div class="request_last">' +
        '        <pre>' + response.request.requeststring + '</pre>' +
        '    </div>' +

//        '    <h4>Response Time</h4>' +
//        '    <div class="response_time">' +
//        '        <pre>0.11775898933411 seconds</pre>' +
//        '    </div>' +
        '</div>';
//        html += $.parseJSON(response.response.body);

        var responseElement = $(html)
        $form.append(responseElement);
    }
}
