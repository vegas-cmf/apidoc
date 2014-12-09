{% if method['responseExample'] is defined and method['responseExample']|length > 0 %}
    <h4>Response body example</h4>
    <pre><code class="{% if method['responseFormat'] is defined and method['responseExample'] is defined %}{{ method['responseFormat']|lower }}{% endif %}">{{ method['responseExample'] }}</code></pre>
{% endif %}