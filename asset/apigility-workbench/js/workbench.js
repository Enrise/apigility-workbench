$(document).ready(function() {
    workBench.init();
});


var workBench = {
    init: function()
    {
        $('.submit').click(workBench.submit);
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
        $form.remove('.response');

        var html = '';
        for (key in response) {
            html += key + ' : ' + response[key] + '<br>';
        }

        var responseElement = $('<div class="response">' + html + '</div>')
        $form.append(responseElement);
    }
}
