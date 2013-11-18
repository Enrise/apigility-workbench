$(document).ready(function() {
    console.log("start");
    var parsedRoutes = parseRoutes(routes, zf_rest);
    initResources(parsedRoutes);
});

function initResources(parsedRoutes)
{
    var options = [];
    for (var route in parsedRoutes)
    {
        options.push($('<option>'  + parsedRoutes[route].name + '</option>'));
    }
    console.log(options);
    $('#resources').append(options);
}

function parseRoutes(routes, zf_rest)
{
    var parsedRoutes = [];
    for (route in routes)
    {
        name = route;
        route = routes[route];

        var parsedRoute = {
            "name": name,
            "route": route
        }

        parsedRoutes.push(parsedRoute);
    }

    return parsedRoutes;
}