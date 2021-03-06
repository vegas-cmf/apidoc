{% if method['responseCodes'] is defined and method['responseCodes'] is type('array') and method['responseCodes']|length > 0 %}
    <h4>Responses</h4>
    <table class="table table-bordered table-hover">
        <tr>
            <th>Code</th>
            <th>Type</th>
            <th>Description</th>
        </tr>
        {% for responseCode in method['responseCodes'] %}
            <tr>
                {% if responseCode['code'] < 200 %}
                <td><span class="label label-info">{{ responseCode['code'] }}</span></td>
                <td>Informational</td>
                {% endif %}
                {% if responseCode['code'] >= 200 and responseCode['code'] < 300 %}
                <td><span class="label label-success">{{ responseCode['code'] }}</span></td>
                <td>Success</td>
                {% endif %}
                {% if responseCode['code'] >= 300 and responseCode['code'] < 400 %}
                <td><span class="label label-default">{{ responseCode['code'] }}</span></td>
                <td>Redirection</td>
                {% endif %}
                {% if responseCode['code'] >= 400 and responseCode['code'] < 500 %}
                <td><span class="label label-warning">{{ responseCode['code'] }}</span></td>
                <td>Client Error</td>
                {% endif %}
                {% if responseCode['code'] >= 500 and responseCode['code'] %}
                <td><span class="label label-danger">{{ responseCode['code'] }}</span></td>
                <td>Server Error</td>
                {% endif %}
                <td>{{ responseCode['description'] }}</td>
            </tr>
        {% endfor %}
    </table>
{% endif %}