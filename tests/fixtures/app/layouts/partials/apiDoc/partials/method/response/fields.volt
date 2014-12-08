<td>
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Description</th>
        </tr>
        <tr>
            <td><code>{{ nestedResponse['name'] }}</code></td>
            <td><i>{{ nestedResponse['type'] }}</i></td>
            <td>{{ nestedResponse['description'] }}</td>
            {% if nestedResponse['fields'] is defined %}
            <td class="nested">
                Fields
                <table>
                    <tr>
                        {{ partial('apiDoc/partials/method/response/fields', ['nestedResponse': nestedResponse['fields']]) }}
                    </tr>
                </table>
            </td>
            {% endif %}
        </tr>
    </table>
</td>