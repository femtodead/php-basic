{% extends "base.twig" %}

{% block title %}Изменение пользователя{% endblock %}

{% block content %}
    <h1>Изменение пользователя</h1>
    
    {% if user %}
        <form method="POST" action="/user/update">
            <input type="hidden" name="csrf_token" value="{{ csrf_token }}">
            <input type="hidden" name="id" value="{{ user.id }}">
            
            <div class="form-group">
                <label for="username">Имя</label>
                <input type="text" id="username" name="username" class="form-control" value="{{ user.username }}" required>
            </div>
            
            <div class="form-group">
                <label for="lastname">Фамилия</label>
                <input type="text" id="lastname" name="lastname" class="form-control" value="{{ user.lastname }}" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ user.email }}" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    {% else %}
        <p>Пользователь не найден.</p>
    {% endif %}
{% endblock %}