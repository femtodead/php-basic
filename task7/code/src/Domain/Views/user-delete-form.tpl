{% extends "base.twig" %}

{% block title %}Удаление пользователя{% endblock %}

{% block content %}
    <h1>Удаление пользователя</h1>
    
    {% if user %}
        <p>Вы действительно хотите удалить пользователя <strong>{{ user.username }} {{ user.lastname }}</strong>?</p>
        
        <form method="POST" action="/user/remove">
            <input type="hidden" name="csrf_token" value="{{ csrf_token }}">
            <input type="hidden" name="id" value="{{ user.id }}">
            
            <button type="submit" class="btn btn-danger">Удалить</button>
            <a href="/user/index" class="btn btn-secondary">Отмена</a>
        </form>
    {% else %}
        <p>Пользователь не найден.</p>
    {% endif %}
{% endblock %}