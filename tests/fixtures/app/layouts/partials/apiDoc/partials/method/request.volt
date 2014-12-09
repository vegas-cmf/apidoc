{% if method['request'] is defined and method['request'] is type('array') and method['request']|length > 0 %}
    <h4>Body</h4>
    <table class="table table-bordered table-hover">
        {% if method['request'][0][0] is defined %}
        {% for request in method['request'] %}
        <tr>
            <td>
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Description</th>
                    </tr>
                    {% for subResponse in request %}
                    <tr>
                        <td><code>{{ subResponse['name'] }}</code></td>
                        <td><i>{{ subResponse['type'] }}</i></td>
                        <td>{{ subResponse['description'] }}</td>
                    </tr>
                    {% endfor %}
                </table>
            </td>
        </tr>
        {% endfor %}
        <tr>
            <td>...</td>
        </tr>
        {% else %}
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Description</th>
        </tr>
        {% for request in method['request'] %}
        <tr>
            <td><code>{{ request['name'] }}</code></td>
            <td><i>{{ request['type'] }}</i></td>
            <td>{{ request['description'] }}</td>
        </tr>
        {% endfor %}
        {% endif %}
    </table>
{% endif %}