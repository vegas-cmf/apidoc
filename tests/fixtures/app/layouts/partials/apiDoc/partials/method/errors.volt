{% if method['errors'] is defined and method['errors'] is type('array') and method['errors']|length > 0 %}
    <h4>Errors</h4>
    <table class="table table-bordered table-hover">
        <tr>
            <th>Type</th>
            <th>Description</th>
        </tr>
        {% for error in method['errors'] %}
            <tr>
                <td><code>{{ error['type'] }}</code></td>
                <td>{{ error['description'] }}</td>
            </tr>
        {% endfor %}
    </table>
{% endif %}