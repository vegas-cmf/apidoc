{% if method['params'] is defined and method['params'] is type('array') and method['params']|length > 0 %}
    <h4>Parameters</h4>
    <table class="table table-bordered table-hover">
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Description</th>
        </tr>
        {% for param in method['params'] %}
            <tr>
                <td><code>{{ param['name'] }}</code></td>
                <td><i>{{ param['type'] }}</i></td>
                <td>{{ param['description'] }}</td>
            </tr>
        {% endfor %}
    </table>
{% endif %}