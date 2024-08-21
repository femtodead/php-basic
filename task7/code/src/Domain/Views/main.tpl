<!DOCTYPE html>
<html>
    <head>
        <title>{{ title }}</title>
    </head>
    <body>
    {{ xdebug | raw }}

        <div id="header">
            {% include "auth-template.tpl" %}
        </div>
        <div id="menu">
            <a href="/">Главная</a>
            <a href="/user">Пользователи</a>
            <a href="/user/edit">Добавить пользователя</a>
        </div>
        {% include content_template_name %}
    </body>
</html>