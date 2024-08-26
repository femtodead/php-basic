<p>Список пользователей в хранилище</p>

<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Имя</th>
                <th scope="col">Фамилия</th>
                <th scope="col">День рождения</th>
                {% if isAdmin %}
                <td scope="col">Редактирование </td>
                <td scope="col">Удаление </td>
                {% endif %}
            </tr>
        </thead>
        <tbody>
            {% for user in users %}
            <tr>
                <td>{{ user.getUserId() }}</td>
                <td>{{ user.getUserName() }}</td>
                <td>{{ user.getUserLastName() }}</td>
                <td>{% if user.getUserBirthday() is not empty %}
                    {{ user.getUserBirthday() | date('d.m.Y') }}
                    {% else %}
                    <b>Не задан</b>
                    {% endif %}
                </td>
                {% if isAdmin %}
                <td scope="col"><a href="/user/edit/?id_user={{user.getUserId()}}">Редактирование</a></td>
                <td scope="col"><a href="javascript:void(0);" onclick="deleteUser({{user.getUserId()}})">Удаление</a></td>
                {% endif %}
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
<input type="hidden" id="isAdmin" value="{{ isAdmin ? 'true' : 'false' }}">
<script>
    let maxId = $('.table-responsive tbody tr:last-child td:first-child').html();
    let isAdmin = $('#isAdmin').val() === 'true';
    setInterval(function () {
      $.ajax({
          method: 'POST',
          url: "/user/indexRefresh/",
          data: { maxId: maxId }
      }).done(function (response) {
          // $('.content-template').html(response);
          let users = $.parseJSON(response);
          console.log(users);
          
          if(users.length != 0){
            for(var k in users){

              let row = "<tr>";

              row += "<td>" + users[k].id + "</td>";
              maxId = users[k].id;

              row += "<td>" + users[k].username + "</td>";
              row += "<td>" + users[k].userlastname + "</td>";
              row += "<td>" + users[k].userbirthday + "</td>";
               if(isAdmin) {
              row += "<td scope='col'><a href='/user/edit/?id_user={{user.getUserId()}}'> Редактирование </a></td>"
              row += "<td scope='col'><a href='/user/deluser/?user-id={{user.getUserId()}}'> Удаление </a></td>"
               }
              row += "</tr>";

              $('.content-template tbody').append(row);
            }
            
          }
          
      });
    }, 10000);
function deleteUser(userId) {
    if (confirm("Вы уверены, что хотите удалить этого пользователя?")) {
        // Задержка в 2 секунды (2000 миллисекунд)
        setTimeout(function() {
            $.ajax({
                method: 'POST',
                url: '/user/del/', // URL для удаления пользователя
                data: { id: userId },
                success: function(response) {
                    // Удаляем строку из таблицы после успешного удаления
                    $('tr').filter(function() {
                        return $(this).find('td:first').text() == userId;
                    }).remove();
                },
                error: function() {
                    alert("Ошибка при удалении пользователя.");
                }
            });
        }, 2000); // 2000 миллисекунд = 2 секунды
    }
}
</script>