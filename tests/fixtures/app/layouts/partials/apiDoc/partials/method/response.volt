{% if method['response'] is defined and method['response'] is type('array') and method['response']|length > 0 %}
    <h4>Response</h4>
    <table class="table table-bordered table-hover">
        {#{% if method['response'][0][0] is defined %}#}
            {% for response in method['response'] %}
                <tr>
                {% if response[0] is not defined %}

                {% else %}
                    {% for nestedResponse in response %}
                        {% if nestedResponse[0] is defined and nestedResponse[0] is type('array') %}
                            {% for nested in nestedResponse %}
                                {{ partial('apiDoc/partials/method/response/fields', ['nestedResponse': nested]) }}
                            {% endfor %}
                            {#{{ dump(response) }}#}
                        {% else %}
                            {{ dump(nestedResponse) }}
                            {{ partial('apiDoc/partials/method/response/fields', ['nestedResponse': nestedResponse]) }}
                        {% endif %}
                    {% endfor %}
                {% endif %}
                </tr>
            {% endfor %}
        {#{% else %}#}
            {#<tr>#}
                {#<th>Name</th>#}
                {#<th>Type</th>#}
                {#<th>Description</th>#}
            {#</tr>#}
            {#{% for response in method['response'] %}#}
                {#<tr>#}
                    {#<td><code>{{ response['name'] }}</code></td>#}
                    {#<td><i>{{ response['type'] }}</i></td>#}
                    {#<td>{{ response['description'] }}</td>#}
                {#</tr>#}
            {#{% endfor %}#}
        {#{% endif %}#}
    </table>
{% endif %}