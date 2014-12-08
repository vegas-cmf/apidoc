{% if method['headers'] is defined and method['headers'] is type('array') and method['headers']|length > 0 %}
    <h4>Headers</h4>
    <table class="table table-bordered table-hover">
        <tr>
            <th>Name</th>
            <th>Description</th>
        </tr>
        {% for header in method['headers'] %}
            <tr>
                <td><code>{{ header['name'] }}</code></td>
                <td>{{ header['description'] }}</td>
            </tr>
        {% endfor %}
    </table>
{% endif %}