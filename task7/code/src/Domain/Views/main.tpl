<!DOCTYPE html>
<html>
    <head>
        <title>{{ title }}</title>
    </head>
    <body>
    <p>CSRF Token: {{ csrf_token }}</p>
        {% if user_authorized %}
        <p><a href="/user/logout">Выход</a></p>

        {% endif %}
        <div id="header">
            {% include "auth-template.tpl" %}
        </div>

        {% include content_template_name %}
    </body>
</html>